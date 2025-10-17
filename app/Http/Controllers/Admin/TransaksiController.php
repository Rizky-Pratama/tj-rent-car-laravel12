<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Transaksi;
use App\Models\Pelanggan;
use App\Models\Mobil;
use App\Models\HargaSewa;
use App\Models\Sopir;
use App\Models\Pembayaran;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class TransaksiController extends Controller
{
    public function index(Request $request)
    {
        // Ambil semua parameter filter
        $filters = $request->only([
            'period', 'date_from', 'date_to', 'status', 'payment_status',
            'mobil_id', 'sopir_id', 'jenis_sewa', 'min_total', 'max_total', 'search'
        ]);

        // Set default period ke today jika tidak ada filter
        if (empty($filters['period']) && empty($filters['date_from'])) {
            $filters['period'] = 'today';
        }

        // Query dengan filter menggunakan scope
        $query = Transaksi::with(['pelanggan', 'mobil', 'hargaSewa.jenisSewa', 'sopir'])
                          ->filter($filters)
                          ->orderBy('created_at', 'desc');

        $transaksi = $query->paginate(15)->appends($request->query());

        // Hitung statistik dengan filter yang sama
        $statistik = [
            'total' => Transaksi::filter($filters)->count(),
            'pending' => Transaksi::filter($filters)->where('status', 'pending')->count(),
            'dibayar' => Transaksi::filter($filters)->where('status', 'dibayar')->count(),
            'berjalan' => Transaksi::filter($filters)->where('status', 'berjalan')->count(),
            'telat' => Transaksi::filter($filters)->where('status', 'telat')->count(),
            'selesai' => Transaksi::filter($filters)->where('status', 'selesai')->count(),
            'dibatalkan' => Transaksi::filter($filters)->where('status', 'dibatalkan')->count(),
        ];

        // Data untuk dropdown filter
        $mobils = Mobil::select('id', 'merk', 'model', 'plat_nomor')->orderBy('merk')->get();
        $sopirs = Sopir::select('id', 'nama')->where('status', 'aktif')->orderBy('nama')->get();
        $jenisSewaList = \App\Models\JenisSewa::select('id', 'nama_jenis')->orderBy('nama_jenis')->get();

        return view('admin.transaksi.index', compact(
            'transaksi', 'statistik', 'mobils', 'sopirs', 'jenisSewaList', 'filters'
        ));
    }

    public function create()
    {
        // Get customers with additional info for smart selection
        $pelanggan = Pelanggan::where('status', 'aktif')
            ->select('id', 'nama', 'telepon', 'email', 'alamat', 'no_ktp')
            ->orderBy('nama')
            ->get();

        // Get available cars with detailed info and pricing
        $mobil = Mobil::where('status', 'tersedia')
            ->with(['hargaSewa' => function($q) {
                $q->where('aktif', true)->with('jenisSewa');
            }])
            ->select('id', 'merk', 'model', 'plat_nomor', 'tahun', 'warna', 'kapasitas_penumpang', 'foto', 'transmisi', 'jenis_bahan_bakar')
            ->orderBy('merk')
            ->orderBy('model')
            ->get();

        // Get active pricing with rental types
        $hargaSewa = HargaSewa::with(['jenisSewa', 'mobil'])
            ->where('aktif', true)
            ->join('mobil', 'harga_sewa.mobil_id', '=', 'mobil.id')
            ->where('mobil.status', 'tersedia')
            ->select('harga_sewa.*')
            ->orderBy('harga_per_hari')
            ->get()
            ->groupBy('mobil_id');

        // Get available drivers
        $sopir = Sopir::where('status', 'tersedia')
            ->orderBy('nama')
            ->get();

        // Get recent transactions for analytics
        $recentTransactions = Transaksi::with(['pelanggan:id,nama', 'mobil:id,merk,model'])
            ->where('created_at', '>=', now()->subDays(30))
            ->select('pelanggan_id', 'mobil_id', 'harga_sewa_id', 'durasi_hari', 'total')
            ->get();

        // Calculate popular choices and averages
        $analytics = [
            'popular_customers' => $recentTransactions->groupBy('pelanggan_id')
                ->map->count()
                ->sortDesc()
                ->take(5)
                ->keys()
                ->toArray(),
            'popular_cars' => $recentTransactions->groupBy('mobil_id')
                ->map->count()
                ->sortDesc()
                ->take(5)
                ->keys()
                ->toArray(),
            'avg_duration' => round($recentTransactions->avg('durasi_hari') ?: 1),
            'avg_total' => round($recentTransactions->avg('total') ?: 0),
        ];

        // Get business rules and settings
        $settings = [
            'min_rental_days' => 1,
            'max_rental_days' => 30,
            'advance_booking_days' => 90,
            'cancellation_hours' => 24,
        ];

        return view('admin.transaksi.create', compact('pelanggan', 'mobil', 'hargaSewa', 'sopir', 'analytics', 'settings'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'pelanggan_id' => 'required|exists:pelanggan,id',
            'mobil_id' => 'required|exists:mobil,id',
            'harga_sewa_id' => 'required|exists:harga_sewa,id',
            'sopir_id' => 'nullable|exists:sopir,id',
            'tanggal_sewa' => 'required|date|after_or_equal:today',
            'durasi_hari' => 'required|integer|min:1|max:30',
            'catatan' => 'nullable|string|max:1000',
        ], [
            'tanggal_sewa.after_or_equal' => 'Tanggal sewa tidak boleh kurang dari hari ini',
            'durasi_hari.min' => 'Durasi sewa minimal 1 hari',
            'durasi_hari.max' => 'Durasi sewa maksimal 30 hari',
        ]);

        try {
            DB::beginTransaction();

            // Validate availability
            $mobil = Mobil::findOrFail($request->mobil_id);
            if ($mobil->status !== 'tersedia') {
                return redirect()->back()
                    ->withErrors(['mobil_id' => 'Mobil tidak tersedia'])
                    ->withInput();
            }

            $hargaSewa = HargaSewa::findOrFail($request->harga_sewa_id);
            if (!$hargaSewa->aktif) {
                return redirect()->back()
                    ->withErrors(['harga_sewa_id' => 'Paket sewa tidak aktif'])
                    ->withInput();
            }

            $tanggalSewa = Carbon::parse($request->tanggal_sewa);
            $durasiHari = (int) $request->durasi_hari;
            $tanggalKembali = $tanggalSewa->copy()->addDays($durasiHari);

            // Check for conflicting bookings
            $conflictingBooking = Transaksi::where('mobil_id', $request->mobil_id)
                ->where('status', '!=', 'batal')
                ->where(function($q) use ($tanggalSewa, $tanggalKembali) {
                    $q->whereBetween('tanggal_sewa', [$tanggalSewa, $tanggalKembali])
                      ->orWhereBetween('tanggal_kembali', [$tanggalSewa, $tanggalKembali])
                      ->orWhere(function($q2) use ($tanggalSewa, $tanggalKembali) {
                          $q2->where('tanggal_sewa', '<=', $tanggalSewa)
                             ->where('tanggal_kembali', '>=', $tanggalKembali);
                      });
                })
                ->first();

            if ($conflictingBooking) {
                return redirect()->back()
                    ->withErrors(['tanggal_sewa' => 'Mobil sudah dibooking pada periode tersebut'])
                    ->withInput();
            }

            // Validate driver availability if selected
            if ($request->sopir_id) {
                $sopir = Sopir::findOrFail($request->sopir_id);
                if ($sopir->status !== 'tersedia') {
                    return redirect()->back()
                        ->withErrors(['sopir_id' => 'Sopir tidak tersedia'])
                        ->withInput();
                }
            }

            // Calculate costs
            $subtotal = $hargaSewa->harga_per_hari * $durasiHari;
            $biayaSopir = 0;

            if ($request->sopir_id) {
                $sopir = Sopir::find($request->sopir_id);
                $biayaSopir = ($sopir->tarif_per_hari ?? 0) * $durasiHari;
            }

            $totalBiaya = $subtotal + $biayaSopir;

            // Generate nomor transaksi
            $noTransaksi = 'TXN-' . date('Ymd') . '-' . str_pad(Transaksi::whereDate('created_at', today())->count() + 1, 4, '0', STR_PAD_LEFT);

            $transaksi = Transaksi::create([
                'no_transaksi' => $noTransaksi,
                'pelanggan_id' => $request->pelanggan_id,
                'mobil_id' => $request->mobil_id,
                'harga_sewa_id' => $request->harga_sewa_id,
                'sopir_id' => $request->sopir_id,
                'tanggal_sewa' => $tanggalSewa,
                'tanggal_kembali' => $tanggalKembali,
                'durasi_hari' => $durasiHari,
                'subtotal' => $subtotal,
                'biaya_tambahan' => $biayaSopir,
                'denda' => 0,
                'denda_manual' => 0,
                'total' => $totalBiaya,
                'status_pembayaran' => 'belum_bayar',
                'status' => 'pending',
                'catatan' => $request->catatan,
                'dibuat_oleh' => auth()->id(),
            ]);

            // Update status mobil
            Mobil::where('id', $request->mobil_id)->update(['status' => 'disewa']);

            // Update status sopir jika ada
            if ($request->sopir_id) {
                Sopir::where('id', $request->sopir_id)->update(['status' => 'tidak_tersedia']);
            }

            DB::commit();

            return redirect()->route('admin.transaksi.show', $transaksi->id)
                           ->with('success', 'Transaksi berhasil dibuat');

        } catch (\Exception $e) {
            DB::rollback();
            return back()->withErrors(['error' => 'Gagal membuat transaksi: ' . $e->getMessage()]);
        }
    }

    public function show($id)
    {
        $transaksi = Transaksi::with(['pelanggan', 'mobil', 'hargaSewa.jenisSewa', 'sopir', 'pembayaran', 'dibuatOleh'])
                               ->findOrFail($id);

        return view('admin.transaksi.show', compact('transaksi'));
    }

    public function edit($id)
    {
        $transaksi = Transaksi::with(['pelanggan', 'mobil', 'hargaSewa', 'sopir'])->findOrFail($id);

        // Hanya bisa edit jika status pending
        if ($transaksi->status !== 'pending') {
            return redirect()->route('admin.transaksi.show', $id)
                           ->withErrors(['error' => 'Transaksi hanya bisa diedit jika status pending']);
        }

        $pelanggan = Pelanggan::where('status', 'aktif')->get();
        $mobil = Mobil::where('status', 'tersedia')
                      ->orWhere('id', $transaksi->mobil_id)
                      ->get();
        $hargaSewa = HargaSewa::with('jenisSewa')->where('aktif', true)->get();
        $sopir = Sopir::where('status', 'tersedia')
                      ->orWhere('id', $transaksi->sopir_id)
                      ->get();

        return view('admin.transaksi.edit_new', compact('transaksi', 'pelanggan', 'mobil', 'hargaSewa', 'sopir'));
    }

    public function update(Request $request, $id)
    {
        $transaksi = Transaksi::findOrFail($id);

        // Hanya bisa update jika status pending
        if ($transaksi->status !== 'pending') {
            return redirect()->route('admin.transaksi.show', $id)
                           ->withErrors(['error' => 'Transaksi hanya bisa diedit jika status pending']);
        }

        $request->validate([
            'pelanggan_id' => 'required|exists:pelanggan,id',
            'mobil_id' => 'required|exists:mobil,id',
            'harga_sewa_id' => 'required|exists:harga_sewa,id',
            'sopir_id' => 'nullable|exists:sopir,id',
            'tanggal_sewa' => 'required|date',
            'durasi_hari' => 'required|integer|min:1|max:30',
            'catatan' => 'nullable|string|max:1000',
            // 'tanggal_kembali' => 'required|date|after:tanggal_sewa',
        ]);

        try {
            DB::beginTransaction();

            $hargaSewa = HargaSewa::findOrFail($request->harga_sewa_id);
            $tanggalSewa = Carbon::parse($request->tanggal_sewa);
            $durasiHari = (int) $request->durasi_hari;
            $tanggalKembali = $tanggalSewa->copy()->addDays($durasiHari);

            // Hitung subtotal
            $subtotal = $hargaSewa->harga_per_hari * $durasiHari;

            // Update status mobil lama jika berubah
            if ($transaksi->mobil_id != $request->mobil_id) {
                Mobil::where('id', $transaksi->mobil_id)->update(['status' => 'tersedia']);
                Mobil::where('id', $request->mobil_id)->update(['status' => 'disewa']);
            }

            // Update status sopir lama jika berubah
            if ($transaksi->sopir_id != $request->sopir_id) {
                if ($transaksi->sopir_id) {
                    Sopir::where('id', $transaksi->sopir_id)->update(['status' => 'tersedia']);
                }
                if ($request->sopir_id) {
                    Sopir::where('id', $request->sopir_id)->update(['status' => 'tidak_tersedia']);
                }
            }

            $transaksi->update([
                'pelanggan_id' => $request->pelanggan_id,
                'mobil_id' => $request->mobil_id,
                'harga_sewa_id' => $request->harga_sewa_id,
                'sopir_id' => $request->sopir_id,
                'tanggal_sewa' => $tanggalSewa,
                'tanggal_kembali' => $tanggalKembali,
                'durasi_hari' => $durasiHari,
                'subtotal' => $subtotal,
                'total' => $subtotal + $transaksi->biaya_tambahan + $transaksi->denda + $transaksi->denda_manual,
                'catatan' => $request->catatan,
            ]);

            DB::commit();

            return redirect()->route('admin.transaksi.show', $transaksi->id)
                           ->with('success', 'Transaksi berhasil diperbarui');

        } catch (\Exception $e) {
            DB::rollback();
            return back()->withErrors(['error' => 'Gagal memperbarui transaksi: ' . $e->getMessage()]);
        }
    }

    public function updateStatus(Request $request, $id)
    {
        $transaksi = Transaksi::findOrFail($id);
        $newStatus = $request->status;

        $validTransitions = [
            'pending' => ['dibayar', 'dibatalkan'],
            'dibayar' => ['berjalan', 'dibatalkan'],
            'berjalan' => ['selesai', 'telat'],
            'telat' => ['selesai'],
        ];

        if (!isset($validTransitions[$transaksi->status]) ||
            !in_array($newStatus, $validTransitions[$transaksi->status])) {
            return back()->withErrors(['error' => 'Perubahan status tidak valid']);
        }

        try {
            DB::beginTransaction();

            $transaksi->update(['status' => $newStatus]);

            // Logic berdasarkan status baru
            switch ($newStatus) {
                case 'dibatalkan':
                    // Kembalikan status mobil dan sopir
                    Mobil::where('id', $transaksi->mobil_id)->update(['status' => 'tersedia']);
                    if ($transaksi->sopir_id) {
                        Sopir::where('id', $transaksi->sopir_id)->update(['status' => 'tersedia']);
                    }
                    break;

                case 'selesai':
                    // Kembalikan status mobil dan sopir
                    Mobil::where('id', $transaksi->mobil_id)->update(['status' => 'tersedia']);
                    if ($transaksi->sopir_id) {
                        Sopir::where('id', $transaksi->sopir_id)->update(['status' => 'tersedia']);
                    }

                    // Set tanggal dikembalikan jika belum ada
                    if (!$transaksi->tanggal_dikembalikan) {
                        $transaksi->update(['tanggal_dikembalikan' => now()]);
                    }
                    break;

                case 'telat':
                    // Hitung denda otomatis
                    $hariTelat = Carbon::now()->diffInDays($transaksi->tanggal_kembali);
                    $denda = $hariTelat * 100000; // 100rb per hari
                    $transaksi->update([
                        'denda' => $denda,
                        'total' => $transaksi->subtotal + $transaksi->biaya_tambahan + $denda + $transaksi->denda_manual
                    ]);
                    break;
            }

            DB::commit();

            return back()->with('success', 'Status transaksi berhasil diperbarui');

        } catch (\Exception $e) {
            DB::rollback();
            return back()->withErrors(['error' => 'Gagal memperbarui status: ' . $e->getMessage()]);
        }
    }

    public function addBiayaTambahan(Request $request, $id)
    {
        $transaksi = Transaksi::findOrFail($id);

        $request->validate([
            'biaya_tambahan' => 'required|numeric|min:0',
            'keterangan_biaya' => 'required|string|max:255',
        ]);

        $transaksi->update([
            'biaya_tambahan' => $transaksi->biaya_tambahan + $request->biaya_tambahan,
            'total' => $transaksi->subtotal + ($transaksi->biaya_tambahan + $request->biaya_tambahan) + $transaksi->denda + $transaksi->denda_manual,
            'catatan' => $transaksi->catatan . "\n\nBiaya Tambahan: " . $request->keterangan_biaya . " - Rp " . number_format($request->biaya_tambahan, 0, ',', '.')
        ]);

        return back()->with('success', 'Biaya tambahan berhasil ditambahkan');
    }

    public function addDenda(Request $request, $id)
    {
        $transaksi = Transaksi::findOrFail($id);

        $request->validate([
            'denda_manual' => 'required|numeric|min:0',
            'keterangan_denda' => 'required|string|max:255',
        ]);

        $transaksi->update([
            'denda_manual' => $transaksi->denda_manual + $request->denda_manual,
            'total' => $transaksi->subtotal + $transaksi->biaya_tambahan + $transaksi->denda + ($transaksi->denda_manual + $request->denda_manual),
            'catatan' => $transaksi->catatan . "\n\nDenda Manual: " . $request->keterangan_denda . " - Rp " . number_format($request->denda_manual, 0, ',', '.')
        ]);

        return back()->with('success', 'Denda berhasil ditambahkan');
    }

    public function payment($id)
    {
        $transaksi = Transaksi::with(['pelanggan', 'mobil', 'hargaSewa.jenisSewa', 'sopir', 'pembayaran'])
                               ->findOrFail($id);

        return view('admin.transaksi.payment', compact('transaksi'));
    }
}
