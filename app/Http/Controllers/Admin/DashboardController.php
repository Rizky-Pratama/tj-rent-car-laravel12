<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Pelanggan;
use App\Models\Mobil;
use App\Models\Transaksi;
use App\Models\Pembayaran;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
  public function index()
  {
    // Statistik real dari database
    $stats = [
      'total_pengguna' => User::count(),
      'total_pelanggan' => Pelanggan::count(),
      'total_transaksi' => Transaksi::count(),
      'pendapatan_bulan_ini' => (int) $this->getPendapatanBulanIni(),
      'transaksi_pending' => Transaksi::where('status', 'pending')->count(),
      'transaksi_berjalan' => Transaksi::where('status', 'berjalan')->count(),
    ];

    // Status mobil
    $statusMobil = [
      'tersedia' => Mobil::where('status', 'tersedia')->count(),
      'disewa' => Mobil::where('status', 'disewa')->count(),
      'perawatan' => Mobil::where('status', 'perawatan')->count(),
      'nonaktif' => Mobil::where('status', 'nonaktif')->count(),
    ];

    // Mobil terpopuler berdasarkan jumlah transaksi
    $mobilTerpopuler = Mobil::withCount(['transaksi' => function ($query) {
        $query->whereMonth('created_at', Carbon::now()->month)
              ->whereYear('created_at', Carbon::now()->year);
    }])
    ->orderBy('transaksi_count', 'desc')
    ->take(3)
    ->get();

    // Transaksi terbaru
    $transaksiTerbaru = Transaksi::with(['pelanggan', 'mobil'])
      ->orderBy('created_at', 'desc')
      ->take(5)
      ->get()
      ->map(function ($transaksi) {
        return [
          'no_transaksi' => $transaksi->no_transaksi,
          'pelanggan' => $transaksi->pelanggan->nama,
          'mobil' => $transaksi->mobil->nama_mobil,
          'total' => $transaksi->total,
          'status' => $transaksi->status,
          'tanggal' => $transaksi->created_at->format('Y-m-d'),
        ];
      });

    // Data chart pendapatan 7 hari terakhir
    $chartData = $this->getChartDataPendapatan();

    return view('admin.dashboard', compact(
      'stats',
      'statusMobil',
      'mobilTerpopuler',
      'transaksiTerbaru',
      'chartData'
    ));
  }

  private function getPendapatanBulanIni()
  {
    return Pembayaran::where('status', 'terkonfirmasi')
      ->whereMonth('tanggal_bayar', Carbon::now()->month)
      ->whereYear('tanggal_bayar', Carbon::now()->year)
      ->sum('jumlah');
  }

  private function getChartDataPendapatan()
  {
    $data = [];

    for ($i = 6; $i >= 0; $i--) {
      $tanggal = Carbon::now()->subDays($i);

      $pendapatan = Pembayaran::where('status', 'terkonfirmasi')
        ->whereDate('tanggal_bayar', $tanggal->format('Y-m-d'))
        ->sum('jumlah');

      $data[] = [
        'date' => $tanggal->format('M d'),
        'revenue' => $pendapatan
      ];
    }

    return $data;
  }
}
