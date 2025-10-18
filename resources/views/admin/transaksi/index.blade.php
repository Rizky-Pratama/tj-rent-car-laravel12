@extends('layouts.admin')

@section('title', 'Kelola Transaksi')
@section('page-title', 'Kelola Transaksi')
@section('page-subtitle', 'Kelola semua transaksi rental mobil')

@section('content')

    <!-- Stats Cards -->
    <div class="grid grid-cols-2 md:grid-cols-4 lg:grid-cols-7 gap-4 mb-8">
        <!-- Total -->
        <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-sm border border-gray-100 dark:border-gray-700 p-4">
            <div class="flex items-center">
                <div class="flex-shrink-0">
                    <div class="w-10 h-10 bg-gray-100 dark:bg-gray-700 rounded-lg flex items-center justify-center">
                        <iconify-icon icon="heroicons:document-text-20-solid"
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
        <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-sm border border-gray-100 dark:border-gray-700 p-4">
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

        <!-- Dibayar -->
        <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-sm border border-gray-100 dark:border-gray-700 p-4">
            <div class="flex items-center">
                <div class="flex-shrink-0">
                    <div class="w-10 h-10 bg-blue-100 dark:bg-blue-900 rounded-lg flex items-center justify-center">
                        <iconify-icon icon="heroicons:credit-card-20-solid"
                            class="w-5 h-5 text-blue-600 dark:text-blue-400"></iconify-icon>
                    </div>
                </div>
                <div class="ml-3">
                    <p class="text-xs font-medium text-gray-600 dark:text-gray-400">Dibayar</p>
                    <p class="text-lg font-semibold text-gray-900 dark:text-white">{{ $statistik['dibayar'] }}</p>
                </div>
            </div>
        </div>

        <!-- Berjalan -->
        <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-sm border border-gray-100 dark:border-gray-700 p-4">
            <div class="flex items-center">
                <div class="flex-shrink-0">
                    <div class="w-10 h-10 bg-green-100 dark:bg-green-900 rounded-lg flex items-center justify-center">
                        <iconify-icon icon="heroicons:truck-20-solid"
                            class="w-5 h-5 text-green-600 dark:text-green-400"></iconify-icon>
                    </div>
                </div>
                <div class="ml-3">
                    <p class="text-xs font-medium text-gray-600 dark:text-gray-400">Berjalan</p>
                    <p class="text-lg font-semibold text-gray-900 dark:text-white">{{ $statistik['berjalan'] }}</p>
                </div>
            </div>
        </div>

        <!-- Telat -->
        <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-sm border border-gray-100 dark:border-gray-700 p-4">
            <div class="flex items-center">
                <div class="flex-shrink-0">
                    <div class="w-10 h-10 bg-red-100 dark:bg-red-900 rounded-lg flex items-center justify-center">
                        <iconify-icon icon="heroicons:exclamation-triangle-20-solid"
                            class="w-5 h-5 text-red-600 dark:text-red-400"></iconify-icon>
                    </div>
                </div>
                <div class="ml-3">
                    <p class="text-xs font-medium text-gray-600 dark:text-gray-400">Telat</p>
                    <p class="text-lg font-semibold text-gray-900 dark:text-white">{{ $statistik['telat'] }}</p>
                </div>
            </div>
        </div>

        <!-- Selesai -->
        <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-sm border border-gray-100 dark:border-gray-700 p-4">
            <div class="flex items-center">
                <div class="flex-shrink-0">
                    <div class="w-10 h-10 bg-green-100 dark:bg-green-900 rounded-lg flex items-center justify-center">
                        <iconify-icon icon="heroicons:check-circle-20-solid"
                            class="w-5 h-5 text-green-600 dark:text-green-400"></iconify-icon>
                    </div>
                </div>
                <div class="ml-3">
                    <p class="text-xs font-medium text-gray-600 dark:text-gray-400">Selesai</p>
                    <p class="text-lg font-semibold text-gray-900 dark:text-white">{{ $statistik['selesai'] }}</p>
                </div>
            </div>
        </div>

        <!-- Dibatalkan -->
        <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-sm border border-gray-100 dark:border-gray-700 p-4">
            <div class="flex items-center">
                <div class="flex-shrink-0">
                    <div class="w-10 h-10 bg-red-100 dark:bg-red-900 rounded-lg flex items-center justify-center">
                        <iconify-icon icon="heroicons:x-circle-20-solid"
                            class="w-5 h-5 text-red-600 dark:text-red-400"></iconify-icon>
                    </div>
                </div>
                <div class="ml-3">
                    <p class="text-xs font-medium text-gray-600 dark:text-gray-400">Dibatalkan</p>
                    <p class="text-lg font-semibold text-gray-900 dark:text-white">{{ $statistik['dibatalkan'] }}</p>
                </div>
            </div>
        </div>
    </div>
    <!-- Search and Filter Bar -->
    <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-sm border border-gray-100 dark:border-gray-700 p-6 mb-6"
        x-data="{
            activePeriod: '{{ $filters['period'] ?? (request()->hasAny(['search', 'status', 'payment_status', 'mobil_id', 'sopir_id', 'date_from', 'date_to']) ? '' : 'today') }}',
            showCustomRange: {{ ($filters['period'] ?? '') === 'custom' ? 'true' : 'false' }},
            toggleCustomDate() {
                this.showCustomRange = !this.showCustomRange;
                this.activePeriod = this.showCustomRange ? 'custom' : '';
            }
        }">
        <form method="GET" action="{{ route('admin.transaksi.index') }}" class="space-y-4">
            <!-- Search -->
            <div class="flex-1">
                <div class="relative">
                    <input type="text" name="search" value="{{ $filters['search'] ?? '' }}"
                        placeholder="Cari berdasarkan nomor transaksi, pelanggan, atau mobil..."
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
                class="grid grid-cols-1 md:grid-cols-4 gap-4 p-4 bg-gray-50 dark:bg-gray-700 rounded-xl">
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
                <div>
                    <label class="block text-xs font-medium text-gray-700 dark:text-gray-300 mb-1">Total Minimum</label>
                    <input type="number" name="min_total" value="{{ $filters['min_total'] ?? '' }}" placeholder="0"
                        class="w-full px-3 py-2 text-sm bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-indigo-500">
                </div>
                <div>
                    <label class="block text-xs font-medium text-gray-700 dark:text-gray-300 mb-1">Total Maksimum</label>
                    <input type="number" name="max_total" value="{{ $filters['max_total'] ?? '' }}" placeholder="∞"
                        class="w-full px-3 py-2 text-sm bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-indigo-500">
                </div>
            </div>

            <!-- Advanced Filters Row -->
            <div class="grid grid-cols-2 md:grid-cols-5 gap-4">
                <!-- Status Filter -->
                <div>
                    <label class="block text-xs font-medium text-gray-700 dark:text-gray-300 mb-1">Status Transaksi</label>
                    <select name="status"
                        class="w-full px-3 py-2 text-sm bg-gray-50 dark:bg-gray-700 border border-gray-200 dark:border-gray-600 rounded-xl focus:ring-2 focus:ring-indigo-500">
                        <option value="all">Semua Status</option>
                        <option value="pending" {{ ($filters['status'] ?? '') == 'pending' ? 'selected' : '' }}>Pending
                        </option>
                        <option value="dibayar" {{ ($filters['status'] ?? '') == 'dibayar' ? 'selected' : '' }}>Dibayar
                        </option>
                        <option value="berjalan" {{ ($filters['status'] ?? '') == 'berjalan' ? 'selected' : '' }}>Berjalan
                        </option>
                        <option value="telat" {{ ($filters['status'] ?? '') == 'telat' ? 'selected' : '' }}>Telat
                        </option>
                        <option value="selesai" {{ ($filters['status'] ?? '') == 'selesai' ? 'selected' : '' }}>Selesai
                        </option>
                        <option value="dibatalkan" {{ ($filters['status'] ?? '') == 'dibatalkan' ? 'selected' : '' }}>
                            Dibatalkan</option>
                    </select>
                </div>

                <!-- Payment Status Filter -->
                <div>
                    <label class="block text-xs font-medium text-gray-700 dark:text-gray-300 mb-1">Status Bayar</label>
                    <select name="payment_status"
                        class="w-full px-3 py-2 text-sm bg-gray-50 dark:bg-gray-700 border border-gray-200 dark:border-gray-600 rounded-xl focus:ring-2 focus:ring-indigo-500">
                        <option value="all">Semua</option>
                        <option value="lunas" {{ ($filters['payment_status'] ?? '') == 'lunas' ? 'selected' : '' }}>Lunas
                        </option>
                        <option value="belum_lunas"
                            {{ ($filters['payment_status'] ?? '') == 'belum_lunas' ? 'selected' : '' }}>Belum Lunas
                        </option>
                    </select>
                </div>

                <!-- Car Filter -->
                <div>
                    <label class="block text-xs font-medium text-gray-700 dark:text-gray-300 mb-1">Mobil</label>
                    <select name="mobil_id"
                        class="w-full px-3 py-2 text-sm bg-gray-50 dark:bg-gray-700 border border-gray-200 dark:border-gray-600 rounded-xl focus:ring-2 focus:ring-indigo-500">
                        <option value="all">Semua Mobil</option>
                        @foreach ($mobils as $mobil)
                            <option value="{{ $mobil->id }}"
                                {{ ($filters['mobil_id'] ?? '') == $mobil->id ? 'selected' : '' }}>
                                {{ $mobil->merk }} {{ $mobil->model }} ({{ $mobil->plat_nomor }})
                            </option>
                        @endforeach
                    </select>
                </div>

                <!-- Driver Filter -->
                <div>
                    <label class="block text-xs font-medium text-gray-700 dark:text-gray-300 mb-1">Sopir</label>
                    <select name="sopir_id"
                        class="w-full px-3 py-2 text-sm bg-gray-50 dark:bg-gray-700 border border-gray-200 dark:border-gray-600 rounded-xl focus:ring-2 focus:ring-indigo-500">
                        <option value="all">Semua Sopir</option>
                        @foreach ($sopirs as $sopir)
                            <option value="{{ $sopir->id }}"
                                {{ ($filters['sopir_id'] ?? '') == $sopir->id ? 'selected' : '' }}>
                                {{ $sopir->nama }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <!-- Action Buttons -->
                <div class="flex gap-2 items-end">
                    <button type="submit"
                        class="flex gap-2 items-center px-4 py-2 bg-indigo-600 hover:bg-indigo-700 text-white text-sm font-medium rounded-xl transition-colors duration-200">
                        <iconify-icon icon="heroicons:funnel-20-solid" class="w-4 h-4"></iconify-icon>
                        Filter
                    </button>
                    @if (request()->hasAny(['search', 'status', 'period', 'payment_status', 'mobil_id', 'sopir_id', 'date_from', 'date_to']))
                        <a href="{{ route('admin.transaksi.index') }}"
                            class="px-3 py-2 bg-gray-500 hover:bg-gray-600 text-white text-sm font-medium rounded-xl transition-colors duration-200"
                            title="Reset Filter">
                            <iconify-icon icon="heroicons:x-mark-20-solid" width="20" height="20"></iconify-icon>
                        </a>
                    @endif
                </div>
            </div>
        </form>
    </div>

    <!-- Transaksi Table -->
    <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-sm border border-gray-100 dark:border-gray-700">
        <!-- Header -->
        <div class="px-6 py-4 border-b border-gray-200 dark:border-gray-700">
            <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
                <div>
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-white">Daftar Transaksi</h3>
                    <p class="text-sm text-gray-600 dark:text-gray-400">
                        @if (!empty($filters['period']))
                            @if ($filters['period'] == 'today')
                                Transaksi hari ini
                            @elseif ($filters['period'] == 'yesterday')
                                Transaksi kemarin
                            @elseif ($filters['period'] == 'this_week')
                                Transaksi minggu ini
                            @elseif ($filters['period'] == 'this_month')
                                Transaksi bulan ini
                            @elseif ($filters['period'] == 'last_month')
                                Transaksi bulan lalu
                            @elseif ($filters['period'] == 'this_year')
                                Transaksi tahun ini
                            @elseif ($filters['period'] == 'custom' && !empty($filters['date_from']) && !empty($filters['date_to']))
                                @if ($filters['date_from'] == $filters['date_to'])
                                    Transaksi tanggal {{ \Carbon\Carbon::parse($filters['date_from'])->format('d M Y') }}
                                @else
                                    Transaksi periode {{ \Carbon\Carbon::parse($filters['date_from'])->format('d M Y') }} -
                                    {{ \Carbon\Carbon::parse($filters['date_to'])->format('d M Y') }}
                                @endif
                            @else
                                Transaksi periode custom
                            @endif
                        @else
                            Semua transaksi rental mobil
                        @endif
                    </p>
                </div>
                <div class="flex flex-col sm:flex-row gap-2">
                    <!-- Export Button with Alpine.js -->
                    <div x-data="{
                        isExporting: false,
                        showExportOptions: false,
                        async exportPDF() {
                            this.isExporting = true;
                            try {
                                const currentUrl = new URL(window.location.href);
                                const params = new URLSearchParams(currentUrl.search);
                                params.set('export', 'pdf');
                    
                                // Create a form for POST request or use window.open for GET request
                                const exportUrl = `${currentUrl.pathname}?${params.toString()}`;
                    
                                // Use window.open to trigger PDF download
                                const downloadWindow = window.open(exportUrl, '_blank');
                    
                                // Close the popup window after a short delay
                                setTimeout(() => {
                                    if (downloadWindow) {
                                        downloadWindow.close();
                                    }
                                }, 3000);
                    
                            } catch (error) {
                                alert('Gagal mengekspor data. Silakan coba lagi.');
                                console.error('Export error:', error);
                            } finally {
                                this.isExporting = false;
                                this.showExportOptions = false;
                            }
                        }
                    }" class="relative">
                        <!-- Export Dropdown Button -->
                        <button @click="showExportOptions = !showExportOptions" :disabled="isExporting"
                            class="inline-flex items-center px-4 py-2 bg-emerald-600 hover:bg-emerald-700 disabled:bg-emerald-400 text-white text-sm font-medium rounded-xl transition-colors duration-200">
                            <iconify-icon x-show="!isExporting" icon="heroicons:arrow-down-tray-20-solid"
                                class="w-4 h-4 mr-2"></iconify-icon>
                            <div x-show="isExporting"
                                class="w-4 h-4 mr-2 border-2 border-white border-t-transparent rounded-full animate-spin">
                            </div>
                            <span x-text="isExporting ? 'Mengekspor...' : 'Export'"></span>
                            <iconify-icon icon="heroicons:chevron-down-20-solid" class="w-4 h-4 ml-1"></iconify-icon>
                        </button>

                        <!-- Export Options Dropdown -->
                        <div x-show="showExportOptions" @click.away="showExportOptions = false"
                            x-transition:enter="transition ease-out duration-200"
                            x-transition:enter-start="opacity-0 scale-95" x-transition:enter-end="opacity-100 scale-100"
                            x-transition:leave="transition ease-in duration-75"
                            x-transition:leave-start="opacity-100 scale-100" x-transition:leave-end="opacity-0 scale-95"
                            class="absolute right-0 mt-2 w-48 bg-white dark:bg-gray-800 rounded-xl shadow-lg border border-gray-200 dark:border-gray-700 z-10">
                            <div class="py-2">
                                <button @click="exportPDF()" :disabled="isExporting"
                                    class="flex items-center w-full px-4 py-2 text-sm text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700 disabled:opacity-50">
                                    <iconify-icon icon="heroicons:document-arrow-down-20-solid"
                                        class="w-4 h-4 mr-3 text-red-500"></iconify-icon>
                                    Export ke PDF
                                </button>
                                <button @click="alert('Fitur Excel akan segera tersedia')"
                                    class="flex items-center w-full px-4 py-2 text-sm text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700">
                                    <iconify-icon icon="heroicons:table-cells-20-solid"
                                        class="w-4 h-4 mr-3 text-green-500"></iconify-icon>
                                    Export ke Excel
                                </button>
                            </div>
                        </div>
                    </div>

                    <a href="{{ route('admin.transaksi.create') }}"
                        class="inline-flex items-center px-4 py-2 bg-indigo-600 hover:bg-indigo-700 text-white text-sm font-medium rounded-xl transition-colors duration-200">
                        <iconify-icon icon="heroicons:plus-20-solid" class="w-4 h-4 mr-2"></iconify-icon>
                        Transaksi Baru
                    </a>
                </div>
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
                            Pelanggan & Mobil
                        </th>
                        <th
                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                            Periode Sewa
                        </th>
                        <th
                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                            Total & Status
                        </th>
                        <th
                            class="px-6 py-3 text-right text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                            Aksi
                        </th>
                    </tr>
                </thead>
                <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                    @forelse ($transaksi as $item)
                        <tr class="hover:bg-gray-50 dark:hover:bg-gray-700">
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="flex items-center">
                                    <div class="flex-shrink-0 h-10 w-10">
                                        <div
                                            class="h-10 w-10 bg-gradient-to-r from-indigo-500 to-purple-600 rounded-full flex items-center justify-center">
                                            <iconify-icon icon="heroicons:document-text-20-solid"
                                                class="w-5 h-5 text-white"></iconify-icon>
                                        </div>
                                    </div>
                                    <div class="ml-4">
                                        <div class="text-sm font-medium text-gray-900 dark:text-white">
                                            {{ $item->no_transaksi }}
                                        </div>
                                        <div class="text-sm text-gray-500 dark:text-gray-400">
                                            {{ $item->created_at->format('d M Y, H:i') }}
                                        </div>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm text-gray-900 dark:text-white">
                                    <div class="font-medium">{{ $item->pelanggan->nama }}</div>
                                    <div class="text-gray-500 dark:text-gray-400">{{ $item->pelanggan->telepon }}</div>
                                </div>
                                <div class="text-sm text-gray-500 dark:text-gray-400 mt-1">
                                    <div class="flex items-center">
                                        <iconify-icon icon="heroicons:truck-20-solid" class="w-4 h-4 mr-1"></iconify-icon>
                                        {{ $item->mobil->merk }} {{ $item->mobil->model }}
                                        ({{ $item->mobil->plat_nomor }})
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm text-gray-900 dark:text-white">
                                    <div>{{ $item->tanggal_sewa->format('d M Y') }}</div>
                                    <div class="text-gray-500 dark:text-gray-400">s/d
                                        {{ $item->tanggal_kembali->format('d M Y') }}</div>
                                    <div class="text-xs text-gray-400">({{ $item->durasi_hari }} hari)</div>
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm font-medium text-gray-900 dark:text-white">
                                    Rp {{ number_format($item->total, 0, ',', '.') }}
                                </div>
                                @if ($item->sisa_pembayaran > 0)
                                    <div class="text-xs text-red-500">
                                        Kurang: Rp {{ number_format($item->sisa_pembayaran, 0, ',', '.') }}
                                    </div>
                                @else
                                    <div class="text-xs text-green-500">Lunas</div>
                                @endif

                                <div class="mt-1">
                                    @if ($item->status === 'pending')
                                        <span
                                            class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800 dark:bg-yellow-900 dark:text-yellow-200">
                                            <iconify-icon icon="heroicons:clock-20-solid"
                                                class="w-3 h-3 mr-1"></iconify-icon>
                                            Pending
                                        </span>
                                    @elseif ($item->status === 'dibayar')
                                        <span
                                            class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800 dark:bg-blue-900 dark:text-blue-200">
                                            <iconify-icon icon="heroicons:credit-card-20-solid"
                                                class="w-3 h-3 mr-1"></iconify-icon>
                                            Dibayar
                                        </span>
                                    @elseif ($item->status === 'berjalan')
                                        <span
                                            class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200">
                                            <iconify-icon icon="heroicons:truck-20-solid"
                                                class="w-3 h-3 mr-1"></iconify-icon>
                                            Berjalan
                                        </span>
                                    @elseif ($item->status === 'telat')
                                        <span
                                            class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-200">
                                            <iconify-icon icon="heroicons:exclamation-triangle-20-solid"
                                                class="w-3 h-3 mr-1"></iconify-icon>
                                            Telat
                                        </span>
                                    @elseif ($item->status === 'selesai')
                                        <span
                                            class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-gray-100 text-gray-800 dark:bg-gray-700 dark:text-gray-200">
                                            <iconify-icon icon="heroicons:check-circle-20-solid"
                                                class="w-3 h-3 mr-1"></iconify-icon>
                                            Selesai
                                        </span>
                                    @else
                                        <span
                                            class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-200">
                                            <iconify-icon icon="heroicons:x-circle-20-solid"
                                                class="w-3 h-3 mr-1"></iconify-icon>
                                            Dibatalkan
                                        </span>
                                    @endif
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                <div class="flex items-center justify-end space-x-2">
                                    <a href="{{ route('admin.transaksi.show', $item->id) }}"
                                        class="text-gray-400 hover:text-gray-600 dark:hover:text-gray-300"
                                        title="Lihat Detail">
                                        <iconify-icon icon="heroicons:eye-20-solid" class="w-4 h-4"></iconify-icon>
                                    </a>

                                    @if ($item->status == 'pending')
                                        <a href="{{ route('admin.transaksi.edit', $item->id) }}"
                                            class="text-indigo-600 hover:text-indigo-900 dark:text-indigo-400 dark:hover:text-indigo-300"
                                            title="Edit">
                                            <iconify-icon icon="heroicons:pencil-20-solid" class="w-4 h-4"></iconify-icon>
                                        </a>
                                    @endif

                                    @if (in_array($item->status, ['pending', 'dibayar', 'berjalan', 'telat']))
                                        <a href="{{ route('admin.transaksi.payment', $item->id) }}"
                                            class="text-purple-600 hover:text-purple-900 dark:text-purple-400 dark:hover:text-purple-300"
                                            title="Kelola Pembayaran">
                                            <iconify-icon icon="heroicons:credit-card-20-solid"
                                                class="w-4 h-4"></iconify-icon>
                                        </a>
                                    @endif

                                    @if (!in_array($item->status, ['selesai', 'batal']))
                                        <!-- Quick Actions Dropdown -->
                                        <div class="relative inline-block text-left">
                                            <button type="button"
                                                class="text-gray-400 hover:text-gray-600 dark:hover:text-gray-300 focus:outline-none"
                                                onclick="toggleDropdown('dropdown-{{ $item->id }}')"
                                                title="Aksi Lainnya">
                                                <iconify-icon icon="heroicons:ellipsis-vertical-20-solid"
                                                    class="w-4 h-4"></iconify-icon>
                                            </button>

                                            <div id="dropdown-{{ $item->id }}"
                                                class="hidden absolute right-0 z-10 mt-2 w-48 origin-top-right rounded-md bg-white dark:bg-gray-700 shadow-lg focus:outline-none">
                                                <div class="py-1">
                                                    @if ($item->status == 'pending')
                                                        <form
                                                            action="{{ route('admin.transaksi.update-status', $item->id) }}"
                                                            method="POST" class="block">
                                                            @csrf
                                                            @method('PATCH')
                                                            <input type="hidden" name="status" value="dibayar">
                                                            <button type="submit"
                                                                class="block w-full text-left px-4 py-2 text-sm text-green-700 dark:text-green-300 hover:bg-gray-100 dark:hover:bg-gray-600"
                                                                onclick="return confirm('Konfirmasi bahwa pembayaran telah diterima?')">
                                                                <iconify-icon icon="heroicons:credit-card-20-solid"
                                                                    class="w-4 h-4 mr-2 inline"></iconify-icon>
                                                                Konfirmasi Bayar
                                                            </button>
                                                        </form>

                                                        <form
                                                            action="{{ route('admin.transaksi.update-status', $item->id) }}"
                                                            method="POST" class="block">
                                                            @csrf
                                                            @method('PATCH')
                                                            <input type="hidden" name="status" value="dibatalkan">
                                                            <button type="submit"
                                                                class="block w-full text-left px-4 py-2 text-sm text-red-700 dark:text-red-300 hover:bg-gray-100 dark:hover:bg-gray-600"
                                                                onclick="return confirm('Yakin ingin membatalkan transaksi ini?')">
                                                                <iconify-icon icon="heroicons:x-circle-20-solid"
                                                                    class="w-4 h-4 mr-2 inline"></iconify-icon>
                                                                Batalkan
                                                            </button>
                                                        </form>
                                                    @elseif($item->status == 'dibayar')
                                                        <form
                                                            action="{{ route('admin.transaksi.update-status', $item->id) }}"
                                                            method="POST" class="block">
                                                            @csrf
                                                            @method('PATCH')
                                                            <input type="hidden" name="status" value="berjalan">
                                                            <button type="submit"
                                                                class="block w-full text-left px-4 py-2 text-sm text-green-700 dark:text-green-300 hover:bg-gray-100 dark:hover:bg-gray-600"
                                                                onclick="return confirm('Mulai periode sewa?')">
                                                                <iconify-icon icon="heroicons:truck-20-solid"
                                                                    class="w-4 h-4 mr-2 inline"></iconify-icon>
                                                                Mulai Sewa
                                                            </button>
                                                        </form>
                                                    @elseif($item->status == 'berjalan' || $item->status == 'telat')
                                                        <form
                                                            action="{{ route('admin.transaksi.update-status', $item->id) }}"
                                                            method="POST" class="block">
                                                            @csrf
                                                            @method('PATCH')
                                                            <input type="hidden" name="status" value="selesai">
                                                            <button type="submit"
                                                                class="block w-full text-left px-4 py-2 text-sm text-blue-700 dark:text-blue-300 hover:bg-gray-100 dark:hover:bg-gray-600"
                                                                onclick="return confirm('Konfirmasi mobil telah dikembalikan?')">
                                                                <iconify-icon icon="heroicons:check-circle-20-solid"
                                                                    class="w-4 h-4 mr-2 inline"></iconify-icon>
                                                                Selesaikan Sewa
                                                            </button>
                                                        </form>
                                                    @endif
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
                                    <iconify-icon icon="heroicons:document-text-20-solid"
                                        class="w-12 h-12 text-gray-400 mb-4"></iconify-icon>
                                    <h3 class="text-sm font-medium text-gray-900 dark:text-white mb-1">Belum ada transaksi
                                    </h3>
                                    <p class="text-sm text-gray-500 dark:text-gray-400 mb-4">
                                        @if (
                                            !empty($filters['period']) ||
                                                !empty($filters['date_from']) ||
                                                !empty($filters['status']) ||
                                                !empty($filters['search']))
                                            Tidak ada transaksi yang sesuai dengan filter yang dipilih
                                        @else
                                            Mulai dengan membuat transaksi baru
                                        @endif
                                    </p>
                                    <a href="{{ route('admin.transaksi.create') }}"
                                        class="inline-flex items-center px-4 py-2 bg-indigo-600 hover:bg-indigo-700 text-white text-sm font-medium rounded-xl transition-colors duration-200">
                                        <iconify-icon icon="heroicons:plus-20-solid" class="w-4 h-4 mr-2"></iconify-icon>
                                        Buat Transaksi
                                    </a>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        @if ($transaksi->hasPages())
            <div class="bg-white dark:bg-gray-800 px-4 py-3 border-t border-gray-200 dark:border-gray-700 sm:px-6">
                {{ $transaksi->appends(request()->query())->links() }}
            </div>
        @endif
    </div>

    <!-- JavaScript untuk dropdown functionality -->
    <script>
        function toggleDropdown(dropdownId) {
            const dropdown = document.getElementById(dropdownId);
            const allDropdowns = document.querySelectorAll('[id^="dropdown-"]');

            // Close all other dropdowns
            allDropdowns.forEach(d => {
                if (d.id !== dropdownId) {
                    d.classList.add('hidden');
                }
            });

            // Toggle current dropdown
            dropdown.classList.toggle('hidden');
        }

        // Close dropdowns when clicking outside
        document.addEventListener('click', function(event) {
            if (!event.target.closest('[onclick^="toggleDropdown"]')) {
                document.querySelectorAll('[id^="dropdown-"]').forEach(dropdown => {
                    dropdown.classList.add('hidden');
                });
            }
        });
    </script>
@endsection
