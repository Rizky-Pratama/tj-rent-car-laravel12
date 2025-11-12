<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Transaksi;
use App\Models\Pelanggan;
use App\Models\Mobil;
use App\Models\HargaSewa;
use App\Models\Sopir;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Carbon\Carbon;
use Exception;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Throwable;

class TransaksiController extends Controller
{
    public function index(Request $request)
    {
        // Check if export is requested
        if ($request->get('export') === 'pdf') {
            return $this->exportPDF($request);
        }

        // Ambil semua parameter filter
        $filters = $request->only([
            'period',
            'date_from',
            'date_to',
            'status',
            'payment_status',
            'mobil_id',
            'sopir_id',
            'jenis_sewa',
            'min_total',
            'max_total',
            'search'
        ]);

        // Set default period ke this month jika tidak ada filter
        if (empty($filters['period']) && empty($filters['date_from'])) {
            $filters['period'] = 'this_month';
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
            'dibatalkan' => Transaksi::filter($filters)->where('status', 'batal')->count(),
        ];

        // Data untuk dropdown filter
        $mobils = Mobil::select('id', 'merk', 'model', 'plat_nomor')->orderBy('merk')->get();
        $sopirs = Sopir::select('id', 'nama')->orderBy('nama')->get();
        $jenisSewaList = \App\Models\JenisSewa::select('id', 'nama_jenis')->orderBy('nama_jenis')->get();

        return view('admin.transaksi.index', compact(
            'transaksi',
            'statistik',
            'mobils',
            'sopirs',
            'jenisSewaList',
            'filters'
        ));
    }

    public function create()
    {
        // Get customers with additional info for smart selection
        $pelanggan = Pelanggan::where('status', 'aktif')
            ->select('id', 'nama', 'telepon', 'email', 'alamat', 'no_ktp')
            ->orderBy('nama')
            ->get();

        $mobil = Mobil::with(['hargaSewa' => function ($q) {
            $q->where('aktif', true)->with('jenisSewa');
        }])
            ->select('id', 'merk', 'model', 'plat_nomor', 'tahun', 'warna', 'kapasitas_penumpang', 'foto', 'transmisi', 'jenis_bahan_bakar', 'status')
            ->orderBy('merk')
            ->orderBy('model')
            ->get();

        // Get active pricing for all cars
        $hargaSewa = HargaSewa::with(['jenisSewa', 'mobil'])
            ->where('aktif', true)
            ->select('harga_sewa.*')
            ->orderBy('harga_per_hari')
            ->get()
            ->groupBy('mobil_id');

        // Get all active drivers - availability will be checked by date
        $sopir = Sopir::orderBy('nama')
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
        // Step 1: Validate input data
        $validator = Validator::make($request->all(), [
            'pelanggan_id' => ['required', 'integer', Rule::exists('pelanggan', 'id')],
            'mobil_id' => ['required', 'integer', Rule::exists('mobil', 'id')],
            'harga_sewa_id' => ['required', 'integer', Rule::exists('harga_sewa', 'id')],
            'sopir_id' => ['nullable', 'integer', Rule::exists('sopir', 'id')],
            'tanggal_sewa' => ['required', 'date', 'after_or_equal:today'],
            'durasi_hari' => ['required', 'integer', 'min:1', 'max:30'],
            'catatan' => ['nullable', 'string', 'max:1000'],
        ], [
            'tanggal_sewa.after_or_equal' => 'Tanggal sewa tidak boleh kurang dari hari ini',
            'durasi_hari.min' => 'Durasi sewa minimal 1 hari',
            'durasi_hari.max' => 'Durasi sewa maksimal 30 hari',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        $data = $validator->validated();

        // Step 2: Initialize transaction variable
        $transaksi = null;

        try {
            // Step 3: Execute database transaction with deadlock protection
            DB::transaction(function () use ($data, &$transaksi) {
                // Lock resources to prevent race conditions
                $mobil = Mobil::where('id', $data['mobil_id'])->lockForUpdate()->first();

                if (!$mobil) {
                    throw new \Exception("Mobil dengan ID {$data['mobil_id']} tidak ditemukan.");
                }

                // Business rule: Check if car is available
                if (in_array($mobil->status, ['nonaktif', 'perawatan'])) {
                    throw new \Exception('Mobil sedang dalam perbaikan/maintenance dan tidak dapat dibooking.');
                }

                $hargaSewa = HargaSewa::where('id', $data['harga_sewa_id'])->lockForUpdate()->first();

                if (!$hargaSewa) {
                    throw new \Exception("Paket sewa dengan ID {$data['harga_sewa_id']} tidak ditemukan.");
                }

                if (!$hargaSewa->aktif) {
                    throw new \Exception('Paket sewa tidak aktif.');
                }

                // Calculate rental dates
                $tanggalSewa = Carbon::parse($data['tanggal_sewa'])->startOfDay();
                $durasiHari = (int) $data['durasi_hari'];
                $tanggalKembali = $tanggalSewa->copy()->addDays($durasiHari - 1)->endOfDay();

                $sewaMulai = $tanggalSewa->copy()->startOfDay();
                $sewaSelesai = $tanggalKembali->copy()->endOfDay();

                // Check for conflicting car bookings
                $conflictingBooking = Transaksi::where('mobil_id', $data['mobil_id'])
                    ->whereNotIn('status', ['batal', 'selesai'])
                    ->where(function ($q) use ($sewaMulai, $sewaSelesai) {
                        $q->where(function ($q2) use ($sewaMulai, $sewaSelesai) {
                            $q2->where('tanggal_sewa', '<=', $sewaSelesai)
                                ->where('tanggal_kembali', '>=', $sewaMulai);
                        });
                    })
                    ->with(['pelanggan:id,nama'])
                    ->first();

                if ($conflictingBooking) {
                    throw new \Exception(sprintf(
                        'Mobil tidak tersedia pada tanggal yang dipilih. Sudah dibooking oleh %s pada periode %s s/d %s (Transaksi #%s)',
                        $conflictingBooking->pelanggan->nama ?? 'Pelanggan',
                        $conflictingBooking->tanggal_sewa->format('d M Y'),
                        $conflictingBooking->tanggal_kembali->format('d M Y'),
                        $conflictingBooking->no_transaksi
                    ));
                }

                // Check driver availability if selected
                if (!empty($data['sopir_id'])) {
                    $sopir = Sopir::where('id', $data['sopir_id'])->lockForUpdate()->first();

                    if (!$sopir) {
                        throw new \Exception("Sopir dengan ID {$data['sopir_id']} tidak ditemukan.");
                    }

                    $conflictingSopirBooking = Transaksi::where('sopir_id', $data['sopir_id'])
                        ->whereNotIn('status', ['batal', 'selesai'])
                        ->where(function ($q) use ($sewaMulai, $sewaSelesai) {
                            $q->where(function ($q2) use ($sewaMulai, $sewaSelesai) {
                                $q2->where('tanggal_sewa', '<=', $sewaSelesai)
                                    ->where('tanggal_kembali', '>=', $sewaMulai);
                            });
                        })
                        ->with(['pelanggan:id,nama', 'mobil:id,merk,model'])
                        ->first();

                    if ($conflictingSopirBooking) {
                        throw new \Exception(sprintf(
                            'Sopir %s sudah dibooking oleh %s untuk mobil %s %s pada periode %s s/d %s (Transaksi #%s)',
                            $sopir->nama,
                            $conflictingSopirBooking->pelanggan->nama ?? 'Pelanggan',
                            $conflictingSopirBooking->mobil->merk ?? '',
                            $conflictingSopirBooking->mobil->model ?? '',
                            $conflictingSopirBooking->tanggal_sewa->format('d M Y'),
                            $conflictingSopirBooking->tanggal_kembali->format('d M Y'),
                            $conflictingSopirBooking->no_transaksi
                        ));
                    }
                }

                // Calculate costs
                $subtotal = $hargaSewa->harga_per_hari * $durasiHari;
                $totalBiaya = $subtotal;

                // Generate transaction number
                $noTransaksi = 'TXN-' . date('Ymd') . '-' . str_pad(
                    Transaksi::whereDate('created_at', today())->count() + 1,
                    4,
                    '0',
                    STR_PAD_LEFT
                );

                // Create transaction record
                $transaksi = Transaksi::create([
                    'no_transaksi' => $noTransaksi,
                    'pelanggan_id' => $data['pelanggan_id'],
                    'mobil_id' => $data['mobil_id'],
                    'harga_sewa_id' => $data['harga_sewa_id'],
                    'sopir_id' => $data['sopir_id'] ?? null,
                    'tanggal_sewa' => $tanggalSewa,
                    'tanggal_kembali' => $tanggalKembali,
                    'durasi_hari' => $durasiHari,
                    'subtotal' => $subtotal,
                    'biaya_tambahan' => 0,
                    'denda' => 0,
                    'denda_manual' => 0,
                    'total' => $totalBiaya,
                    'status_pembayaran' => 'belum_bayar',
                    'status' => 'pending',
                    'catatan' => $data['catatan'] ?? null,
                    'dibuat_oleh' => Auth::id(),
                ]);

                // Update car status
                $mobil->update(['status' => 'disewa']);

                // Update driver status if selected
                if (!empty($data['sopir_id'])) {
                    Sopir::where('id', $data['sopir_id'])->update(['status' => 'ditugaskan']);
                }

                Log::info('Transaction created successfully', [
                    'transaction_id' => $transaksi->id,
                    'transaction_number' => $transaksi->no_transaksi,
                    'total' => $transaksi->total,
                ]);
            }, 5); // Retry up to 5 times on deadlock

            return redirect()
                ->route('admin.transaksi.show', $transaksi->id)
                ->with('success', 'Transaksi berhasil dibuat dengan nomor: ' . $transaksi->no_transaksi);
        } catch (Exception $e) {
            Log::error('Transaction creation failed: ' . $e->getMessage(), [
                'exception' => $e,
                'payload' => $request->all(),
                'user_id' => Auth::id(),
            ]);
            return back()
                ->with('error', 'Gagal membuat transaksi: ' . $e->getMessage())
                ->withInput();
        } catch (Throwable $e) {
            Log::error('Transaction creation failed: ' . $e->getMessage(), [
                'exception' => $e,
                'payload' => $request->all(),
                'user_id' => Auth::id(),
            ]);

            return back()
                ->with('error', 'Terjadi kesalahan saat membuat transaksi. Silakan coba lagi.')
                ->withInput();
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
        $transaksi = Transaksi::with(['pelanggan', 'mobil', 'hargaSewa.jenisSewa', 'sopir'])->findOrFail($id);

        // Hanya bisa edit jika status pending
        if ($transaksi->status !== 'pending') {
            return redirect()->route('admin.transaksi.show', $id)
                ->withErrors(['error' => 'Transaksi hanya bisa diedit jika status pending']);
        }

        // Get customers with additional info for smart selection
        $pelanggan = Pelanggan::where('status', 'aktif')
            ->select('id', 'nama', 'telepon', 'email', 'alamat', 'no_ktp')
            ->orderBy('nama')
            ->get();

        // Get cars - include current transaction's car even if not available
        $mobil = Mobil::with(['hargaSewa' => function ($q) {
            $q->where('aktif', true)->with('jenisSewa');
        }])
            ->select('id', 'merk', 'model', 'plat_nomor', 'tahun', 'warna', 'kapasitas_penumpang', 'foto', 'transmisi', 'jenis_bahan_bakar', 'status')
            ->where(function ($query) use ($transaksi) {
                $query->where('status', 'tersedia')
                    ->orWhere('id', $transaksi->mobil_id);
            })
            ->orderBy('merk')
            ->orderBy('model')
            ->get();

        // Get active pricing for all cars
        $hargaSewa = HargaSewa::with(['jenisSewa', 'mobil'])
            ->where('aktif', true)
            ->select('harga_sewa.*')
            ->orderBy('harga_per_hari')
            ->get()
            ->groupBy('mobil_id');

        // Get all active drivers - include current transaction's driver even if not available
        $sopir = Sopir::where(function ($query) use ($transaksi) {
            $query->where('status', 'tersedia')
                ->orWhere('id', $transaksi->sopir_id);
        })
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

        return view('admin.transaksi.edit', compact('transaksi', 'pelanggan', 'mobil', 'hargaSewa', 'sopir', 'analytics', 'settings'));
    }

    public function update(Request $request, $id)
    {
        $transaksi = Transaksi::findOrFail($id);

        // Hanya bisa update jika status pending
        if ($transaksi->status !== 'pending') {
            return redirect()->route('admin.transaksi.show', $id)
                ->with('error', 'Transaksi hanya bisa diedit jika status pending');
        }

        // Step 1: Validate input data
        $validator = Validator::make($request->all(), [
            'pelanggan_id' => ['required', 'integer', Rule::exists('pelanggan', 'id')],
            'mobil_id' => ['required', 'integer', Rule::exists('mobil', 'id')],
            'harga_sewa_id' => ['required', 'integer', Rule::exists('harga_sewa', 'id')],
            'sopir_id' => ['nullable', 'integer', Rule::exists('sopir', 'id')],
            'tanggal_sewa' => ['required', 'date'],
            'durasi_hari' => ['required', 'integer', 'min:1', 'max:30'],
            'catatan' => ['nullable', 'string', 'max:1000'],
        ], [
            'durasi_hari.min' => 'Durasi sewa minimal 1 hari',
            'durasi_hari.max' => 'Durasi sewa maksimal 30 hari',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        $data = $validator->validated();

        try {
            // Step 2: Execute database transaction with deadlock protection
            DB::transaction(function () use ($data, $transaksi) {
                // Lock resources
                $mobil = Mobil::where('id', $data['mobil_id'])->lockForUpdate()->first();

                if (!$mobil) {
                    throw new \RuntimeException("Mobil dengan ID {$data['mobil_id']} tidak ditemukan.");
                }

                // Business rule: Check if car is available (skip if it's the same car)
                if ($transaksi->mobil_id != $data['mobil_id'] && in_array($mobil->status, ['nonaktif', 'perawatan'])) {
                    throw new \RuntimeException('Mobil sedang dalam perbaikan/maintenance dan tidak dapat dibooking.');
                }

                $hargaSewa = HargaSewa::where('id', $data['harga_sewa_id'])->lockForUpdate()->first();

                if (!$hargaSewa) {
                    throw new \RuntimeException("Paket sewa dengan ID {$data['harga_sewa_id']} tidak ditemukan.");
                }

                if (!$hargaSewa->aktif) {
                    throw new \RuntimeException('Paket sewa tidak aktif.');
                }

                // Calculate rental dates
                $tanggalSewa = Carbon::parse($data['tanggal_sewa'])->startOfDay();
                $durasiHari = (int) $data['durasi_hari'];
                $tanggalKembali = $tanggalSewa->copy()->addDays($durasiHari - 1)->endOfDay();

                $sewaMulai = $tanggalSewa->copy()->startOfDay();
                $sewaSelesai = $tanggalKembali->copy()->endOfDay();

                // Check for conflicting car bookings (exclude current transaction)
                $conflictingBooking = Transaksi::where('mobil_id', $data['mobil_id'])
                    ->where('id', '!=', $transaksi->id) // Exclude current transaction
                    ->whereNotIn('status', ['batal', 'selesai'])
                    ->where(function ($q) use ($sewaMulai, $sewaSelesai) {
                        $q->where(function ($q2) use ($sewaMulai, $sewaSelesai) {
                            $q2->where('tanggal_sewa', '<=', $sewaSelesai)
                                ->where('tanggal_kembali', '>=', $sewaMulai);
                        });
                    })
                    ->with(['pelanggan:id,nama'])
                    ->first();

                if ($conflictingBooking) {
                    throw new \RuntimeException(sprintf(
                        'Mobil tidak tersedia pada tanggal yang dipilih. Sudah dibooking oleh %s pada periode %s s/d %s (Transaksi #%s)',
                        $conflictingBooking->pelanggan->nama ?? 'Pelanggan',
                        $conflictingBooking->tanggal_sewa->format('d M Y'),
                        $conflictingBooking->tanggal_kembali->format('d M Y'),
                        $conflictingBooking->no_transaksi
                    ));
                }

                // Check driver availability if selected
                if (!empty($data['sopir_id'])) {
                    $sopir = Sopir::where('id', $data['sopir_id'])->lockForUpdate()->first();

                    if (!$sopir) {
                        throw new \RuntimeException("Sopir dengan ID {$data['sopir_id']} tidak ditemukan.");
                    }

                    $conflictingSopirBooking = Transaksi::where('sopir_id', $data['sopir_id'])
                        ->where('id', '!=', $transaksi->id) // Exclude current transaction
                        ->whereNotIn('status', ['batal', 'selesai'])
                        ->where(function ($q) use ($sewaMulai, $sewaSelesai) {
                            $q->where(function ($q2) use ($sewaMulai, $sewaSelesai) {
                                $q2->where('tanggal_sewa', '<=', $sewaSelesai)
                                    ->where('tanggal_kembali', '>=', $sewaMulai);
                            });
                        })
                        ->with(['pelanggan:id,nama', 'mobil:id,merk,model'])
                        ->first();

                    if ($conflictingSopirBooking) {
                        throw new \RuntimeException(sprintf(
                            'Sopir %s sudah dibooking oleh %s untuk mobil %s %s pada periode %s s/d %s (Transaksi #%s)',
                            $sopir->nama,
                            $conflictingSopirBooking->pelanggan->nama ?? 'Pelanggan',
                            $conflictingSopirBooking->mobil->merk ?? '',
                            $conflictingSopirBooking->mobil->model ?? '',
                            $conflictingSopirBooking->tanggal_sewa->format('d M Y'),
                            $conflictingSopirBooking->tanggal_kembali->format('d M Y'),
                            $conflictingSopirBooking->no_transaksi
                        ));
                    }
                }

                // Calculate costs
                $subtotal = $hargaSewa->harga_per_hari * $durasiHari;

                // Update status mobil lama jika berubah
                if ($transaksi->mobil_id != $data['mobil_id']) {
                    Mobil::where('id', $transaksi->mobil_id)->update(['status' => 'tersedia']);
                    $mobil->update(['status' => 'disewa']);
                }

                // Update status sopir lama jika berubah
                if ($transaksi->sopir_id != $data['sopir_id']) {
                    if ($transaksi->sopir_id) {
                        Sopir::where('id', $transaksi->sopir_id)->update(['status' => 'tersedia']);
                    }
                    if (!empty($data['sopir_id'])) {
                        Sopir::where('id', $data['sopir_id'])->update(['status' => 'ditugaskan']);
                    }
                }

                // Update transaction record
                $transaksi->update([
                    'pelanggan_id' => $data['pelanggan_id'],
                    'mobil_id' => $data['mobil_id'],
                    'harga_sewa_id' => $data['harga_sewa_id'],
                    'sopir_id' => $data['sopir_id'] ?? null,
                    'tanggal_sewa' => $tanggalSewa,
                    'tanggal_kembali' => $tanggalKembali,
                    'durasi_hari' => $durasiHari,
                    'subtotal' => $subtotal,
                    'total' => $subtotal + $transaksi->biaya_tambahan + $transaksi->denda + $transaksi->denda_manual,
                    'catatan' => $data['catatan'] ?? null,
                ]);

                Log::info('Transaction updated successfully', [
                    'transaction_id' => $transaksi->id,
                    'transaction_number' => $transaksi->no_transaksi,
                    'updated_by' => Auth::id(),
                ]);
            }, 5); // Retry up to 5 times on deadlock

            return redirect()
                ->route('admin.transaksi.show', $transaksi->id)
                ->with('success', 'Transaksi berhasil diperbarui');
        } catch (Throwable $e) {
            Log::error('Transaction update failed: ' . $e->getMessage(), [
                'exception' => $e,
                'transaction_id' => $id,
                'payload' => $request->all(),
                'user_id' => Auth::id(),
            ]);

            return back()
                ->with('error', 'Gagal memperbarui transaksi: ' . $e->getMessage())
                ->withInput();
        }
    }

    public function updateStatus(Request $request, $id)
    {
        $transaksi = Transaksi::findOrFail($id);
        $newStatus = $request->status;

        $validTransitions = [
            'pending' => ['dibayar', 'batal'],
            'dibayar' => ['berjalan', 'batal'],
            'berjalan' => ['selesai', 'telat'],
            'telat' => ['selesai'],
        ];

        if (
            !isset($validTransitions[$transaksi->status]) ||
            !in_array($newStatus, $validTransitions[$transaksi->status])
        ) {
            return back()->withErrors([
                'error' => sprintf(
                    'Perubahan status dari "%s" ke "%s" tidak valid',
                    $transaksi->status,
                    $newStatus
                )
            ]);
        }

        try {
            DB::beginTransaction();

            $transaksi->update(['status' => $newStatus]);

            // Logic berdasarkan status baru
            switch ($newStatus) {
                case 'batal':
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
                    // ✅ FIX: Perhitungan denda yang lebih akurat
                    $tanggalSeharusnyaKembali = $transaksi->tanggal_kembali;
                    $tanggalAktualKembali = now();

                    // Hitung jumlah hari terlambat (hanya hitung hari penuh)
                    $hariTelat = $tanggalSeharusnyaKembali->startOfDay()
                        ->diffInDays($tanggalAktualKembali->startOfDay());

                    if ($hariTelat > 0) {
                        // Denda = 50% dari harga sewa per hari
                        $dendaPerHari = $transaksi->hargaSewa->harga_per_hari * 0.5;
                        $totalDenda = $hariTelat * $dendaPerHari;

                        $transaksi->update([
                            'denda' => $totalDenda,
                            'total' => $transaksi->subtotal + $transaksi->biaya_tambahan + $totalDenda + $transaksi->denda_manual,
                            'catatan' => $transaksi->catatan . sprintf(
                                "\n\n[AUTO] Denda Keterlambatan: %d hari x Rp %s = Rp %s",
                                $hariTelat,
                                number_format($dendaPerHari, 0, ',', '.'),
                                number_format($totalDenda, 0, ',', '.')
                            )
                        ]);
                    }
                    break;
            }

            DB::commit();

            return back()->with('success', sprintf(
                'Status transaksi berhasil diperbarui menjadi "%s"',
                ucfirst($newStatus)
            ));
        } catch (\Exception $e) {
            DB::rollback();
            Log::error('Failed to update transaction status', [
                'id' => $id,
                'old_status' => $transaksi->status,
                'new_status' => $newStatus,
                'error' => $e->getMessage()
            ]);
            return back()->withErrors(['error' => 'Gagal memperbarui status: ' . $e->getMessage()]);
        }
    }

    public function addBiayaTambahan(Request $request, $id)
    {
        $transaksi = Transaksi::findOrFail($id);

        $request->validate([
            'biaya_tambahan' => 'required|numeric|min:0|max:999999999',
            'keterangan_biaya' => 'required|string|max:255',
        ], [
            'biaya_tambahan.max' => 'Biaya tambahan maksimal Rp 999.999.999'
        ]);

        try {
            DB::beginTransaction();

            $biayaTambahanBaru = $transaksi->biaya_tambahan + $request->biaya_tambahan;
            $totalBaru = $transaksi->subtotal + $biayaTambahanBaru + $transaksi->denda + $transaksi->denda_manual;

            $transaksi->update([
                'biaya_tambahan' => $biayaTambahanBaru,
                'total' => $totalBaru,
                'catatan' => $transaksi->catatan . sprintf(
                    "\n\n[%s] Biaya Tambahan: %s - Rp %s",
                    now()->format('d/m/Y H:i'),
                    $request->keterangan_biaya,
                    number_format($request->biaya_tambahan, 0, ',', '.')
                )
            ]);

            DB::commit();

            return back()->with('success', 'Biaya tambahan berhasil ditambahkan');
        } catch (\Exception $e) {
            DB::rollback();
            return back()->withErrors(['error' => 'Gagal menambahkan biaya: ' . $e->getMessage()]);
        }
    }

    public function addDenda(Request $request, $id)
    {
        $transaksi = Transaksi::findOrFail($id);

        $request->validate([
            'denda_manual' => 'required|numeric|min:0|max:999999999',
            'keterangan_denda' => 'required|string|max:255',
        ], [
            'denda_manual.max' => 'Denda maksimal Rp 999.999.999'
        ]);

        try {
            DB::beginTransaction();

            $dendaManualBaru = $transaksi->denda_manual + $request->denda_manual;
            $totalBaru = $transaksi->subtotal + $transaksi->biaya_tambahan + $transaksi->denda + $dendaManualBaru;

            $transaksi->update([
                'denda_manual' => $dendaManualBaru,
                'total' => $totalBaru,
                'catatan' => $transaksi->catatan . sprintf(
                    "\n\n[%s] Denda Manual: %s - Rp %s",
                    now()->format('d/m/Y H:i'),
                    $request->keterangan_denda,
                    number_format($request->denda_manual, 0, ',', '.')
                )
            ]);

            DB::commit();

            return back()->with('success', 'Denda berhasil ditambahkan');
        } catch (\Exception $e) {
            DB::rollback();
            return back()->withErrors(['error' => 'Gagal menambahkan denda: ' . $e->getMessage()]);
        }
    }

    public function payment($id)
    {
        $transaksi = Transaksi::with(['pelanggan', 'mobil', 'hargaSewa.jenisSewa', 'sopir', 'pembayaran'])
            ->findOrFail($id);

        return view('admin.transaksi.payment', compact('transaksi'));
    }

    public function exportPDF(Request $request)
    {
        try {
            $transaksi = $this->getFilteredTransaksi($request);
            $filters = $request->only([
                'period',
                'date_from',
                'date_to',
                'status',
                'payment_status',
                'mobil_id',
                'sopir_id',
                'jenis_sewa',
                'min_total',
                'max_total',
                'search'
            ]);
            $statistik = $this->getStatistik($request);

            $pdf = \Barryvdh\DomPDF\Facade\Pdf::loadView('admin.transaksi.pdf-export', [
                'transaksi' => $transaksi,
                'filters' => $filters,
                'statistik' => $statistik,
                'generated_at' => now()
            ]);

            $pdf->setPaper('a4', 'landscape');

            $filename = 'laporan-transaksi-' . now()->format('Y-m-d-H-i-s') . '.pdf';

            return $pdf->download($filename);
        } catch (\Exception $e) {
            Log::error('Failed to export PDF', [
                'error' => $e->getMessage(),
                'filters' => $request->all()
            ]);
            return response()->json([
                'success' => false,
                'message' => 'Gagal mengunduh laporan: ' . $e->getMessage()
            ], 500);
        }
    }

    private function getFilteredTransaksi(Request $request)
    {
        $filters = $request->only([
            'period',
            'date_from',
            'date_to',
            'status',
            'payment_status',
            'mobil_id',
            'sopir_id',
            'jenis_sewa',
            'min_total',
            'max_total',
            'search'
        ]);

        return Transaksi::with(['pelanggan', 'mobil', 'hargaSewa.jenisSewa', 'sopir'])
            ->filter($filters)
            ->orderBy('created_at', 'desc')
            ->get();
    }

    private function getStatistik(Request $request)
    {
        $filters = $request->only([
            'period',
            'date_from',
            'date_to',
            'status',
            'payment_status',
            'mobil_id',
            'sopir_id',
            'jenis_sewa',
            'min_total',
            'max_total',
            'search'
        ]);

        return [
            'total' => Transaksi::filter($filters)->count(),
            'pending' => Transaksi::filter($filters)->where('status', 'pending')->count(),
            'dibayar' => Transaksi::filter($filters)->where('status', 'dibayar')->count(),
            'berjalan' => Transaksi::filter($filters)->where('status', 'berjalan')->count(),
            'telat' => Transaksi::filter($filters)->where('status', 'telat')->count(),
            'selesai' => Transaksi::filter($filters)->where('status', 'selesai')->count(),
            'dibatalkan' => Transaksi::filter($filters)->where('status', 'batal')->count(),
            'total_pendapatan' => Transaksi::filter($filters)->where('status', 'selesai')->sum('total'),
        ];
    }
}
