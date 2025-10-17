<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Transaksi;
use App\Models\Mobil;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Carbon\CarbonPeriod;

class JadwalController extends Controller
{
    public function index(Request $request)
    {
        $mobils = Mobil::orderBy('nama_mobil')->get();

        // Get date range (default current month)
        $startDate = Carbon::parse($request->get('start', now()->startOfMonth()->toDateString()));
        $endDate = Carbon::parse($request->get('end', now()->endOfMonth()->toDateString()));

        // Get active transactions for calendar
        $transaksis = Transaksi::forCalendar()
            ->where(function($query) use ($startDate, $endDate) {
                $query->whereBetween('tanggal_sewa', [$startDate, $endDate])
                      ->orWhereBetween('tanggal_kembali', [$startDate, $endDate])
                      ->orWhere(function($q) use ($startDate, $endDate) {
                          $q->where('tanggal_sewa', '<=', $startDate)
                            ->where('tanggal_kembali', '>=', $endDate);
                      });
            })
            ->when($request->mobil_id, function($query, $mobilId) {
                return $query->where('mobil_id', $mobilId);
            })
            ->get();

        // Generate calendar data
        $calendarData = $this->generateCalendarData($mobils, $transaksis, $startDate, $endDate);

        // Stats
        $stats = [
            'total_mobil' => $mobils->count(),
            'tersedia_hari_ini' => $this->getAvailableCarsToday(),
            'disewa_hari_ini' => Transaksi::where('status', 'berjalan')
                ->whereDate('tanggal_sewa', '<=', today())
                ->whereDate('tanggal_kembali', '>=', today())
                ->count(),
            'telat_hari_ini' => Transaksi::where('status', 'telat')->count(),
            'siap_diambil' => Transaksi::where('status', 'dibayar')->count(),
        ];

        if ($request->ajax()) {
            return response()->json([
                'calendar' => $calendarData,
                'stats' => $stats
            ]);
        }

        return view('admin.jadwal.index', compact('mobils', 'calendarData', 'stats', 'startDate', 'endDate'));
    }

    private function generateCalendarData($mobils, $transaksis, $startDate, $endDate)
    {
        $period = CarbonPeriod::create($startDate, $endDate);
        $dates = [];

        foreach ($period as $date) {
            $dates[] = $date->toDateString();
        }

        // Group transactions by mobil_id
        $transaksiByMobil = $transaksis->groupBy('mobil_id');

        $calendar = [];
        foreach ($mobils as $mobil) {
            $mobilTransaksi = $transaksiByMobil->get($mobil->id, collect());

            $calendar[] = [
                'mobil' => [
                    'id' => $mobil->id,
                    'nama' => $mobil->nama_mobil,
                    'plat' => $mobil->plat_nomor,
                    'merk' => $mobil->merk,
                    'model' => $mobil->model
                ],
                'schedule' => collect($dates)->map(function($date) use ($mobilTransaksi, $mobil) {
                    return $this->getStatusForDate($mobil, $mobilTransaksi, $date);
                })->toArray()
            ];
        }

        return $calendar;
    }

    private function getStatusForDate($mobil, $transaksis, $date)
    {
        $dateCarbon = Carbon::parse($date);

        // Check if there's an active transaction for this date
        $activeTransaksi = $transaksis->first(function($transaksi) use ($date) {
            $tanggalSewa = Carbon::parse($transaksi->tanggal_sewa)->toDateString();
            $tanggalKembali = Carbon::parse($transaksi->tanggal_kembali)->toDateString();

            return $date >= $tanggalSewa && $date <= $tanggalKembali;
        });

        if ($activeTransaksi) {
            $calendarStatus = $activeTransaksi->calendar_status;

            return [
                'date' => $date,
                'status' => $calendarStatus['status'],
                'status_text' => $calendarStatus['text'],
                'status_color' => $calendarStatus['color'],
                'text_color' => $calendarStatus['text_color'],
                'transaksi' => [
                    'id' => $activeTransaksi->id,
                    'no_transaksi' => $activeTransaksi->no_transaksi,
                    'pelanggan' => $activeTransaksi->pelanggan->nama ?? 'Unknown',
                    'tanggal_sewa' => $activeTransaksi->tanggal_sewa->format('d M Y'),
                    'tanggal_kembali' => $activeTransaksi->tanggal_kembali->format('d M Y'),
                    'jenis_sewa' => $activeTransaksi->hargaSewa->jenisSewa->nama_jenis ?? 'Unknown',
                    'total' => 'Rp ' . number_format($activeTransaksi->total, 0, ',', '.'),
                    'status' => $activeTransaksi->status
                ],
                'is_available' => false
            ];
        }

        // No active transaction = available
        return [
            'date' => $date,
            'status' => 'tersedia',
            'status_text' => 'Tersedia',
            'status_color' => 'bg-green-500',
            'text_color' => 'text-white',
            'transaksi' => null,
            'is_available' => true
        ];
    }

    private function getAvailableCarsToday()
    {
        $today = today()->toDateString();

        // Get all mobil IDs
        $allMobilIds = Mobil::pluck('id');

        // Get mobil IDs that have active transactions today
        $busyMobilIds = Transaksi::whereIn('status', ['dibayar', 'berjalan', 'telat'])
            ->whereDate('tanggal_sewa', '<=', $today)
            ->whereDate('tanggal_kembali', '>=', $today)
            ->pluck('mobil_id');

        // Available = all - busy
        return $allMobilIds->diff($busyMobilIds)->count();
    }

    public function events(Request $request)
    {
        $startDate = Carbon::parse($request->get('start'));
        $endDate = Carbon::parse($request->get('end'));
        $isScheduler = $request->get('scheduler', false);

        // Get transactions in date range - ONLY specific statuses
        $transaksis = Transaksi::forCalendar()
            ->whereIn('status', ['dibayar', 'berjalan', 'telat']) // Only these statuses
            ->where(function($query) use ($startDate, $endDate) {
                $query->whereBetween('tanggal_sewa', [$startDate, $endDate])
                      ->orWhereBetween('tanggal_kembali', [$startDate, $endDate])
                      ->orWhere(function($q) use ($startDate, $endDate) {
                          $q->where('tanggal_sewa', '<=', $startDate)
                            ->where('tanggal_kembali', '>=', $endDate);
                      });
            })
            ->when($request->mobil_id, function($query, $mobilId) {
                return $query->where('mobil_id', $mobilId);
            })
            ->get();

        if ($isScheduler) {
            // DayPilot Scheduler Lite format
            $mobils = $request->mobil_id
                ? Mobil::where('id', $request->mobil_id)->get()
                : Mobil::orderBy('nama_mobil')->get();

            $resources = [];
            foreach ($mobils as $mobil) {
                $resources[] = [
                    'name' => $mobil->nama_mobil . ' - ' . $mobil->plat_nomor,
                    'id' => $mobil->id
                ];
            }

            $events = [];
            foreach ($transaksis as $transaksi) {
                $calendarStatus = $transaksi->calendar_status;

                $events[] = [
                    'id' => $transaksi->id,
                    'text' => $transaksi->pelanggan->nama ?? 'Unknown',
                    'start' => $transaksi->tanggal_sewa->format('Y-m-d\TH:i:s'),
                    'end' => $transaksi->tanggal_kembali->format('Y-m-d\TH:i:s'),
                    'resource' => $transaksi->mobil_id,
                    'transaksi_id' => $transaksi->id,
                    'no_transaksi' => $transaksi->no_transaksi,
                    'pelanggan' => $transaksi->pelanggan->nama ?? 'Unknown',
                    'mobil' => $transaksi->mobil->nama_mobil . ' - ' . $transaksi->mobil->plat_nomor,
                    'status' => $calendarStatus['status'],
                    'status_text' => $calendarStatus['text'],
                    'total' => 'Rp ' . number_format($transaksi->total, 0, ',', '.'),
                    'tanggal_sewa' => $transaksi->tanggal_sewa->format('d M Y'),
                    'tanggal_kembali' => $transaksi->tanggal_kembali->format('d M Y')
                ];
            }

            return response()->json([
                'resources' => $resources,
                'events' => $events
            ]);
        }        // FullCalendar format (if needed for other views)
        $events = [];
        foreach ($transaksis as $transaksi) {
            $calendarStatus = $transaksi->calendar_status;

            $events[] = [
                'id' => 'transaksi_' . $transaksi->id,
                'title' => $transaksi->pelanggan->nama ?? 'Unknown',
                'start' => $transaksi->tanggal_sewa->toDateString(),
                'end' => Carbon::parse($transaksi->tanggal_kembali)->addDay()->toDateString(),
                'resourceId' => $transaksi->mobil_id,
                'extendedProps' => [
                    'transaksi_id' => $transaksi->id,
                    'no_transaksi' => $transaksi->no_transaksi,
                    'pelanggan' => $transaksi->pelanggan->nama ?? 'Unknown',
                    'mobil' => $transaksi->mobil->nama_mobil . ' - ' . $transaksi->mobil->plat_nomor,
                    'status' => $calendarStatus['status'],
                    'status_text' => $calendarStatus['text'],
                    'total' => 'Rp ' . number_format($transaksi->total, 0, ',', '.')
                ]
            ];
        }

        return response()->json([
            'events' => $events
        ]);
    }

    public function show($id)
    {
        $transaksi = Transaksi::with(['mobil', 'pelanggan', 'hargaSewa.jenisSewa', 'sopir'])
            ->findOrFail($id);

        return response()->json([
            'transaksi' => [
                'id' => $transaksi->id,
                'no_transaksi' => $transaksi->no_transaksi,
                'pelanggan' => [
                    'nama' => $transaksi->pelanggan->nama,
                    'no_hp' => $transaksi->pelanggan->no_hp,
                    'alamat' => $transaksi->pelanggan->alamat
                ],
                'mobil' => [
                    'nama' => $transaksi->mobil->nama_mobil,
                    'plat' => $transaksi->mobil->plat_nomor,
                    'merk' => $transaksi->mobil->merk,
                    'model' => $transaksi->mobil->model
                ],
                'sopir' => $transaksi->sopir ? [
                    'nama' => $transaksi->sopir->nama,
                    'no_hp' => $transaksi->sopir->no_hp
                ] : null,
                'jenis_sewa' => $transaksi->hargaSewa->jenisSewa->nama_jenis,
                'tanggal_sewa' => $transaksi->tanggal_sewa->format('d M Y H:i'),
                'tanggal_kembali' => $transaksi->tanggal_kembali->format('d M Y H:i'),
                'tanggal_dikembalikan' => $transaksi->tanggal_dikembalikan?->format('d M Y H:i'),
                'durasi_hari' => $transaksi->durasi_hari,
                'subtotal' => 'Rp ' . number_format($transaksi->subtotal, 0, ',', '.'),
                'biaya_tambahan' => 'Rp ' . number_format($transaksi->biaya_tambahan, 0, ',', '.'),
                'denda' => 'Rp ' . number_format($transaksi->denda, 0, ',', '.'),
                'total' => 'Rp ' . number_format($transaksi->total, 0, ',', '.'),
                'status' => $transaksi->status,
                'status_pembayaran' => $transaksi->status_pembayaran,
                'catatan' => $transaksi->catatan,
                'calendar_status' => $transaksi->calendar_status
            ]
        ]);
    }
}
