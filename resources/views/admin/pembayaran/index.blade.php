@extends('layouts.admin')

@section('title', 'Kelola Pembayaran')
@section('page-title', 'Kelola Pembayaran')
@section('page-subtitle', 'Kelola semua pembayaran transaksi rental mobil')

@section('content')

    <!-- Stats Cards -->
    <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-5 xl:grid-cols-6 gap-4 mb-8">
        <!-- Total -->
        <div
            class="flex items-center bg-white dark:bg-gray-800 rounded-2xl shadow-sm border border-gray-100 dark:border-gray-700 p-4">
            <div class="flex items-center">
                <div class="flex-shrink-0">
                    <div class="w-10 h-10 bg-gray-100 dark:bg-gray-700 rounded-lg flex items-center justify-center">
                        <iconify-icon icon="heroicons:credit-card-20-solid"
                            class="w-5 h-5 text-gray-600 dark:text-gray-400"></iconify-icon>
                    </div>
                </div>
                <div class="ml-3">
                    <p class="text-xs font-medium text-gray-600 dark:text-gray-400">Total</p>
                    <p class="text-lg font-semibold text-gray-900 dark:text-white">{{ $statistik['total'] }}</p>
                </div>
            </div>
        </div>

        <!-- Pending -->
        <div
            class="flex items-center bg-white dark:bg-gray-800 rounded-2xl shadow-sm border border-gray-100 dark:border-gray-700 p-4">
            <div class="flex items-center">
                <div class="flex-shrink-0">
                    <div class="w-10 h-10 bg-yellow-100 dark:bg-yellow-900 rounded-lg flex items-center justify-center">
                        <iconify-icon icon="heroicons:clock-20-solid"
                            class="w-5 h-5 text-yellow-600 dark:text-yellow-400"></iconify-icon>
                    </div>
                </div>
                <div class="ml-3">
                    <p class="text-xs font-medium text-gray-600 dark:text-gray-400">Pending</p>
                    <p class="text-lg font-semibold text-gray-900 dark:text-white">{{ $statistik['pending'] }}</p>
                </div>
            </div>
        </div>

        <!-- Terkonfirmasi -->
        <div
            class="flex items-center bg-white dark:bg-gray-800 rounded-2xl shadow-sm border border-gray-100 dark:border-gray-700 p-4">
            <div class="flex items-center">
                <div class="flex-shrink-0">
                    <div class="w-10 h-10 bg-green-100 dark:bg-green-900 rounded-lg flex items-center justify-center">
                        <iconify-icon icon="heroicons:check-circle-20-solid"
                            class="w-5 h-5 text-green-600 dark:text-green-400"></iconify-icon>
                    </div>
                </div>
                <div class="ml-3">
                    <p class="text-xs font-medium text-gray-600 dark:text-gray-400">Terkonfirmasi</p>
                    <p class="text-lg font-semibold text-gray-900 dark:text-white">{{ $statistik['terkonfirmasi'] }}</p>
                </div>
            </div>
        </div>

        <!-- Gagal -->
        <div
            class="flex items-center bg-white dark:bg-gray-800 rounded-2xl shadow-sm border border-gray-100 dark:border-gray-700 p-4">
            <div class="flex items-center">
                <div class="flex-shrink-0">
                    <div class="w-10 h-10 bg-red-100 dark:bg-red-900 rounded-lg flex items-center justify-center">
                        <iconify-icon icon="heroicons:x-circle-20-solid"
                            class="w-5 h-5 text-red-600 dark:text-red-400"></iconify-icon>
                    </div>
                </div>
                <div class="ml-3">
                    <p class="text-xs font-medium text-gray-600 dark:text-gray-400">Gagal</p>
                    <p class="text-lg font-semibold text-gray-900 dark:text-white">{{ $statistik['gagal'] }}</p>
                </div>
            </div>
        </div>

        <!-- Refund -->
        <div
            class="flex items-center bg-white dark:bg-gray-800 rounded-2xl shadow-sm border border-gray-100 dark:border-gray-700 p-4">
            <div class="flex items-center">
                <div class="flex-shrink-0">
                    <div class="w-10 h-10 bg-purple-100 dark:bg-purple-900 rounded-lg flex items-center justify-center">
                        <iconify-icon icon="heroicons:arrow-uturn-left-20-solid"
                            class="w-5 h-5 text-purple-600 dark:text-purple-400"></iconify-icon>
                    </div>
                </div>
                <div class="ml-3">
                    <p class="text-xs font-medium text-gray-600 dark:text-gray-400">Refund</p>
                    <p class="text-lg font-semibold text-gray-900 dark:text-white">{{ $statistik['refund'] }}</p>
                </div>
            </div>
        </div>

        <!-- Total Nilai -->
        <div
            class="flex items-center bg-white dark:bg-gray-800 rounded-2xl shadow-sm border border-gray-100 dark:border-gray-700 p-4">
            <div class="flex items-center">
                <div class="flex-shrink-0">
                    <div class="w-10 h-10 bg-blue-100 dark:bg-blue-900 rounded-lg flex items-center justify-center">
                        <iconify-icon icon="heroicons:banknotes-20-solid"
                            class="w-5 h-5 text-blue-600 dark:text-blue-400"></iconify-icon>
                    </div>
                </div>
                <div class="ml-3">
                    <p class="text-xs font-medium text-gray-600 dark:text-gray-400">Total Nilai</p>
                    <p class="text-lg font-semibold text-gray-900 dark:text-white">Rp
                        {{ number_format($statistik['total_nilai'], 0, ',', '.') }}</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Search and Filter Bar -->
    <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-sm border border-gray-100 dark:border-gray-700 p-6 mb-6"
        x-data="{
            activePeriod: '{{ $filters['period'] ?? (request()->hasAny(['search', 'status', 'metode', 'date_from', 'date_to']) ? '' : 'today') }}',
            showCustomRange: {{ ($filters['period'] ?? '') === 'custom' ? 'true' : 'false' }},
            toggleCustomDate() {
                this.showCustomRange = !this.showCustomRange;
                this.activePeriod = this.showCustomRange ? 'custom' : '';
            }
        }">
        <form method="GET" action="{{ route('admin.pembayaran.index') }}" class="space-y-4">
            <!-- Search -->
            <div class="flex-1">
                <div class="relative">
                    <input type="text" name="search" value="{{ $filters['search'] ?? '' }}"
                        placeholder="Cari berdasarkan nomor transaksi atau pelanggan..."
                        class="w-full px-4 py-2 pl-10 pr-4 text-sm bg-gray-50 dark:bg-gray-700 border border-gray-200 dark:border-gray-600 rounded-xl focus:ring-2 focus:ring-indigo-500 dark:focus:ring-indigo-400 focus:border-transparent">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <iconify-icon icon="heroicons:magnifying-glass-20-solid"
                            class="w-4 h-4 text-gray-400"></iconify-icon>
                    </div>
                </div>
            </div>

            <!-- Quick Period Filters -->
            <div class="flex flex-wrap gap-2">
                <span class="text-sm font-medium text-gray-700 dark:text-gray-300 self-center">Periode:</span>
                @foreach ([
            'today' => 'Hari Ini',
            'yesterday' => 'Kemarin',
            'this_week' => 'Minggu Ini',
            'this_month' => 'Bulan Ini',
            'last_month' => 'Bulan Lalu',
            'this_year' => 'Tahun Ini',
        ] as $value => $label)
                    <button type="submit" name="period" value="{{ $value }}"
                        @click="activePeriod = '{{ $value }}'; showCustomRange = false"
                        :class="activePeriod === '{{ $value }}'
                            ?
                            'bg-indigo-100 text-indigo-800 dark:bg-indigo-900 dark:text-indigo-200' :
                            'bg-gray-100 hover:bg-gray-200 text-gray-700 dark:bg-gray-700 dark:hover:bg-gray-600 dark:text-gray-300'"
                        class="px-3 py-1 text-sm rounded-lg transition-colors duration-200">
                        {{ $label }}
                    </button>
                @endforeach
                <button type="button" @click="toggleCustomDate()"
                    :class="activePeriod === 'custom'
                        ?
                        'bg-indigo-100 text-indigo-800 dark:bg-indigo-900 dark:text-indigo-200' :
                        'bg-gray-100 hover:bg-gray-200 text-gray-700 dark:bg-gray-700 dark:hover:bg-gray-600 dark:text-gray-300'"
                    class="px-3 py-1 text-sm rounded-lg transition-colors duration-200">
                    Custom
                </button>
            </div>

            <!-- Custom Date Range -->
            <div x-show="showCustomRange" x-transition:enter="transition ease-out duration-200"
                x-transition:enter-start="opacity-0 scale-95" x-transition:enter-end="opacity-100 scale-100"
                x-transition:leave="transition ease-in duration-150" x-transition:leave-start="opacity-100 scale-100"
                x-transition:leave-end="opacity-0 scale-95"
                class="grid grid-cols-1 md:grid-cols-2 gap-4 p-4 bg-gray-50 dark:bg-gray-700 rounded-xl">
                <input type="hidden" name="period" value="custom" x-bind:disabled="!showCustomRange">
                <div>
                    <label class="block text-xs font-medium text-gray-700 dark:text-gray-300 mb-1">Dari Tanggal</label>
                    <input type="date" name="date_from" value="{{ $filters['date_from'] ?? '' }}"
                        class="w-full px-3 py-2 text-sm bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-indigo-500">
                </div>
                <div>
                    <label class="block text-xs font-medium text-gray-700 dark:text-gray-300 mb-1">Sampai Tanggal</label>
                    <input type="date" name="date_to" value="{{ $filters['date_to'] ?? '' }}"
                        class="w-full px-3 py-2 text-sm bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-indigo-500">
                </div>
            </div>

            <!-- Advanced Filters Row -->
            <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                <!-- Status Filter -->
                <div>
                    <label class="block text-xs font-medium text-gray-700 dark:text-gray-300 mb-1">Status</label>
                    <select name="status"
                        class="w-full px-3 py-2 text-sm bg-gray-50 dark:bg-gray-700 border border-gray-200 dark:border-gray-600 rounded-xl focus:ring-2 focus:ring-indigo-500">
                        <option value="all">Semua Status</option>
                        <option value="pending" {{ ($filters['status'] ?? '') == 'pending' ? 'selected' : '' }}>Pending
                        </option>
                        <option value="terkonfirmasi"
                            {{ ($filters['status'] ?? '') == 'terkonfirmasi' ? 'selected' : '' }}>Terkonfirmasi</option>
                        <option value="gagal" {{ ($filters['status'] ?? '') == 'gagal' ? 'selected' : '' }}>Gagal
                        </option>
                        <option value="refund" {{ ($filters['status'] ?? '') == 'refund' ? 'selected' : '' }}>Refund
                        </option>
                    </select>
                </div>

                <!-- Metode Filter -->
                <div>
                    <label class="block text-xs font-medium text-gray-700 dark:text-gray-300 mb-1">Metode</label>
                    <select name="metode"
                        class="w-full px-3 py-2 text-sm bg-gray-50 dark:bg-gray-700 border border-gray-200 dark:border-gray-600 rounded-xl focus:ring-2 focus:ring-indigo-500">
                        <option value="all">Semua Metode</option>
                        <option value="tunai" {{ ($filters['metode'] ?? '') == 'tunai' ? 'selected' : '' }}>Tunai
                        </option>
                        <option value="transfer" {{ ($filters['metode'] ?? '') == 'transfer' ? 'selected' : '' }}>Transfer
                        </option>
                        <option value="qris" {{ ($filters['metode'] ?? '') == 'qris' ? 'selected' : '' }}>QRIS</option>
                        <option value="kartu" {{ ($filters['metode'] ?? '') == 'kartu' ? 'selected' : '' }}>Kartu
                        </option>
                        <option value="ewallet" {{ ($filters['metode'] ?? '') == 'ewallet' ? 'selected' : '' }}>E-Wallet
                        </option>
                    </select>
                </div>

                <!-- Action Buttons -->
                <div class="flex gap-2 items-end md:col-span-2">
                    <button type="submit"
                        class="flex gap-2 items-center px-4 py-2 bg-indigo-600 hover:bg-indigo-700 text-white text-sm font-medium rounded-xl transition-colors duration-200">
                        <iconify-icon icon="heroicons:funnel-20-solid" class="w-4 h-4"></iconify-icon>
                        Filter
                    </button>

                    @if (request()->hasAny(['search', 'status', 'period', 'metode', 'date_from', 'date_to']))
                        <a href="{{ route('admin.pembayaran.index') }}"
                            class="px-3 py-2 bg-gray-500 hover:bg-gray-600 text-white text-sm font-medium rounded-xl transition-colors duration-200"
                            title="Reset Filter">
                            <iconify-icon icon="heroicons:x-mark-20-solid" width="20" height="20"></iconify-icon>
                        </a>
                    @endif
                </div>
            </div>
        </form>
    </div>

    <!-- Pembayaran Table -->
    <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-sm border border-gray-100 dark:border-gray-700">
        <!-- Header -->
        <div class="px-6 py-4 border-b border-gray-200 dark:border-gray-700">
            <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
                <div>
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-white">Daftar Pembayaran</h3>
                    <p class="text-sm text-gray-600 dark:text-gray-400">
                        @if (!empty($filters['period']))
                            @if ($filters['period'] == 'today')
                                Pembayaran hari ini
                            @elseif ($filters['period'] == 'yesterday')
                                Pembayaran kemarin
                            @elseif ($filters['period'] == 'this_week')
                                Pembayaran minggu ini
                            @elseif ($filters['period'] == 'this_month')
                                Pembayaran bulan ini
                            @elseif ($filters['period'] == 'last_month')
                                Pembayaran bulan lalu
                            @elseif ($filters['period'] == 'this_year')
                                Pembayaran tahun ini
                            @elseif ($filters['period'] == 'custom' && !empty($filters['date_from']) && !empty($filters['date_to']))
                                @if ($filters['date_from'] == $filters['date_to'])
                                    Pembayaran tanggal {{ \Carbon\Carbon::parse($filters['date_from'])->format('d M Y') }}
                                @else
                                    Pembayaran periode {{ \Carbon\Carbon::parse($filters['date_from'])->format('d M Y') }}
                                    -
                                    {{ \Carbon\Carbon::parse($filters['date_to'])->format('d M Y') }}
                                @endif
                            @else
                                Pembayaran periode custom
                            @endif
                        @else
                            Semua pembayaran rental mobil
                        @endif
                    </p>
                </div>
                <a href="{{ route('admin.pembayaran.create') }}"
                    class="inline-flex items-center px-4 py-2 bg-indigo-600 hover:bg-indigo-700 text-white text-sm font-medium rounded-xl transition-colors duration-200">
                    <iconify-icon icon="heroicons:plus-20-solid" class="w-4 h-4 mr-2"></iconify-icon>
                    Tambah Pembayaran
                </a>
            </div>
        </div>

        <!-- Table -->
        <div class="overflow-x-auto">
            <table class="w-full divide-y divide-gray-200 dark:divide-gray-700">
                <thead class="bg-gray-50 dark:bg-gray-700">
                    <tr>
                        <th
                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                            Transaksi
                        </th>
                        <th
                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                            Pelanggan
                        </th>
                        <th
                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                            Pembayaran
                        </th>
                        <th
                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                            Status & Metode
                        </th>
                        <th
                            class="px-6 py-3 text-right text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                            Aksi
                        </th>
                    </tr>
                </thead>
                <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                    @forelse ($pembayaran as $item)
                        <tr class="hover:bg-gray-50 dark:hover:bg-gray-700">
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="flex items-center">
                                    <div class="flex-shrink-0 h-10 w-10">
                                        <div
                                            class="h-10 w-10 bg-gradient-to-r from-blue-500 to-purple-600 rounded-full flex items-center justify-center">
                                            <iconify-icon icon="heroicons:credit-card-20-solid"
                                                class="w-5 h-5 text-white"></iconify-icon>
                                        </div>
                                    </div>
                                    <div class="ml-4">
                                        <div class="text-sm font-medium text-gray-900 dark:text-white">
                                            {{ $item->transaksi->no_transaksi }}
                                        </div>
                                        <div class="text-sm text-gray-500 dark:text-gray-400">
                                            {{ $item->created_at->format('d M Y, H:i') }}
                                        </div>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm text-gray-900 dark:text-white">
                                    <div class="font-medium">{{ $item->transaksi->pelanggan->nama }}</div>
                                    <div class="text-gray-500 dark:text-gray-400">
                                        {{ $item->transaksi->pelanggan->telepon }}</div>
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm font-medium text-gray-900 dark:text-white">
                                    Rp {{ number_format($item->jumlah, 0, ',', '.') }}
                                </div>
                                <div class="text-sm text-gray-500 dark:text-gray-400">
                                    {{ $item->tanggal_bayar ? $item->tanggal_bayar->format('d M Y') : '-' }}
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="mb-1">
                                    @if ($item->status === 'pending')
                                        <span
                                            class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800 dark:bg-yellow-900 dark:text-yellow-200">
                                            <iconify-icon icon="heroicons:clock-20-solid"
                                                class="w-3 h-3 mr-1"></iconify-icon>
                                            Pending
                                        </span>
                                    @elseif ($item->status === 'terkonfirmasi')
                                        <span
                                            class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200">
                                            <iconify-icon icon="heroicons:check-circle-20-solid"
                                                class="w-3 h-3 mr-1"></iconify-icon>
                                            Terkonfirmasi
                                        </span>
                                    @elseif ($item->status === 'gagal')
                                        <span
                                            class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-200">
                                            <iconify-icon icon="heroicons:x-circle-20-solid"
                                                class="w-3 h-3 mr-1"></iconify-icon>
                                            Gagal
                                        </span>
                                    @else
                                        <span
                                            class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-purple-100 text-purple-800 dark:bg-purple-900 dark:text-purple-200">
                                            <iconify-icon icon="heroicons:arrow-uturn-left-20-solid"
                                                class="w-3 h-3 mr-1"></iconify-icon>
                                            Refund
                                        </span>
                                    @endif
                                </div>
                                <div class="text-xs text-gray-500 dark:text-gray-400 capitalize">
                                    {{ ucfirst($item->metode) }}
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                <div class="flex items-center justify-end space-x-2">
                                    <a href="{{ route('admin.pembayaran.show', $item->id) }}"
                                        class="text-gray-400 hover:text-gray-600 dark:hover:text-gray-300"
                                        title="Lihat Detail">
                                        <iconify-icon icon="heroicons:eye-20-solid" class="w-4 h-4"></iconify-icon>
                                    </a>

                                    @if ($item->status == 'pending')
                                        <a href="{{ route('admin.pembayaran.edit', $item->id) }}"
                                            class="text-indigo-600 hover:text-indigo-900 dark:text-indigo-400 dark:hover:text-indigo-300"
                                            title="Edit">
                                            <iconify-icon icon="heroicons:pencil-20-solid" class="w-4 h-4"></iconify-icon>
                                        </a>
                                    @endif
                                    @if ($item->status == 'pending')
                                        <!-- Quick Actions Dropdown -->
                                        <div class="relative inline-block text-left" x-data="{ open: false }"
                                            @click.away="open = false">
                                            <button type="button"
                                                class="text-gray-400 hover:text-gray-600 dark:hover:text-gray-300 focus:outline-none"
                                                @click="open = !open" title="Aksi Lainnya">
                                                <iconify-icon icon="heroicons:ellipsis-vertical-20-solid"
                                                    class="w-4 h-4"></iconify-icon>
                                            </button>

                                            <div x-show="open" x-transition:enter="transition ease-out duration-100"
                                                x-transition:enter-start="transform opacity-0 scale-95"
                                                x-transition:enter-end="transform opacity-100 scale-100"
                                                x-transition:leave="transition ease-in duration-75"
                                                x-transition:leave-start="transform opacity-100 scale-100"
                                                x-transition:leave-end="transform opacity-0 scale-95"
                                                class="absolute right-0 z-10 mt-2 w-48 origin-top-right rounded-md bg-white dark:bg-gray-700 shadow-lg ring-1 ring-black/5 focus:outline-none"
                                                @click.away="open = false">
                                                <div class="py-1">
                                                    <form action="{{ route('admin.pembayaran.updateStatus', $item->id) }}"
                                                        method="POST" class="block">
                                                        @csrf
                                                        @method('PATCH')
                                                        <input type="hidden" name="status" value="terkonfirmasi">
                                                        <button type="submit"
                                                            class="flex items-center w-full text-left px-4 py-2 text-sm text-green-700 dark:text-green-300 hover:bg-gray-100 dark:hover:bg-gray-600"
                                                            onclick="return confirm('Konfirmasi pembayaran ini?')">
                                                            <iconify-icon icon="heroicons:check-circle-20-solid"
                                                                class="w-4 h-4 mr-2"></iconify-icon>
                                                            Konfirmasi
                                                        </button>
                                                    </form>

                                                    <form action="{{ route('admin.pembayaran.updateStatus', $item->id) }}"
                                                        method="POST" class="block">
                                                        @csrf
                                                        @method('PATCH')
                                                        <input type="hidden" name="status" value="gagal">
                                                        <button type="submit"
                                                            class="flex items-center w-full text-left px-4 py-2 text-sm text-red-700 dark:text-red-300 hover:bg-gray-100 dark:hover:bg-gray-600"
                                                            onclick="return confirm('Tandai pembayaran sebagai gagal?')">
                                                            <iconify-icon icon="heroicons:x-circle-20-solid"
                                                                class="w-4 h-4 mr-2"></iconify-icon>
                                                            Gagal
                                                        </button>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    @endif
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-6 py-12 text-center">
                                <div class="flex flex-col items-center">
                                    <iconify-icon icon="heroicons:credit-card-20-solid"
                                        class="w-12 h-12 text-gray-400 mb-4"></iconify-icon>
                                    <h3 class="text-sm font-medium text-gray-900 dark:text-white mb-1">Belum ada pembayaran
                                    </h3>
                                    <p class="text-sm text-gray-500 dark:text-gray-400 mb-4">
                                        @if (
                                            !empty($filters['period']) ||
                                                !empty($filters['date_from']) ||
                                                !empty($filters['status']) ||
                                                !empty($filters['search']))
                                            Tidak ada pembayaran yang sesuai dengan filter yang dipilih
                                        @else
                                            Mulai dengan membuat pembayaran baru
                                        @endif
                                    </p>
                                    <a href="{{ route('admin.pembayaran.create') }}"
                                        class="inline-flex items-center px-4 py-2 bg-indigo-600 hover:bg-indigo-700 text-white text-sm font-medium rounded-xl transition-colors duration-200">
                                        <iconify-icon icon="heroicons:plus-20-solid" class="w-4 h-4 mr-2"></iconify-icon>
                                        Buat Pembayaran
                                    </a>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        @if ($pembayaran->hasPages())
            <div class="bg-white dark:bg-gray-800 px-4 py-3 border-t border-gray-200 dark:border-gray-700 sm:px-6">
                {{ $pembayaran->appends(request()->query())->links() }}
            </div>
        @endif
    </div>
@endsection
