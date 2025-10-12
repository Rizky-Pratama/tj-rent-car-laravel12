<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Carbon\Carbon;

class DashboardController extends Controller
{
  public function index()
  {
    // Data dummy hardcode
    $stats = [
      'total_users' => 1248,
      'total_orders' => 324,
      'revenue' => 125750,
      'pending_orders' => 18,
    ];

    $recentOrders = [
      [
        'id' => 'ORD-001',
        'customer' => 'John Doe',
        'car' => 'Toyota Avanza',
        'total' => 1500000,
        'status' => 'completed',
        'date' => '2025-10-08'
      ],
      [
        'id' => 'ORD-002',
        'customer' => 'Jane Smith',
        'car' => 'Honda Jazz',
        'total' => 1200000,
        'status' => 'pending',
        'date' => '2025-10-08'
      ],
      [
        'id' => 'ORD-003',
        'customer' => 'Bob Wilson',
        'car' => 'Mitsubishi Xpander',
        'total' => 1800000,
        'status' => 'completed',
        'date' => '2025-10-07'
      ],
      [
        'id' => 'ORD-004',
        'customer' => 'Alice Johnson',
        'car' => 'Suzuki Ertiga',
        'total' => 1350000,
        'status' => 'in_progress',
        'date' => '2025-10-07'
      ],
      [
        'id' => 'ORD-005',
        'customer' => 'Mike Brown',
        'car' => 'Daihatsu Terios',
        'total' => 1650000,
        'status' => 'completed',
        'date' => '2025-10-06'
      ],
    ];

    $chartData = [
      ['date' => 'Oct 03', 'revenue' => 12500000],
      ['date' => 'Oct 04', 'revenue' => 15200000],
      ['date' => 'Oct 05', 'revenue' => 9800000],
      ['date' => 'Oct 06', 'revenue' => 18300000],
      ['date' => 'Oct 07', 'revenue' => 14700000],
      ['date' => 'Oct 08', 'revenue' => 21200000],
      ['date' => 'Oct 09', 'revenue' => 16400000],
    ];

    return view('admin.dashboard', compact('stats', 'recentOrders', 'chartData'));
  }
}
