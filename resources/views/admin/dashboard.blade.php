@extends('layouts.admin')

@section('title', 'Dashboard')
@section('page-title', 'Dashboard')
@section('page-subtitle', 'Selamat datang! Berikut adalah ringkasan bisnis rental mobil Anda.')

@push('styles')
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
@endpush

@section('content')

    <x-admin.breadcrumb :breadcrumbs="[['title' => 'Dashboard', 'url' => route('admin.dashboard')]]" />

    <!-- Stats Cards -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
        <x-admin.stat-card title="Total Pengguna" :value="$stats['total_pengguna']" color="blue" trend="up"
            icon="heroicons:users-20-solid" />

        <x-admin.stat-card title="Total Pelanggan" :value="$stats['total_pelanggan']" color="emerald" trend="up"
            icon="heroicons:user-group-20-solid" />

        <x-admin.stat-card title="Total Transaksi" :value="$stats['total_transaksi']" color="indigo" trend="up"
            icon="heroicons:clipboard-document-list-20-solid" />

        {{-- <x-admin.stat-card title="Pendapatan Bulan Ini" :value="'Rp ' . number_format($stats['pendapatan_bulan_ini'], 0, ',', '.')" color="purple" trend="up" --}}
        <x-admin.stat-card title="Pendapatan Bulan Ini" :value="$stats['pendapatan_bulan_ini']" color="purple" trend="up"
            icon="heroicons:banknotes-20-solid" />
    </div>

    <!-- Additional Stats -->
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
        <x-admin.stat-card title="Transaksi Pending" :value="$stats['transaksi_pending']" color="amber" trend="neutral"
            icon="heroicons:clock-20-solid" />

        <x-admin.stat-card title="Transaksi Berjalan" :value="$stats['transaksi_berjalan']" color="blue" trend="neutral"
            icon="heroicons:arrow-path-20-solid" />
    </div>

    <!-- Charts and Recent Activity -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-8">
        <!-- Revenue Chart -->
        <div
            class="lg:col-span-2 bg-white dark:bg-gray-800 rounded-2xl shadow-sm border border-gray-100 dark:border-gray-700 p-6">
            <div class="flex items-center justify-between mb-6">
                <div>
                    <h3 class="text-lg font-semibold text-gray-800 dark:text-white">Grafik Pendapatan</h3>
                    <p class="text-sm text-gray-500 dark:text-gray-400">Performa 7 hari terakhir</p>
                </div>
                <div class="flex space-x-2">
                    <button
                        class="px-3 py-1 text-xs font-medium bg-indigo-100 dark:bg-indigo-900/50 text-indigo-600 dark:text-indigo-400 rounded-lg">7H</button>
                    <button
                        class="px-3 py-1 text-xs font-medium text-gray-500 dark:text-gray-400 hover:bg-gray-100 dark:hover:bg-gray-700 rounded-lg">30H</button>
                    <button
                        class="px-3 py-1 text-xs font-medium text-gray-500 dark:text-gray-400 hover:bg-gray-100 dark:hover:bg-gray-700 rounded-lg">90H</button>
                </div>
            </div>
            <div class="relative h-80">
                <canvas id="revenueChart"></canvas>
            </div>
        </div>

        <!-- Quick Stats -->
        <div class="space-y-6">
            <!-- Cars Status -->
            <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-sm border border-gray-100 dark:border-gray-700 p-6">
                <h3 class="text-lg font-semibold text-gray-800 dark:text-white mb-4">Status Mobil</h3>
                <div class="space-y-4">
                    <div class="flex items-center justify-between">
                        <div class="flex items-center space-x-3">
                            <div class="w-3 h-3 bg-emerald-500 rounded-full"></div>
                            <span class="text-sm text-gray-600 dark:text-gray-400">Tersedia</span>
                        </div>
                        <span
                            class="text-sm font-semibold text-gray-800 dark:text-white">{{ $statusMobil['tersedia'] }}</span>
                    </div>
                    <div class="flex items-center justify-between">
                        <div class="flex items-center space-x-3">
                            <div class="w-3 h-3 bg-blue-500 rounded-full"></div>
                            <span class="text-sm text-gray-600 dark:text-gray-400">Disewa</span>
                        </div>
                        <span
                            class="text-sm font-semibold text-gray-800 dark:text-white">{{ $statusMobil['disewa'] }}</span>
                    </div>
                    <div class="flex items-center justify-between">
                        <div class="flex items-center space-x-3">
                            <div class="w-3 h-3 bg-amber-500 rounded-full"></div>
                            <span class="text-sm text-gray-600 dark:text-gray-400">Perawatan</span>
                        </div>
                        <span
                            class="text-sm font-semibold text-gray-800 dark:text-white">{{ $statusMobil['perawatan'] }}</span>
                    </div>
                    <div class="flex items-center justify-between">
                        <div class="flex items-center space-x-3">
                            <div class="w-3 h-3 bg-red-500 rounded-full"></div>
                            <span class="text-sm text-gray-600 dark:text-gray-400">Non Aktif</span>
                        </div>
                        <span
                            class="text-sm font-semibold text-gray-800 dark:text-white">{{ $statusMobil['nonaktif'] }}</span>
                    </div>
                </div>
            </div>

            <!-- Top Performing Cars -->
            <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-sm border border-gray-100 dark:border-gray-700 p-6">
                <h3 class="text-lg font-semibold text-gray-800 dark:text-white mb-4">Mobil Terpopuler</h3>
                <div class="space-y-3">
                    @forelse($mobilTerpopuler as $index => $mobil)
                        <div class="flex items-center justify-between p-3 bg-gray-50 dark:bg-gray-700 rounded-xl">
                            <div>
                                <p class="text-sm font-medium text-gray-800 dark:text-white">{{ $mobil->nama_mobil }}</p>
                                <p class="text-xs text-gray-500 dark:text-gray-400">{{ $mobil->transaksi_count }} transaksi
                                </p>
                            </div>
                            <div
                                class="w-8 h-8 rounded-lg flex items-center justify-center {{ $index === 0 ? 'bg-yellow-100 dark:bg-yellow-900/50' : ($index === 1 ? 'bg-gray-100 dark:bg-gray-600' : 'bg-orange-100 dark:bg-orange-900/50') }}">
                                @if ($index === 0)
                                    🏆
                                @elseif($index === 1)
                                    🥈
                                @else
                                    🥉
                                @endif
                            </div>
                        </div>
                    @empty
                        <div class="text-center py-4">
                            <p class="text-sm text-gray-500 dark:text-gray-400">Belum ada data mobil</p>
                        </div>
                    @endforelse
                </div>
            </div>
        </div>
    </div>

    <!-- Recent Transactions -->
    <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-sm border border-gray-100 dark:border-gray-700">
        <div class="p-6 border-b border-gray-200 dark:border-gray-700">
            <div class="flex flex-col md:flex-row items-center gap-2 justify-between">
                <div class="text-center md:text-left">
                    <h3 class="lg:text-lg font-semibold text-gray-800 dark:text-white">Transaksi Terbaru</h3>
                    <p class="text-sm lg:text-base text-gray-500 dark:text-gray-400">Transaksi rental terbaru</p>
                </div>
                <a href="{{ route('admin.transaksi.index') }}"
                    class="px-4 py-2 text-sm font-medium text-indigo-600 dark:text-indigo-400 hover:text-indigo-800 dark:hover:text-indigo-300 bg-indigo-50 dark:bg-indigo-900/50 rounded-xl hover:bg-indigo-100 dark:hover:bg-indigo-900/70 transition-colors duration-200">
                    Lihat Semua
                </a>
            </div>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full">
                <thead class="bg-gray-50 dark:bg-gray-700/50">
                    <tr>
                        <th
                            class="px-6 py-4 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">
                            No. Transaksi</th>
                        <th
                            class="px-6 py-4 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">
                            Pelanggan</th>
                        <th
                            class="px-6 py-4 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">
                            Mobil</th>
                        <th
                            class="px-6 py-4 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">
                            Total</th>
                        <th
                            class="px-6 py-4 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">
                            Status</th>
                        <th
                            class="px-6 py-4 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">
                            Tanggal</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200 dark:divide-gray-700">
                    @forelse ($transaksiTerbaru as $transaksi)
                        <tr class="hover:bg-gray-50 dark:hover:bg-gray-700/50 transition-colors duration-150">
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm font-medium text-gray-900 dark:text-white">
                                    {{ $transaksi['no_transaksi'] }}</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="flex items-center">
                                    <img class="w-8 h-8 rounded-full mr-3"
                                        src="https://ui-avatars.com/api/?name={{ urlencode($transaksi['pelanggan']) }}&color=7C3AED&background=EDE9FE&size=32"
                                        alt="{{ $transaksi['pelanggan'] }}">
                                    <div class="text-sm font-medium text-gray-900 dark:text-white">
                                        {{ $transaksi['pelanggan'] }}
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm text-gray-900 dark:text-white">{{ $transaksi['mobil'] }}</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm font-medium text-gray-900 dark:text-white">
                                    {{ 'Rp ' . number_format($transaksi['total'], 0, ',', '.') }}</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                @php
                                    $statusClasses = [
                                        'selesai' =>
                                            'bg-emerald-100 dark:bg-emerald-900/50 text-emerald-800 dark:text-emerald-300',
                                        'pending' =>
                                            'bg-amber-100 dark:bg-amber-900/50 text-amber-800 dark:text-amber-300',
                                        'berjalan' =>
                                            'bg-blue-100 dark:bg-blue-900/50 text-blue-800 dark:text-blue-300',
                                        'dibayar' =>
                                            'bg-green-100 dark:bg-green-900/50 text-green-800 dark:text-green-300',
                                        'batal' => 'bg-red-100 dark:bg-red-900/50 text-red-800 dark:text-red-300',
                                        'telat' =>
                                            'bg-orange-100 dark:bg-orange-900/50 text-orange-800 dark:text-orange-300',
                                    ];

                                    $statusLabels = [
                                        'selesai' => 'Selesai',
                                        'pending' => 'Pending',
                                        'berjalan' => 'Berjalan',
                                        'dibayar' => 'Dibayar',
                                        'batal' => 'Batal',
                                        'telat' => 'Telat',
                                    ];
                                @endphp
                                <span
                                    class="inline-flex px-3 py-1 text-xs font-medium rounded-full {{ $statusClasses[$transaksi['status']] ?? 'bg-gray-100 dark:bg-gray-900/50 text-gray-800 dark:text-gray-300' }}">
                                    {{ $statusLabels[$transaksi['status']] ?? ucfirst($transaksi['status']) }}
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400">
                                {{ \Carbon\Carbon::parse($transaksi['tanggal'])->format('d M Y') }}
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-6 py-8 text-center text-gray-500 dark:text-gray-400">
                                Belum ada transaksi
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Revenue Chart
            const ctx = document.getElementById('revenueChart').getContext('2d');
            const chartData = @json($chartData);

            new Chart(ctx, {
                type: 'line',
                data: {
                    labels: chartData.map(item => item.date),
                    datasets: [{
                        label: 'Pendapatan',
                        data: chartData.map(item => item.revenue),
                        borderColor: '#6366F1',
                        backgroundColor: 'rgba(99, 102, 241, 0.1)',
                        borderWidth: 3,
                        fill: true,
                        tension: 0.4,
                        pointBackgroundColor: '#6366F1',
                        pointBorderColor: '#ffffff',
                        pointBorderWidth: 2,
                        pointRadius: 6,
                        pointHoverRadius: 8,
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            display: false
                        },
                        tooltip: {
                            backgroundColor: 'rgba(0, 0, 0, 0.8)',
                            titleColor: '#ffffff',
                            bodyColor: '#ffffff',
                            borderColor: '#6366F1',
                            borderWidth: 1,
                            cornerRadius: 8,
                            displayColors: false,
                            callbacks: {
                                label: function(context) {
                                    return 'Rp ' + new Intl.NumberFormat('id-ID').format(context.parsed
                                        .y);
                                }
                            }
                        }
                    },
                    scales: {
                        x: {
                            grid: {
                                display: false
                            },
                            border: {
                                display: false
                            },
                            ticks: {
                                color: '#9CA3AF'
                            }
                        },
                        y: {
                            grid: {
                                color: 'rgba(156, 163, 175, 0.1)'
                            },
                            border: {
                                display: false
                            },
                            ticks: {
                                color: '#9CA3AF',
                                callback: function(value) {
                                    return 'Rp ' + (value / 1000000).toFixed(0) + 'M';
                                }
                            }
                        }
                    },
                    interaction: {
                        intersect: false,
                        mode: 'index'
                    }
                }
            });
        });
    </script>
@endpush
