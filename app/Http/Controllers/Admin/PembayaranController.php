<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Pembayaran;
use App\Models\Transaksi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;

class PembayaranController extends Controller
{
    public function index(Request $request)
    {
        $filters = [
            'search' => $request->search,
            'status' => $request->status,
            'metode' => $request->metode,
            'period' => $request->period,
            'date_from' => $request->date_from,
            'date_to' => $request->date_to,
        ];

        // Set default period ke this month jika tidak ada filter
        if (empty($filters['period']) && empty($filters['date_from'])) {
            $filters['period'] = 'this_month';
        }

        $pembayaran = Pembayaran::with(['transaksi.pelanggan', 'transaksi.mobil', 'dibuatOleh'])
            ->filter($filters)
            ->latest()
            ->paginate(15);

        $statistik = [
            'total' => Pembayaran::filter($filters)->count(),
            'pending' => Pembayaran::filter($filters)->where('status', 'pending')->count(),
            'terkonfirmasi' => Pembayaran::filter($filters)->where('status', 'terkonfirmasi')->count(),
            'gagal' => Pembayaran::filter($filters)->where('status', 'gagal')->count(),
            'refund' => Pembayaran::filter($filters)->where('status', 'refund')->count(),
            'total_nilai' => Pembayaran::filter($filters)->where('status', 'terkonfirmasi')->sum('jumlah'),
        ];

        return view('admin.pembayaran.index', compact('pembayaran', 'filters', 'statistik'));
    }

    public function show(Pembayaran $pembayaran)
    {
        $pembayaran->load(['transaksi.pelanggan', 'transaksi.mobil', 'dibuatOleh']);

        return view('admin.pembayaran.show', compact('pembayaran'));
    }

    public function create(Request $request)
    {
        $transaksi = null;

        if ($request->has('transaksi_id')) {
            $transaksi = Transaksi::with(['pelanggan', 'mobil', 'pembayaran'])->findOrFail($request->transaksi_id);
        }

        return view('admin.pembayaran.create', compact('transaksi'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'transaksi_id' => 'required|exists:transaksi,id',
            'jumlah' => 'required|numeric|min:1',
            'metode' => 'required|in:transfer,tunai,qris,kartu,ewallet',
            'status' => 'required|in:pending,terkonfirmasi',
            'tanggal_bayar' => 'required|date',
            'bukti_bayar' => 'nullable|image|max:2048',
            'catatan' => 'nullable|string|max:1000',
        ]);

        DB::beginTransaction();
        try {
            $transaksi = Transaksi::findOrFail($request->transaksi_id);

            // Validasi jumlah pembayaran tidak melebihi sisa tagihan
            $sisaTagihan = $transaksi->sisa_pembayaran;
            if ($request->jumlah > $sisaTagihan) {
                return back()->withErrors(['jumlah' => 'Jumlah pembayaran melebihi sisa tagihan (Rp ' . number_format($sisaTagihan, 0, ',', '.') . ')'])->withInput();
            }

            $data = $request->only(['transaksi_id', 'jumlah', 'metode', 'status', 'tanggal_bayar', 'catatan']);
            $data['dibuat_oleh'] = auth()->id();

            // Handle file upload
            if ($request->hasFile('bukti_bayar')) {
                $data['bukti_bayar'] = $request->file('bukti_bayar')->store('pembayaran', 'public');
            }

            $pembayaran = Pembayaran::create($data);

            // Update status pembayaran transaksi
            $this->updateStatusPembayaranTransaksi($transaksi);

            DB::commit();

            return redirect()->route('admin.pembayaran.show', $pembayaran)
                ->with('success', 'Pembayaran berhasil ditambahkan');
        } catch (\Exception $e) {
            DB::rollback();
            return back()->withErrors(['error' => 'Gagal menambahkan pembayaran: ' . $e->getMessage()])->withInput();
        }
    }

    public function edit(Pembayaran $pembayaran)
    {
        $pembayaran->load(['transaksi.pelanggan', 'transaksi.mobil']);

        return view('admin.pembayaran.edit', compact('pembayaran'));
    }

    public function update(Request $request, Pembayaran $pembayaran)
    {
        $request->validate([
            'jumlah' => 'required|numeric|min:1',
            'metode' => 'required|in:transfer,tunai,qris,kartu,ewallet',
            'status' => 'required|in:pending,terkonfirmasi,gagal,refund',
            'tanggal_bayar' => 'required|date',
            'bukti_bayar' => 'nullable|image|max:2048',
            'catatan' => 'nullable|string|max:1000',
        ]);

        DB::beginTransaction();
        try {
            $data = $request->only(['jumlah', 'metode', 'status', 'tanggal_bayar', 'catatan']);

            // Handle file upload
            if ($request->hasFile('bukti_bayar')) {
                // Hapus file lama jika ada
                if ($pembayaran->bukti_bayar) {
                    Storage::disk('public')->delete($pembayaran->bukti_bayar);
                }
                $data['bukti_bayar'] = $request->file('bukti_bayar')->store('pembayaran', 'public');
            }

            $pembayaran->update($data);

            // Update status pembayaran transaksi
            $this->updateStatusPembayaranTransaksi($pembayaran->transaksi);

            DB::commit();

            return redirect()->route('admin.pembayaran.show', $pembayaran)
                ->with('success', 'Pembayaran berhasil diupdate');
        } catch (\Exception $e) {
            DB::rollback();
            return back()->withErrors(['error' => 'Gagal mengupdate pembayaran: ' . $e->getMessage()])->withInput();
        }
    }

    public function updateStatus(Request $request, Pembayaran $pembayaran)
    {
        $request->validate([
            'status' => 'required|in:pending,terkonfirmasi,gagal,refund',
        ]);

        DB::beginTransaction();
        try {
            $pembayaran->update([
                'status' => $request->status,
            ]);

            // Update status pembayaran transaksi
            $this->updateStatusPembayaranTransaksi($pembayaran->transaksi);

            DB::commit();

            return back()->with('success', 'Status pembayaran berhasil diupdate');
        } catch (\Exception $e) {
            DB::rollback();
            return back()->withErrors(['error' => 'Gagal mengupdate status pembayaran: ' . $e->getMessage()]);
        }
    }

    public function destroy(Pembayaran $pembayaran)
    {
        DB::beginTransaction();
        try {
            $transaksi = $pembayaran->transaksi;

            // Hapus file bukti bayar jika ada
            if ($pembayaran->bukti_bayar) {
                Storage::disk('public')->delete($pembayaran->bukti_bayar);
            }

            $pembayaran->delete();

            // Update status pembayaran transaksi
            $this->updateStatusPembayaranTransaksi($transaksi);

            DB::commit();

            return redirect()->route('admin.pembayaran.index')
                ->with('success', 'Pembayaran berhasil dihapus');
        } catch (\Exception $e) {
            DB::rollback();
            return back()->withErrors(['error' => 'Gagal menghapus pembayaran: ' . $e->getMessage()]);
        }
    }

    private function updateStatusPembayaranTransaksi(Transaksi $transaksi)
    {
        $totalTerkonfirmasi = $transaksi->pembayaran()->where('status', 'terkonfirmasi')->sum('jumlah');

        if ($totalTerkonfirmasi <= 0) {
            $statusPembayaran = 'belum_bayar';
        } elseif ($totalTerkonfirmasi >= $transaksi->total) {
            $statusPembayaran = 'lunas';
        } else {
            $statusPembayaran = 'sebagian';
        }

        $transaksi->update(['status_pembayaran' => $statusPembayaran]);
    }
}
