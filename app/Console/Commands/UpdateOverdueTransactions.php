<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Transaksi;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;

class UpdateOverdueTransactions extends Command
{
    protected $signature = 'transaksi:update-overdue';
    protected $description = 'Update status dan hitung denda untuk transaksi yang telat';

    public function handle()
    {
        $now = Carbon::now();
        $this->info('Memulai pengecekan transaksi telat pada: ' . $now->format('Y-m-d H:i:s'));

        try {
            DB::beginTransaction();

            // Cari transaksi yang masih berjalan dan sudah melewati batas waktu
            $overdueTransactions = Transaksi::with(['hargaSewa.jenissewa', 'mobil'])
                ->where('status', 'berjalan')
                ->where('tanggal_kembali', '<', $now)
                ->get();

            $count = 0;
            foreach ($overdueTransactions as $transaksi) {
                $this->processOverdueTransaction($transaksi, $now);
                $count++;
            }

            DB::commit();

            // Log ringkasan eksekusi
            $message = "Berhasil memproses {$count} transaksi telat";
            $this->info($message);
            Log::info($message);

            return 0;

        } catch (\Exception $e) {
            DB::rollBack();
            $error = "Error saat memproses transaksi telat: " . $e->getMessage();
            $this->error($error);
            Log::error($error);
            return 1;
        }
    }

    protected function processOverdueTransaction(Transaksi $transaksi, Carbon $now)
    {
        // Hitung durasi keterlambatan
        $seharusnyaKembali = Carbon::parse($transaksi->tanggal_kembali);
        $keterlambatanFloat = $seharusnyaKembali->diffInRealDays($now);
        $keterlambatan = (int) floor($keterlambatanFloat);

        $this->info('--- Processing Transaksi #' . $transaksi->no_transaksi . ' ---');
        $this->info('Keterlambatan: ' . $keterlambatan . ' hari');

        if ($keterlambatan <= 0) {
            return;
        }

        $hargaPerHari = $transaksi->hargaSewa->harga;
        $dendaPerHari = $transaksi->hargaSewa->jenissewa->tarif_denda_per_hari;
        $totalDenda = $dendaPerHari * $keterlambatan;

        // Update data transaksi
        $updates = [
            'status' => 'telat',
            'status_pembayaran' => 'sebagian',
            'denda' => $totalDenda,
            'total' => $transaksi->subtotal + $transaksi->biaya_tambahan + $totalDenda + $transaksi->denda_manual,
            'updated_at' => $now
        ];

        $transaksi->update($updates);

        // Log detail transaksi telat
        $logMessage = sprintf(
            'Transaksi #%s telat %d hari. Denda: Rp %s (Rp %s/hari). Total: Rp %s',
            $transaksi->no_transaksi,
            $keterlambatan,
            number_format($totalDenda),
            number_format($dendaPerHari),
            number_format($updates['total'])
        );

        $this->info($logMessage);
        Log::info($logMessage);

        // Update status mobil jika diperlukan
        if ($transaksi->mobil) {
            $transaksi->mobil->update([
                'status' => 'disewa' // Pastikan status tetap disewa karena mobil belum dikembalikan
            ]);
        }
    }
}
