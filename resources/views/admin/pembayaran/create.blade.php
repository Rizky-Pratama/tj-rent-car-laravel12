@extends('layouts.admin')

@section('title', 'Tambah Pembayaran')
@section('page-title', 'Tambah Pembayaran')
@section('page-subtitle', 'Tambahkan pembayaran baru untuk transaksi')

@section('content')
    <div class="max-w-4xl mx-auto" x-data="paymentSearch()">
        <form action="{{ route('admin.pembayaran.store') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
            @csrf

            <!-- Pilih Transaksi (Jika tidak ada transaksi_id) -->
            @if (!$transaksi)
                <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-sm border border-gray-100 dark:border-gray-700 p-6">
                    <div class="flex items-center mb-6">
                        <div class="flex-shrink-0">
                            <div
                                class="w-10 h-10 bg-gradient-to-r from-blue-500 to-purple-600 rounded-lg flex items-center justify-center">
                                <iconify-icon icon="heroicons:document-text-20-solid"
                                    class="w-5 h-5 text-white"></iconify-icon>
                            </div>
                        </div>
                        <div class="ml-4">
                            <h3 class="text-lg font-semibold text-gray-900 dark:text-white">Pilih Transaksi</h3>
                            <p class="text-sm text-gray-600 dark:text-gray-400">Cari transaksi yang memiliki sisa tagihan
                            </p>
                        </div>
                    </div>

                    <div class="space-y-4">
                        <!-- Search Input -->
                        <div>
                            <label for="transaksi_search"
                                class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                Cari Transaksi *
                            </label>
                            <div class="relative">
                                <input type="text" x-model="searchQuery" @input.debounce.300ms="searchTransactions()"
                                    placeholder="Ketik nomor transaksi atau nama pelanggan..."
                                    class="w-full pl-12 pr-12 py-3 border border-gray-200 dark:border-gray-600 rounded-xl focus:ring-2 focus:ring-indigo-500 dark:focus:ring-indigo-400 bg-white dark:bg-gray-700 text-gray-900 dark:text-white transition-all">

                                <!-- Icon Search -->
                                <div class="absolute left-4 top-3.5 pointer-events-none">
                                    <iconify-icon icon="heroicons:magnifying-glass-20-solid"
                                        class="w-5 h-5 text-gray-400"></iconify-icon>
                                </div>

                                <!-- Loading Spinner -->
                                <div x-show="isSearching" class="absolute right-4 top-3.5">
                                    <iconify-icon icon="line-md:loading-loop"
                                        class="w-5 h-5 text-indigo-600"></iconify-icon>
                                </div>
                            </div>
                            <p class="mt-1 text-xs text-gray-500 dark:text-gray-400">
                                Minimal 2 karakter untuk memulai pencarian
                            </p>
                        </div>

                        <!-- Search Results -->
                        <div x-show="searchResults.length > 0" x-transition
                            class="border border-gray-200 dark:border-gray-600 rounded-xl overflow-hidden">
                            <!-- Header -->
                            <div
                                class="bg-gray-50 dark:bg-gray-700 px-3 py-2 border-b border-gray-200 dark:border-gray-600">
                                <p class="text-xs font-semibold text-gray-700 dark:text-gray-300 uppercase tracking-wide">
                                    <span x-text="searchResults.length"></span> Transaksi Ditemukan
                                </p>
                            </div>

                            <!-- List -->
                            <div class="max-h-80 overflow-y-auto divide-y divide-gray-200 dark:divide-gray-700">
                                <template x-for="transaksi in searchResults" :key="transaksi.id">
                                    <button type="button" @click="selectTransaction(transaksi)"
                                        class="w-full px-3 py-2.5 hover:bg-indigo-50 dark:hover:bg-indigo-900/20 transition-colors text-left group"
                                        :class="(selectedTransaction && selectedTransaction.id === transaksi.id) ?
                                        'bg-indigo-50 dark:bg-indigo-900/20' : 'bg-white dark:bg-gray-800'">

                                        <div class="flex items-start gap-3">
                                            <!-- Icon Circle -->
                                            <div class="flex-shrink-0 mt-0.5">
                                                <div
                                                    class="w-8 h-8 rounded-full bg-gradient-to-br from-indigo-500 to-purple-600 flex items-center justify-center">
                                                    <iconify-icon icon="heroicons:document-text-solid"
                                                        class="text-white text-sm"></iconify-icon>
                                                </div>
                                            </div>

                                            <!-- Content -->
                                            <div class="flex-1 min-w-0">
                                                <!-- Row 1: No Transaksi + Status -->
                                                <div class="flex items-center gap-2 mb-1">
                                                    <span
                                                        class="font-semibold text-sm text-gray-900 dark:text-white truncate"
                                                        x-text="transaksi.no_transaksi"></span>
                                                    <span
                                                        class="inline-flex items-center px-1.5 py-0.5 text-xs font-medium rounded"
                                                        :class="{
                                                            'bg-green-100 text-green-700 dark:bg-green-900/30 dark:text-green-300': transaksi
                                                                .status === 'aktif' || transaksi
                                                                .status === 'selesai',
                                                            'bg-blue-100 text-blue-700 dark:bg-blue-900/30 dark:text-blue-300': transaksi
                                                                .status === 'booking',
                                                            'bg-yellow-100 text-yellow-700 dark:bg-yellow-900/30 dark:text-yellow-300': transaksi
                                                                .status === 'pending',
                                                            'bg-red-100 text-red-700 dark:bg-red-900/30 dark:text-red-300': transaksi
                                                                .status === 'batal' || transaksi
                                                                .status === 'telat'
                                                        }"
                                                        x-text="transaksi.status.toUpperCase()">
                                                    </span>
                                                </div>

                                                <!-- Row 2: Pelanggan + Mobil -->
                                                <div
                                                    class="flex items-center gap-2 text-xs text-gray-600 dark:text-gray-400 mb-1.5">
                                                    <iconify-icon icon="heroicons:user-solid"
                                                        class="text-xs"></iconify-icon>
                                                    <span class="truncate" x-text="transaksi.pelanggan.nama"></span>
                                                    <span class="text-gray-400">•</span>
                                                    <iconify-icon icon="heroicons:truck-solid"
                                                        class="text-xs"></iconify-icon>
                                                    <span class="truncate"
                                                        x-text="transaksi.mobil.merk + ' ' + transaksi.mobil.model"></span>
                                                </div>

                                                <!-- Row 3: Payment Info -->
                                                <div class="flex items-center gap-3 text-xs">
                                                    <div class="flex items-center gap-1">
                                                        <span class="text-gray-500 dark:text-gray-400">Total:</span>
                                                        <span class="font-semibold text-gray-900 dark:text-white"
                                                            x-text="formatCurrency(transaksi.total)"></span>
                                                    </div>
                                                    <div class="flex items-center gap-1">
                                                        <span class="text-gray-500 dark:text-gray-400">Sisa:</span>
                                                        <span class="font-bold text-red-600 dark:text-red-400"
                                                            x-text="formatCurrency(transaksi.sisa_pembayaran)"></span>
                                                    </div>
                                                </div>
                                            </div>

                                            <!-- Arrow Icon -->
                                            <div class="flex-shrink-0">
                                                <iconify-icon icon="heroicons:chevron-right-20-solid"
                                                    class="text-lg text-gray-400 group-hover:text-indigo-600 transition-colors"></iconify-icon>
                                            </div>
                                        </div>
                                    </button>
                                </template>
                            </div>
                        </div>

                        <!-- Empty State -->
                        <div x-show="searchQuery.length >= 2 && !isSearching && searchResults.length === 0" x-transition
                            class="text-center py-12 border border-gray-200 dark:border-gray-600 rounded-xl">
                            <iconify-icon icon="heroicons:magnifying-glass-20-solid"
                                class="w-16 h-16 text-gray-300 dark:text-gray-600 mx-auto mb-3"></iconify-icon>
                            <p class="text-gray-600 dark:text-gray-400 font-medium">Tidak ada transaksi ditemukan</p>
                            <p class="text-sm text-gray-500 dark:text-gray-500 mt-1">Coba kata kunci lain atau periksa
                                status transaksi</p>
                        </div>

                        <input type="hidden" name="transaksi_id"
                            x-bind:value="selectedTransaction ? selectedTransaction.id : ''" required>
                    </div>
                </div>

                <!-- Selected Transaction Info -->
                <div x-show="selectedTransaction" x-transition
                    class="bg-white dark:bg-gray-800 rounded-2xl shadow-sm border border-gray-100 dark:border-gray-700 p-6">
                    <div class="flex items-center justify-between mb-6">
                        <div class="flex items-center">
                            <div class="flex-shrink-0">
                                <div
                                    class="w-10 h-10 bg-gradient-to-r from-green-500 to-emerald-600 rounded-lg flex items-center justify-center">
                                    <iconify-icon icon="heroicons:check-circle-20-solid"
                                        class="w-5 h-5 text-white"></iconify-icon>
                                </div>
                            </div>
                            <div class="ml-4">
                                <h3 class="text-lg font-semibold text-gray-900 dark:text-white">Transaksi Dipilih</h3>
                                <p class="text-sm text-gray-600 dark:text-gray-400">Detail transaksi yang akan dibayar</p>
                            </div>
                        </div>
                        <button type="button" @click="clearSelection()"
                            class="text-sm text-red-600 hover:text-red-700 dark:text-red-400 dark:hover:text-red-300 font-medium">
                            Ganti Transaksi
                        </button>
                    </div>

                    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                        <!-- Transaction Details -->
                        <div
                            class="p-4 bg-gray-50 dark:bg-gray-700 rounded-xl border border-gray-200 dark:border-gray-600">
                            <h4 class="font-medium text-gray-900 dark:text-white mb-3">Detail Transaksi</h4>
                            <div class="space-y-2 text-sm">
                                <div class="flex justify-between">
                                    <span class="text-gray-600 dark:text-gray-400">No. Transaksi:</span>
                                    <span class="font-medium text-gray-900 dark:text-white"
                                        x-text="selectedTransaction ? selectedTransaction.no_transaksi : ''"></span>
                                </div>
                                <div class="flex justify-between">
                                    <span class="text-gray-600 dark:text-gray-400">Pelanggan:</span>
                                    <span class="font-medium text-gray-900 dark:text-white"
                                        x-text="selectedTransaction && selectedTransaction.pelanggan ? selectedTransaction.pelanggan.nama : ''"></span>
                                </div>
                                <div class="flex justify-between">
                                    <span class="text-gray-600 dark:text-gray-400">Mobil:</span>
                                    <span class="font-medium text-gray-900 dark:text-white"
                                        x-text="selectedTransaction && selectedTransaction.mobil ? (selectedTransaction.mobil.merk + ' ' + selectedTransaction.mobil.model) : ''"></span>
                                </div>
                            </div>
                        </div>

                        <!-- Payment Info -->
                        <div
                            class="p-4 bg-blue-50 dark:bg-blue-900/20 rounded-xl border border-blue-200 dark:border-blue-800">
                            <h4 class="font-medium text-gray-900 dark:text-white mb-3">Status Pembayaran</h4>
                            <div class="space-y-2 text-sm">
                                <div class="flex justify-between">
                                    <span class="text-gray-600 dark:text-gray-400">Total Tagihan:</span>
                                    <span class="font-bold text-gray-900 dark:text-white"
                                        x-text="selectedTransaction ? formatCurrency(selectedTransaction.total) : ''"></span>
                                </div>
                                <div class="flex justify-between">
                                    <span class="text-gray-600 dark:text-gray-400">Sudah Dibayar:</span>
                                    <span class="font-medium text-green-600 dark:text-green-400"
                                        x-text="selectedTransaction ? formatCurrency(selectedTransaction.total_pembayaran) : ''"></span>
                                </div>
                                <div class="flex justify-between border-t border-blue-200 dark:border-blue-700 pt-2">
                                    <span class="text-gray-600 dark:text-gray-400">Sisa Tagihan:</span>
                                    <span class="font-bold text-red-600 dark:text-red-400"
                                        x-text="selectedTransaction ? formatCurrency(selectedTransaction.sisa_pembayaran) : ''"></span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @else
                <!-- Info Transaksi -->
                <div
                    class="bg-white dark:bg-gray-800 rounded-2xl shadow-sm border border-gray-100 dark:border-gray-700 p-6">
                    <div class="flex items-center mb-6">
                        <div class="flex-shrink-0">
                            <div
                                class="w-10 h-10 bg-gradient-to-r from-blue-500 to-purple-600 rounded-lg flex items-center justify-center">
                                <iconify-icon icon="heroicons:document-text-20-solid"
                                    class="w-5 h-5 text-white"></iconify-icon>
                            </div>
                        </div>
                        <div class="ml-4">
                            <h3 class="text-lg font-semibold text-gray-900 dark:text-white">Info Transaksi</h3>
                            <p class="text-sm text-gray-600 dark:text-gray-400">Detail transaksi yang akan dibayar</p>
                        </div>
                    </div>

                    <input type="hidden" name="transaksi_id" value="{{ $transaksi->id }}">

                    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                        <!-- Info Transaksi -->
                        <div class="space-y-4">
                            <div
                                class="p-4 bg-gray-50 dark:bg-gray-700 rounded-xl border border-gray-200 dark:border-gray-600">
                                <h4 class="font-medium text-gray-900 dark:text-white mb-3">Detail Transaksi</h4>
                                <div class="space-y-2 text-sm">
                                    <div class="flex justify-between">
                                        <span class="text-gray-600 dark:text-gray-400">No. Transaksi:</span>
                                        <span
                                            class="font-medium text-gray-900 dark:text-white">{{ $transaksi->no_transaksi }}</span>
                                    </div>
                                    <div class="flex justify-between">
                                        <span class="text-gray-600 dark:text-gray-400">Pelanggan:</span>
                                        <span
                                            class="font-medium text-gray-900 dark:text-white">{{ $transaksi->pelanggan->nama }}</span>
                                    </div>
                                    <div class="flex justify-between">
                                        <span class="text-gray-600 dark:text-gray-400">Mobil:</span>
                                        <span
                                            class="font-medium text-gray-900 dark:text-white">{{ $transaksi->mobil->merk }}
                                            {{ $transaksi->mobil->model }}</span>
                                    </div>
                                    <div class="flex justify-between">
                                        <span class="text-gray-600 dark:text-gray-400">Periode:</span>
                                        <span class="font-medium text-gray-900 dark:text-white">
                                            {{ $transaksi->tanggal_sewa->format('d M Y') }} -
                                            {{ $transaksi->tanggal_kembali->format('d M Y') }}
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Info Pembayaran -->
                        <div class="space-y-4">
                            <div
                                class="p-4 bg-blue-50 dark:bg-blue-900/20 rounded-xl border border-blue-200 dark:border-blue-800">
                                <h4 class="font-medium text-gray-900 dark:text-white mb-3">Status Pembayaran</h4>
                                <div class="space-y-2 text-sm">
                                    <div class="flex justify-between">
                                        <span class="text-gray-600 dark:text-gray-400">Total Tagihan:</span>
                                        <span class="font-bold text-gray-900 dark:text-white">Rp
                                            {{ number_format($transaksi->total, 0, ',', '.') }}</span>
                                    </div>
                                    <div class="flex justify-between">
                                        <span class="text-gray-600 dark:text-gray-400">Sudah Dibayar:</span>
                                        <span class="font-medium text-green-600 dark:text-green-400">Rp
                                            {{ number_format($transaksi->total_pembayaran, 0, ',', '.') }}</span>
                                    </div>
                                    <div class="flex justify-between border-t border-blue-200 dark:border-blue-700 pt-2">
                                        <span class="text-gray-600 dark:text-gray-400">Sisa Tagihan:</span>
                                        <span class="font-bold text-red-600 dark:text-red-400">Rp
                                            {{ number_format($transaksi->sisa_pembayaran, 0, ',', '.') }}</span>
                                    </div>
                                </div>
                            </div>

                            @if ($transaksi->pembayaran->count() > 0)
                                <div
                                    class="p-4 bg-gray-50 dark:bg-gray-700 rounded-xl border border-gray-200 dark:border-gray-600">
                                    <h4 class="font-medium text-gray-900 dark:text-white mb-3">Riwayat Pembayaran</h4>
                                    <div class="space-y-2 text-sm max-h-32 overflow-y-auto">
                                        @foreach ($transaksi->pembayaran as $payment)
                                            <div class="flex justify-between">
                                                <span class="text-gray-600 dark:text-gray-400">
                                                    {{ $payment->created_at->format('d/m/Y') }} -
                                                    {{ ucfirst($payment->metode) }}
                                                </span>
                                                <span
                                                    class="font-medium
                                                    @if ($payment->status === 'terkonfirmasi') text-green-600 dark:text-green-400
                                                    @elseif($payment->status === 'pending') text-yellow-600 dark:text-yellow-400
                                                    @else text-red-600 dark:text-red-400 @endif">
                                                    Rp {{ number_format($payment->jumlah, 0, ',', '.') }}
                                                </span>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            @endif

            <!-- Form Pembayaran -->
            <div @if (!$transaksi) x-show="selectedTransaction" x-transition @endif
                class="bg-white dark:bg-gray-800 rounded-2xl shadow-sm border border-gray-100 dark:border-gray-700 p-6">
                <div class="flex items-center mb-6">
                    <div class="flex-shrink-0">
                        <div
                            class="w-10 h-10 bg-gradient-to-r from-green-500 to-blue-600 rounded-lg flex items-center justify-center">
                            <iconify-icon icon="heroicons:credit-card-20-solid" class="w-5 h-5 text-white"></iconify-icon>
                        </div>
                    </div>
                    <div class="ml-4">
                        <h3 class="text-lg font-semibold text-gray-900 dark:text-white">Detail Pembayaran</h3>
                        <p class="text-sm text-gray-600 dark:text-gray-400">Masukkan detail pembayaran yang akan dicatat
                        </p>
                    </div>
                </div>

                <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                    <!-- Jumlah Pembayaran -->
                    <div>
                        <label for="jumlah" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                            Jumlah Pembayaran *
                        </label>
                        <div class="relative">
                            <div
                                class="absolute left-4 top-1/2 -translate-y-1/2 text-gray-500 dark:text-gray-400 pointer-events-none">
                                Rp
                            </div>
                            <input type="text" name="jumlah" id="jumlah" value="{{ old('jumlah') }}"
                                @if ($transaksi) data-max="{{ $transaksi->sisa_pembayaran }}"
                                @else
                                    x-bind:data-max="selectedTransaction ? selectedTransaction.sisa_pembayaran : ''" @endif
                                placeholder="0" required
                                class="w-full pl-12 pr-4 py-2 border border-gray-200 dark:border-gray-600 rounded-xl focus:ring-2 focus:ring-indigo-500 dark:focus:ring-indigo-400 bg-white dark:bg-gray-700 text-gray-900 dark:text-white">
                        </div>

                        <!-- Quick Action Buttons -->
                        <div class="mt-2 flex flex-wrap gap-2" x-data="paymentInput()">
                            <button type="button" @click="setPercentage(25)"
                                class="quick-payment-btn px-3 py-1 text-xs font-medium bg-blue-50 dark:bg-blue-900/20 text-blue-700 dark:text-blue-300 rounded-lg hover:bg-blue-100 dark:hover:bg-blue-900/40 transition-colors">
                                25%
                            </button>
                            <button type="button" @click="setPercentage(50)"
                                class="quick-payment-btn px-3 py-1 text-xs font-medium bg-indigo-50 dark:bg-indigo-900/20 text-indigo-700 dark:text-indigo-300 rounded-lg hover:bg-indigo-100 dark:hover:bg-indigo-900/40 transition-colors">
                                50%
                            </button>
                            <button type="button" @click="setPercentage(75)"
                                class="quick-payment-btn px-3 py-1 text-xs font-medium bg-purple-50 dark:bg-purple-900/20 text-purple-700 dark:text-purple-300 rounded-lg hover:bg-purple-100 dark:hover:bg-purple-900/40 transition-colors">
                                75%
                            </button>
                            <button type="button" @click="setPercentage(100)"
                                class="quick-payment-btn px-3 py-1 text-xs font-medium bg-green-50 dark:bg-green-900/20 text-green-700 dark:text-green-300 rounded-lg hover:bg-green-100 dark:hover:bg-green-900/40 transition-colors border border-green-200 dark:border-green-800">
                                <iconify-icon icon="heroicons:check-circle-solid"
                                    class="inline text-sm mr-1"></iconify-icon>
                                Lunas
                            </button>
                            <button type="button" @click="clearAmount()"
                                class="px-3 py-1 text-xs font-medium bg-gray-50 dark:bg-gray-700 text-gray-700 dark:text-gray-300 rounded-lg hover:bg-gray-100 dark:hover:bg-gray-600 transition-colors">
                                <iconify-icon icon="heroicons:x-mark-solid" class="inline text-sm"></iconify-icon>
                                Reset
                            </button>
                        </div>

                        @error('jumlah')
                            <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                        @enderror
                        @if ($transaksi)
                            <p class="mt-1 text-xs text-gray-500 dark:text-gray-400">
                                Maksimal: Rp {{ number_format($transaksi->sisa_pembayaran, 0, ',', '.') }}
                            </p>
                        @else
                            <p x-show="selectedTransaction" class="mt-1 text-xs text-gray-500 dark:text-gray-400">
                                Maksimal: <span
                                    x-text="selectedTransaction ? formatCurrency(selectedTransaction.sisa_pembayaran) : ''"></span>
                            </p>
                        @endif
                    </div>

                    <!-- Metode Pembayaran -->
                    <div>
                        <label for="metode" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                            Metode Pembayaran *
                        </label>
                        <select name="metode" id="metode" required
                            class="w-full px-4 py-2 border border-gray-200 dark:border-gray-600 rounded-xl focus:ring-2 focus:ring-indigo-500 dark:focus:ring-indigo-400 bg-white dark:bg-gray-700 text-gray-900 dark:text-white">
                            <option value="">Pilih metode pembayaran</option>
                            <option value="tunai" {{ old('metode') === 'tunai' ? 'selected' : '' }}>Tunai</option>
                            <option value="transfer" {{ old('metode') === 'transfer' ? 'selected' : '' }}>Transfer Bank
                            </option>
                            <option value="qris" {{ old('metode') === 'qris' ? 'selected' : '' }}>QRIS</option>
                            <option value="kartu" {{ old('metode') === 'kartu' ? 'selected' : '' }}>Kartu Debit/Kredit
                            </option>
                            <option value="ewallet" {{ old('metode') === 'ewallet' ? 'selected' : '' }}>E-Wallet</option>
                        </select>
                        @error('metode')
                            <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Tanggal Pembayaran -->
                    <div>
                        <label for="tanggal_bayar"
                            class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                            Tanggal Pembayaran *
                        </label>
                        <input type="datetime-local" name="tanggal_bayar" id="tanggal_bayar"
                            value="{{ old('tanggal_bayar', now()->format('Y-m-d\TH:i')) }}" required
                            class="w-full px-4 py-2 border border-gray-200 dark:border-gray-600 rounded-xl focus:ring-2 focus:ring-indigo-500 dark:focus:ring-indigo-400 bg-white dark:bg-gray-700 text-gray-900 dark:text-white">
                        @error('tanggal_bayar')
                            <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Status Pembayaran -->
                    <div>
                        <label for="status" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                            Status Pembayaran *
                        </label>
                        <select name="status" id="status" required
                            class="w-full px-4 py-2 border border-gray-200 dark:border-gray-600 rounded-xl focus:ring-2 focus:ring-indigo-500 dark:focus:ring-indigo-400 bg-white dark:bg-gray-700 text-gray-900 dark:text-white">
                            <option value="">Pilih status pembayaran</option>
                            <option value="pending" {{ old('status') === 'pending' ? 'selected' : '' }}>Pending</option>
                            <option value="terkonfirmasi"
                                {{ old('status', 'terkonfirmasi') === 'terkonfirmasi' ? 'selected' : '' }}>Terkonfirmasi
                            </option>
                        </select>
                        @error('status')
                            <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                        @enderror
                        <p class="mt-1 text-xs text-gray-500 dark:text-gray-400">
                            Pilih "Terkonfirmasi" untuk langsung mengurangi sisa tagihan
                        </p>
                    </div>

                    <!-- Bukti Pembayaran -->
                    <div>
                        <label for="bukti_bayar" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                            Bukti Pembayaran
                        </label>
                        <input type="file" name="bukti_bayar" id="bukti_bayar" accept="image/*"
                            class="w-full px-4 py-2 border border-gray-200 dark:border-gray-600 rounded-xl focus:ring-2 focus:ring-indigo-500 dark:focus:ring-indigo-400 bg-white dark:bg-gray-700 text-gray-900 dark:text-white">
                        @error('bukti_bayar')
                            <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                        @enderror
                        <p class="mt-1 text-xs text-gray-500 dark:text-gray-400">
                            Upload gambar bukti pembayaran (JPG, PNG, maksimal 2MB)
                        </p>
                    </div>

                    <!-- Catatan -->
                    <div class="lg:col-span-2">
                        <label for="catatan" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                            Catatan
                        </label>
                        <textarea name="catatan" id="catatan" rows="3" placeholder="Catatan tambahan tentang pembayaran ini..."
                            class="w-full px-4 py-2 border border-gray-200 dark:border-gray-600 rounded-xl focus:ring-2 focus:ring-indigo-500 dark:focus:ring-indigo-400 bg-white dark:bg-gray-700 text-gray-900 dark:text-white">{{ old('catatan') }}</textarea>
                        @error('catatan')
                            <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
            </div>

            <!-- Action Buttons -->
            <div @if (!$transaksi) x-show="selectedTransaction" x-transition @endif
                class="flex flex-col sm:flex-row gap-4 justify-end">
                <a href="{{ route('admin.pembayaran.index') }}"
                    class="px-6 py-2 border border-gray-300 dark:border-gray-600 text-gray-700 dark:text-gray-300 bg-white dark:bg-gray-800 rounded-xl hover:bg-gray-50 dark:hover:bg-gray-700 font-medium transition-colors duration-200 text-center">
                    Batal
                </a>
                <button type="submit"
                    class="px-6 py-2 flex items-center justify-center bg-indigo-600 hover:bg-indigo-700 text-white font-medium rounded-xl transition-colors duration-200">
                    <iconify-icon icon="heroicons:plus-20-solid" class="w-4 h-4 mr-2 inline"></iconify-icon>
                    Simpan Pembayaran
                </button>
            </div>
        </form>
    </div>

    @push('scripts')
        <script>
            // Alpine.js Component: Payment Search
            function paymentSearch() {
                return {
                    searchQuery: '',
                    searchResults: [],
                    isSearching: false,
                    selectedTransaction: null,

                    async searchTransactions() {
                        if (this.searchQuery.length < 2) {
                            this.searchResults = [];
                            return;
                        }

                        this.isSearching = true;

                        try {
                            const response = await fetch(
                                `/admin/transaksi/search?q=${encodeURIComponent(this.searchQuery)}`);

                            if (!response.ok) {
                                throw new Error(`HTTP error! status: ${response.status}`);
                            }

                            const data = await response.json();
                            this.searchResults = data.transaksi || [];
                        } catch (error) {
                            console.error('Search error:', error);
                            this.searchResults = [];
                        } finally {
                            this.isSearching = false;
                        }
                    },

                    selectTransaction(transaksi) {
                        this.selectedTransaction = transaksi;
                        this.searchQuery = '';
                        this.searchResults = [];

                        this.$nextTick(() => {
                            const formElement = document.querySelector('[x-show="selectedTransaction"]');
                            if (formElement) {
                                formElement.scrollIntoView({
                                    behavior: 'smooth',
                                    block: 'start'
                                });
                            }
                        });
                    },

                    clearSelection() {
                        this.selectedTransaction = null;
                        this.searchQuery = '';
                        this.searchResults = [];

                        this.$nextTick(() => {
                            const searchElement = this.$el.querySelector('input[type="text"]');
                            if (searchElement) {
                                searchElement.focus();
                                searchElement.scrollIntoView({
                                    behavior: 'smooth',
                                    block: 'center'
                                });
                            }
                        });
                    },

                    formatCurrency(amount) {
                        return 'Rp ' + new Intl.NumberFormat('id-ID').format(amount || 0);
                    }
                }
            }

            // Alpine.js Component: Payment Input with Currency Formatting
            function paymentInput() {
                return {
                    rawValue: '',
                    showWarning: false,
                    warningTimeout: null,

                    init() {
                        const input = this.$el.previousElementSibling.querySelector('#jumlah');
                        if (!input) return;

                        // Handle input event
                        input.addEventListener('input', (e) => this.handleInput(e));

                        // Handle blur event
                        input.addEventListener('blur', (e) => this.handleBlur(e));

                        // Handle form submit
                        const form = input.closest('form');
                        if (form) {
                            form.addEventListener('submit', (e) => this.handleSubmit(e, input));
                        }
                    },

                    handleInput(e) {
                        let value = e.target.value.replace(/\D/g, '');

                        if (value) {
                            const numValue = parseInt(value);
                            const maxValue = parseInt(e.target.getAttribute('data-max') || 0);

                            // Validate against max value
                            if (maxValue > 0 && numValue > maxValue) {
                                value = maxValue.toString();
                                this.displayWarning(e.target);
                            }

                            // Format with thousands separator
                            e.target.value = parseInt(value).toLocaleString('id-ID');
                            this.rawValue = value;
                        } else {
                            e.target.value = '';
                            this.rawValue = '';
                        }
                    },

                    handleBlur(e) {
                        let value = e.target.value.replace(/\D/g, '');
                        if (value && value !== '0') {
                            e.target.value = parseInt(value).toLocaleString('id-ID');
                        } else {
                            e.target.value = '';
                        }
                    },

                    handleSubmit(e, input) {
                        const rawValue = input.value.replace(/\D/g, '');
                        input.value = rawValue || '0';
                    },

                    displayWarning(inputElement) {
                        // Clear existing timeout
                        if (this.warningTimeout) {
                            clearTimeout(this.warningTimeout);
                        }

                        // Remove existing warning
                        const existingWarning = inputElement.parentElement.parentElement.querySelector('.max-warning');
                        if (existingWarning) {
                            existingWarning.remove();
                        }

                        // Create new warning
                        const warnEl = document.createElement('p');
                        warnEl.className = 'mt-1 text-xs text-orange-600 dark:text-orange-400 max-warning';
                        warnEl.textContent = 'Jumlah melebihi sisa tagihan, disesuaikan ke maksimal';
                        inputElement.parentElement.parentElement.appendChild(warnEl);

                        // Auto-remove after 3 seconds
                        this.warningTimeout = setTimeout(() => warnEl.remove(), 3000);
                    },

                    setPercentage(percentage) {
                        const input = document.getElementById('jumlah');
                        if (!input) return;

                        const maxValue = parseInt(input.getAttribute('data-max') || 0);
                        if (maxValue === 0) return;

                        // Calculate amount
                        const amount = Math.round(maxValue * (percentage / 100));

                        // Set value and trigger formatting
                        input.value = amount.toString();
                        input.dispatchEvent(new Event('input'));

                        // Visual feedback
                        input.classList.add('ring-2', 'ring-green-500');
                        setTimeout(() => {
                            input.classList.remove('ring-2', 'ring-green-500');
                        }, 500);
                    },

                    clearAmount() {
                        const input = document.getElementById('jumlah');
                        if (input) {
                            input.value = '';
                            this.rawValue = '';
                            input.focus();
                        }
                    }
                }
            }
        </script>
    @endpush
@endsection
