@extends('layouts.admin')

@section('title', 'Tambah Transaksi')
@section('page-title', 'Tambah Transaksi')
@section('page-subtitle', 'Buat transaksi rental mobil baru')

@section('content')
    <div class="max-w-7xl mx-auto">
        <!-- Back Button -->
        <div class="mb-6">
            <a href="{{ route('admin.transaksi.index') }}"
                class="inline-flex items-center text-sm text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-white">
                <iconify-icon icon="heroicons:arrow-left-20-solid" class="w-4 h-4 mr-2"></iconify-icon>
                Kembali ke Daftar Transaksi
            </a>
        </div>

        <!-- Smart Dashboard Layout -->
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6" x-data="transactionForm()">
            <!-- Left: Form Sections -->
            <div class="lg:col-span-2 space-y-6">
                @if ($errors->any())
                    <div
                        class="p-6 bg-red-50 dark:bg-red-900/20 border-l-4 border-red-500 rounded-lg shadow-lg mb-6 animate-shake">
                        <div class="flex items-start space-x-3">
                            <iconify-icon icon="heroicons:exclamation-triangle-20-solid"
                                class="w-8 h-8 text-red-600 dark:text-red-400 mt-0.5 flex-shrink-0"></iconify-icon>
                            <div class="flex-1">
                                <h4 class="text-base font-bold text-red-800 dark:text-red-200 mb-3">
                                    ⚠️ TERJADI KESALAHAN
                                </h4>
                                <ul class="space-y-2 text-sm text-red-700 dark:text-red-300">
                                    @foreach ($errors->all() as $error)
                                        <li class="flex items-start font-medium">
                                            <span class="mr-2 font-bold">▶</span>
                                            <span>{{ $error }}</span>
                                        </li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                    </div>
                    <script>
                        // Alert untuk memastikan terlihat
                        @foreach ($errors->all() as $error)
                            alert('ERROR: {{ addslashes($error) }}');
                            @break
                        @endforeach
                    </script>
                @endif
                <form action="{{ route('admin.transaksi.store') }}" method="POST" class="space-y-6">
                    @csrf
                    <!-- Step 1: Customer Selection -->
                    <div
                        class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 p-6">
                        <div class="flex items-center justify-between mb-6">
                            <div class="flex items-center space-x-3">
                                <div
                                    class="w-8 h-8 bg-indigo-100 dark:bg-indigo-900/30 rounded-full flex items-center justify-center">
                                    <iconify-icon icon="heroicons:user-20-solid"
                                        class="w-4 h-4 text-indigo-600 dark:text-indigo-400"></iconify-icon>
                                </div>
                                <h3 class="text-lg font-semibold text-gray-900 dark:text-white">Data Pelanggan</h3>
                            </div>
                            <div class="flex items-center space-x-2" x-show="selectedCustomer">
                                <div class="w-2 h-2 bg-green-500 rounded-full animate-pulse"></div>
                                <span class="text-sm text-green-600 dark:text-green-400">Terpilih</span>
                            </div>
                        </div>

                        <div class="space-y-4">
                            <div>
                                <label for="pelanggan_id"
                                    class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                    Pilih Pelanggan <span class="text-red-500">*</span>
                                </label>
                                <div class="relative">
                                    <select name="pelanggan_id" id="pelanggan_id" x-model="selectedCustomer"
                                        @change="updateCustomerInfo($event.target.value)" required
                                        class="w-full px-4 py-3 bg-white dark:bg-gray-700 border border-gray-200 dark:border-gray-600 rounded-xl text-gray-900 dark:text-white focus:ring-2 focus:ring-indigo-500 dark:focus:ring-indigo-400 focus:border-transparent transition-colors duration-200">
                                        <option value="">-- Pilih Pelanggan --</option>
                                        @foreach ($pelanggan as $item)
                                            <option value="{{ $item->id }}" data-nama="{{ $item->nama }}"
                                                data-telepon="{{ $item->telepon }}" data-email="{{ $item->email }}"
                                                data-alamat="{{ $item->alamat }}" data-ktp="{{ $item->no_ktp }}"
                                                {{ old('pelanggan_id') == $item->id ? 'selected' : '' }}>
                                                {{ $item->nama }} - {{ $item->telepon }}
                                            </option>
                                        @endforeach
                                    </select>
                                    <div class="absolute inset-y-0 right-0 flex items-center pr-3 pointer-events-none">
                                        <iconify-icon icon="heroicons:chevron-down-20-solid"
                                            class="w-5 h-5 text-gray-400"></iconify-icon>
                                    </div>
                                </div>
                                @error('pelanggan_id')
                                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Customer Info Preview -->
                            <div x-show="selectedCustomer" x-transition
                                class="p-4 bg-gray-50 dark:bg-gray-700/50 rounded-lg">
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-3 text-sm">
                                    <div class="flex items-center space-x-2">
                                        <iconify-icon icon="heroicons:envelope-20-solid"
                                            class="w-4 h-4 text-gray-500"></iconify-icon>
                                        <span class="text-gray-600 dark:text-gray-400">Email:</span>
                                        <span x-text="customerInfo.email"
                                            class="font-medium text-gray-900 dark:text-white"></span>
                                    </div>
                                    <div class="flex items-center space-x-2">
                                        <iconify-icon icon="heroicons:identification-20-solid"
                                            class="w-4 h-4 text-gray-500"></iconify-icon>
                                        <span class="text-gray-600 dark:text-gray-400">KTP:</span>
                                        <span x-text="customerInfo.ktp"
                                            class="font-medium text-gray-900 dark:text-white"></span>
                                    </div>
                                    <div class="md:col-span-2 flex items-start space-x-2">
                                        <iconify-icon icon="heroicons:map-pin-20-solid"
                                            class="w-4 h-4 text-gray-500 mt-0.5"></iconify-icon>
                                        <span class="text-gray-600 dark:text-gray-400">Alamat:</span>
                                        <span x-text="customerInfo.alamat"
                                            class="font-medium text-gray-900 dark:text-white"></span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Step 2: Car Selection -->
                    <div
                        class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 p-6">
                        <div class="flex items-center justify-between mb-6">
                            <div class="flex items-center space-x-3">
                                <div
                                    class="w-8 h-8 bg-blue-100 dark:bg-blue-900/30 rounded-full flex items-center justify-center">
                                    <iconify-icon icon="heroicons:truck-20-solid"
                                        class="w-4 h-4 text-blue-600 dark:text-blue-400"></iconify-icon>
                                </div>
                                <h3 class="text-lg font-semibold text-gray-900 dark:text-white">Pilih Mobil & Paket</h3>
                            </div>
                            <div class="flex items-center space-x-2" x-show="selectedCar">
                                <div class="w-2 h-2 bg-green-500 rounded-full animate-pulse"></div>
                                <span class="text-sm text-green-600 dark:text-green-400">Terpilih</span>
                            </div>
                        </div>

                        <div class="space-y-6">
                            <!-- Car Selection -->
                            <div>
                                <label for="mobil_id"
                                    class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                    Pilih Mobil <span class="text-red-500">*</span>
                                </label>
                                <select name="mobil_id" id="mobil_id" x-model="selectedCar"
                                    @change="updateCarInfo($event.target.value); loadPricingOptions($event.target.value)"
                                    required
                                    class="w-full px-4 py-3 bg-white dark:bg-gray-700 border border-gray-200 dark:border-gray-600 rounded-xl text-gray-900 dark:text-white focus:ring-2 focus:ring-indigo-500 dark:focus:ring-indigo-400 focus:border-transparent transition-colors duration-200">
                                    <option value="">-- Pilih Mobil --</option>
                                    @foreach ($mobil as $item)
                                        <option value="{{ $item->id }}" data-merk="{{ $item->merk }}"
                                            data-model="{{ $item->model }}" data-plat="{{ $item->plat_nomor }}"
                                            data-tahun="{{ $item->tahun }}" data-warna="{{ $item->warna }}"
                                            data-kapasitas="{{ $item->kapasitas_penumpang }}"
                                            data-transmisi="{{ $item->transmisi }}"
                                            data-bahan-bakar="{{ $item->jenis_bahan_bakar }}"
                                            data-status="{{ $item->status }}"
                                            {{ in_array($item->status, ['nonaktif', 'perawatan']) ? 'disabled' : '' }}
                                            {{ old('mobil_id') == $item->id ? 'selected' : '' }}>
                                            {{ $item->merk }} {{ $item->model }} - {{ $item->plat_nomor }}
                                            @if ($item->status === 'disewa')
                                                (Sedang Disewa - Cek Ketersediaan)
                                            @elseif($item->status === 'nonaktif')
                                                (Nonaktif - Tidak Tersedia)
                                            @elseif($item->status === 'perawatan')
                                                (Perawatan - Tidak Tersedia)
                                            @elseif($item->status === 'tersedia')
                                                (Tersedia Sekarang)
                                            @endif
                                        </option>
                                    @endforeach
                                </select>
                                @error('mobil_id')
                                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Car Status Info -->
                            <div x-show="selectedCar" x-transition
                                class="p-4 bg-blue-50 dark:bg-blue-900/20 rounded-lg border border-blue-200 dark:border-blue-800 mb-4">
                                <div class="flex items-start space-x-2">
                                    <iconify-icon icon="heroicons:information-circle-20-solid"
                                        class="w-5 h-5 text-blue-600 dark:text-blue-400 mt-0.5"></iconify-icon>
                                    <div class="text-sm">
                                        <p class="font-medium text-blue-800 dark:text-blue-200 mb-1">Informasi Ketersediaan
                                        </p>
                                        <p class="text-blue-700 dark:text-blue-300">
                                            Sistem akan mengecek ketersediaan mobil berdasarkan tanggal sewa yang Anda
                                            pilih.
                                            Mobil yang sedang disewa saat ini masih bisa dibooking untuk tanggal yang
                                            berbeda.
                                        </p>
                                    </div>
                                </div>
                            </div>

                            <!-- Car Info Preview -->
                            <div x-show="selectedCar" x-transition class="p-4 bg-gray-50 dark:bg-gray-700/50 rounded-lg">
                                <div class="grid grid-cols-2 md:grid-cols-4 gap-3 text-sm">
                                    <div class="flex items-center space-x-2">
                                        <iconify-icon icon="heroicons:calendar-20-solid"
                                            class="w-4 h-4 text-gray-500"></iconify-icon>
                                        <div>
                                            <span class="text-gray-600 dark:text-gray-400">Tahun:</span>
                                            <span x-text="carInfo.tahun"
                                                class="font-medium text-gray-900 dark:text-white ml-1"></span>
                                        </div>
                                    </div>
                                    <div class="flex items-center space-x-2">
                                        <iconify-icon icon="heroicons:swatch-20-solid"
                                            class="w-4 h-4 text-gray-500"></iconify-icon>
                                        <div>
                                            <span class="text-gray-600 dark:text-gray-400">Warna:</span>
                                            <span x-text="carInfo.warna"
                                                class="font-medium text-gray-900 dark:text-white ml-1"></span>
                                        </div>
                                    </div>
                                    <div class="flex items-center space-x-2">
                                        <iconify-icon icon="heroicons:users-20-solid"
                                            class="w-4 h-4 text-gray-500"></iconify-icon>
                                        <div>
                                            <span class="text-gray-600 dark:text-gray-400">Kapasitas:</span>
                                            <span x-text="carInfo.kapasitas"
                                                class="font-medium text-gray-900 dark:text-white ml-1"></span>
                                        </div>
                                    </div>
                                    <div class="flex items-center space-x-2">
                                        <iconify-icon icon="heroicons:cog-6-tooth-20-solid"
                                            class="w-4 h-4 text-gray-500"></iconify-icon>
                                        <div>
                                            <span class="text-gray-600 dark:text-gray-400">Transmisi:</span>
                                            <span x-text="carInfo.transmisi"
                                                class="font-medium text-gray-900 dark:text-white ml-1"></span>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Pricing Package Selection -->
                            <div x-show="selectedCar" x-transition>
                                <label for="harga_sewa_id"
                                    class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-3">
                                    Pilih Paket Sewa <span class="text-red-500">*</span>
                                </label>
                                <div class="grid grid-cols-1 gap-3" x-show="pricingOptions.length > 0">
                                    <template x-for="pricing in pricingOptions" :key="pricing.id">
                                        <label class="relative cursor-pointer">
                                            <input type="radio" name="harga_sewa_id" :value="pricing.id"
                                                x-model="selectedPricing" @change="updateCalculation()"
                                                class="sr-only peer">
                                            <div
                                                class="p-4 bg-white dark:bg-gray-700 border border-gray-200 dark:border-gray-600 rounded-lg peer-checked:border-indigo-500 peer-checked:ring-2 peer-checked:ring-indigo-500 peer-checked:bg-indigo-50 dark:peer-checked:bg-indigo-900/20 transition-all">
                                                <div class="flex items-center justify-between">
                                                    <div>
                                                        <h4 class="font-medium text-gray-900 dark:text-white"
                                                            x-text="pricing.jenis_sewa.nama_jenis"></h4>
                                                        <p class="text-sm text-gray-600 dark:text-gray-400"
                                                            x-text="pricing.jenis_sewa.deskripsi || 'Paket rental standar'">
                                                        </p>
                                                    </div>
                                                    <div class="text-right">
                                                        <p class="text-lg font-bold text-indigo-600 dark:text-indigo-400"
                                                            x-text="'Rp ' + new Intl.NumberFormat('id-ID').format(pricing.harga_per_hari)">
                                                        </p>
                                                        <p class="text-sm text-gray-500 dark:text-gray-400">per hari</p>
                                                    </div>
                                                </div>
                                            </div>
                                        </label>
                                    </template>
                                </div>
                                <div x-show="pricingOptions.length === 0"
                                    class="text-center py-4 text-gray-500 dark:text-gray-400">
                                    Pilih mobil terlebih dahulu untuk melihat paket harga
                                </div>
                                @error('harga_sewa_id')
                                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <!-- Step 3: Rental Period -->
                    <div
                        class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 p-6">
                        <div class="flex items-center justify-between mb-6">
                            <div class="flex items-center space-x-3">
                                <div
                                    class="w-8 h-8 bg-green-100 dark:bg-green-900/30 rounded-full flex items-center justify-center">
                                    <iconify-icon icon="heroicons:calendar-days-20-solid"
                                        class="w-4 h-4 text-green-600 dark:text-green-400"></iconify-icon>
                                </div>
                                <h3 class="text-lg font-semibold text-gray-900 dark:text-white">Periode & Sopir</h3>
                            </div>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                            <!-- Rental Date -->
                            <div>
                                <label for="tanggal_sewa"
                                    class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                    Tanggal Mulai Sewa <span class="text-red-500">*</span>
                                </label>
                                <input type="date" name="tanggal_sewa" id="tanggal_sewa" x-model="rentalDate"
                                    @change="updateCalculation(); validateAvailability()" required
                                    value="{{ old('tanggal_sewa', date('Y-m-d')) }}" min="{{ date('Y-m-d') }}"
                                    max="{{ date('Y-m-d', strtotime('+' . $settings['advance_booking_days'] . ' days')) }}"
                                    class="w-full px-4 py-3 bg-white dark:bg-gray-700 border @error('tanggal_sewa') border-red-500 dark:border-red-500 @else border-gray-200 dark:border-gray-600 @enderror rounded-xl text-gray-900 dark:text-white focus:ring-2 focus:ring-indigo-500 dark:focus:ring-indigo-400 focus:border-transparent transition-colors duration-200">
                                @error('tanggal_sewa')
                                    <div
                                        class="flex items-start space-x-2 mt-2 p-3 bg-red-50 dark:bg-red-900/20 border border-red-200 dark:border-red-800 rounded-lg">
                                        <iconify-icon icon="heroicons:exclamation-triangle-20-solid"
                                            class="w-5 h-5 text-red-600 dark:text-red-400 flex-shrink-0 mt-0.5"></iconify-icon>
                                        <p class="text-sm text-red-700 dark:text-red-300">{{ $message }}</p>
                                    </div>
                                @enderror
                            </div>

                            <!-- Return Date -->
                            <div>
                                <label for="tanggal_kembali"
                                    class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                    Tanggal Kembali <span class="text-red-500">*</span>
                                </label>
                                <input type="date" name="tanggal_kembali" id="tanggal_kembali" x-model="returnDate"
                                    @change="calculateDurationFromDates()" required
                                    :min="rentalDate || '{{ date('Y-m-d') }}'"
                                    class="w-full px-4 py-3 bg-white dark:bg-gray-700 border border-gray-200 dark:border-gray-600 rounded-xl text-gray-900 dark:text-white focus:ring-2 focus:ring-indigo-500 dark:focus:ring-indigo-400 focus:border-transparent transition-colors duration-200">
                                @error('tanggal_kembali')
                                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Duration -->
                            <div>
                                <label for="durasi_hari"
                                    class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                    Durasi Sewa (Hari) <span class="text-red-500">*</span>
                                </label>
                                <div class="relative">
                                    <input type="number" name="durasi_hari" id="durasi_hari" x-model="duration"
                                        @input="updateCalculation(); validateAvailability()" required
                                        min="{{ $settings['min_rental_days'] }}"
                                        max="{{ $settings['max_rental_days'] }}"
                                        value="{{ old('durasi_hari', $analytics['avg_duration']) }}"
                                        class="w-full px-4 py-3 bg-white dark:bg-gray-700 border border-gray-200 dark:border-gray-600 rounded-xl text-gray-900 dark:text-white focus:ring-2 focus:ring-indigo-500 dark:focus:ring-indigo-400 focus:border-transparent transition-colors duration-200">
                                    <div class="absolute inset-y-0 right-0 flex items-center pr-3">
                                        <span class="text-gray-500 dark:text-gray-400 text-sm">hari</span>
                                    </div>
                                </div>
                                <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">
                                    Rata-rata: {{ $analytics['avg_duration'] }} hari | Min:
                                    {{ $settings['min_rental_days'] }} - Max: {{ $settings['max_rental_days'] }} hari
                                </p>
                                @error('durasi_hari')
                                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Quick Duration Buttons -->
                            <div class="md:col-span-3">
                                <p class="text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Durasi Populer:</p>
                                <div class="flex flex-wrap gap-2">
                                    <template x-for="day in [1, 3, 7, 14, 30]" :key="day">
                                        <button type="button" @click="setDuration(day)"
                                            :class="duration == day ? 'bg-indigo-600 text-white' :
                                                'bg-gray-100 dark:bg-gray-700 text-gray-700 dark:text-gray-300 hover:bg-gray-200 dark:hover:bg-gray-600'"
                                            class="px-3 py-1 rounded-lg text-sm font-medium transition-colors duration-200">
                                            <span x-text="day"></span> hari
                                        </button>
                                    </template>
                                </div>
                            </div>

                            <!-- Rental Period Summary -->
                            <div class="md:col-span-3" x-show="rentalDate && returnDate && duration">
                                <div x-transition
                                    class="p-4 bg-indigo-50 dark:bg-indigo-900/20 rounded-lg border border-indigo-200 dark:border-indigo-800">
                                    <div class="grid grid-cols-1 md:grid-cols-3 gap-3 text-sm">
                                        <div>
                                            <span class="text-gray-600 dark:text-gray-400">Tanggal Sewa:</span>
                                            <div class="font-semibold text-indigo-600 dark:text-indigo-400"
                                                x-text="formatDisplayDate(rentalDate)"></div>
                                        </div>
                                        <div>
                                            <span class="text-gray-600 dark:text-gray-400">Tanggal Kembali:</span>
                                            <div class="font-semibold text-indigo-600 dark:text-indigo-400"
                                                x-text="formatDisplayDate(returnDate)"></div>
                                        </div>
                                        <div>
                                            <span class="text-gray-600 dark:text-gray-400">Total Durasi:</span>
                                            <div class="font-semibold text-indigo-600 dark:text-indigo-400"
                                                x-text="duration + ' Hari'"></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Driver Selection -->
                        <div class="mt-6 border-t border-gray-200 dark:border-gray-700 pt-6" x-show="requiresDriver"
                            x-transition>
                            <label for="sopir_id" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-3">
                                Sopir <span class="text-red-500" x-show="requiresDriver">*</span>
                                <span class="text-gray-500" x-show="!requiresDriver">(Opsional)</span>
                            </label>
                            <div class="flex flex-col gap-4">
                                <!-- No Driver Option - only show if driver not required -->
                                <label class="relative cursor-pointer" x-show="!requiresDriver">
                                    <input type="radio" name="sopir_id" value="" x-model="selectedDriver"
                                        @change="updateCalculation()" class="sr-only peer">
                                    <div
                                        class="p-4 bg-white dark:bg-gray-700 border border-gray-200 dark:border-gray-600 rounded-lg peer-checked:border-indigo-500 peer-checked:ring-2 peer-checked:ring-indigo-500 peer-checked:bg-indigo-50 dark:peer-checked:bg-indigo-900/20 transition-all">
                                        <div class="flex items-center justify-between">
                                            <div class="flex items-center space-x-3">
                                                <div
                                                    class="w-10 h-10 bg-gray-100 dark:bg-gray-600 rounded-full flex items-center justify-center">
                                                    <iconify-icon icon="heroicons:key-20-solid"
                                                        class="w-5 h-5 text-gray-500 dark:text-gray-400"></iconify-icon>
                                                </div>
                                                <div>
                                                    <h4 class="font-medium text-gray-900 dark:text-white">Tanpa Sopir
                                                        (Lepas Kunci)</h4>
                                                    <p class="text-sm text-gray-600 dark:text-gray-400">Anda mengendarai
                                                        sendiri</p>
                                                </div>
                                            </div>
                                            <div class="text-right">
                                                <p class="text-lg font-bold text-green-600 dark:text-green-400">GRATIS</p>
                                            </div>
                                        </div>
                                    </div>
                                </label>

                                @foreach ($sopir as $item)
                                    <label class="relative cursor-pointer">
                                        <input type="radio" name="sopir_id" value="{{ $item->id }}"
                                            x-model="selectedDriver" @change="updateCalculation()"
                                            {{ old('sopir_id') == $item->id ? 'checked' : '' }} :required="requiresDriver"
                                            class="sr-only peer">
                                        <div
                                            class="p-4 bg-white dark:bg-gray-700 border border-gray-200 dark:border-gray-600 rounded-lg peer-checked:border-indigo-500 peer-checked:ring-2 peer-checked:ring-indigo-500 peer-checked:bg-indigo-50 dark:peer-checked:bg-indigo-900/20 transition-all">
                                            <div class="flex items-center justify-between">
                                                <div class="flex items-center space-x-3">
                                                    <div
                                                        class="w-10 h-10 bg-indigo-100 dark:bg-indigo-900/30 rounded-full flex items-center justify-center">
                                                        <iconify-icon icon="heroicons:user-20-solid"
                                                            class="w-5 h-5 text-indigo-600 dark:text-indigo-400"></iconify-icon>
                                                    </div>
                                                    <div>
                                                        <h4 class="font-medium text-gray-900 dark:text-white">
                                                            {{ $item->nama }}</h4>
                                                        <div
                                                            class="flex items-center space-x-2 text-sm text-gray-600 dark:text-gray-400">
                                                            <iconify-icon icon="heroicons:phone-20-solid"
                                                                class="w-4 h-4"></iconify-icon>
                                                            <span>{{ $item->telepon }}</span>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </label>
                                @endforeach
                            </div>
                            @error('sopir_id')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Driver Required Notice -->
                        <div x-show="!requiresDriver" x-transition
                            class="mt-6 p-4 bg-blue-50 dark:bg-blue-900/20 rounded-lg border border-blue-200 dark:border-blue-800">
                            <div class="flex items-center space-x-2">
                                <iconify-icon icon="heroicons:information-circle-20-solid"
                                    class="w-5 h-5 text-blue-600 dark:text-blue-400"></iconify-icon>
                                <p class="text-sm text-blue-700 dark:text-blue-300">
                                    Paket ini tidak memerlukan sopir. Pilih paket dengan "Driver" jika Anda membutuhkan
                                    sopir.
                                </p>
                            </div>
                        </div>

                        <!-- Driver Validation Message -->
                        <div x-show="requiresDriver && getDriverValidationMessage()" x-transition
                            class="mt-6 p-4 bg-orange-50 dark:bg-orange-900/20 rounded-lg border border-orange-200 dark:border-orange-800">
                            <div class="flex items-center space-x-2">
                                <iconify-icon icon="heroicons:exclamation-triangle-20-solid"
                                    class="w-5 h-5 text-orange-600 dark:text-orange-400"></iconify-icon>
                                <p class="text-sm text-orange-700 dark:text-orange-300"
                                    x-text="getDriverValidationMessage()"></p>
                            </div>
                        </div>
                    </div>

                    <!-- Step 4: Additional Notes -->
                    <div
                        class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 p-6">
                        <div class="flex items-center space-x-3 mb-6">
                            <div
                                class="w-8 h-8 bg-purple-100 dark:bg-purple-900/30 rounded-full flex items-center justify-center">
                                <iconify-icon icon="heroicons:document-text-20-solid"
                                    class="w-4 h-4 text-purple-600 dark:text-purple-400"></iconify-icon>
                            </div>
                            <h3 class="text-lg font-semibold text-gray-900 dark:text-white">Catatan & Informasi Tambahan
                            </h3>
                        </div>

                        <div>
                            <label for="catatan" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                Catatan Transaksi (Opsional)
                            </label>
                            <textarea name="catatan" id="catatan" rows="4"
                                class="w-full px-4 py-3 bg-white dark:bg-gray-700 border border-gray-200 dark:border-gray-600 rounded-xl text-gray-900 dark:text-white focus:ring-2 focus:ring-indigo-500 dark:focus:ring-indigo-400 focus:border-transparent transition-colors duration-200 resize-none"
                                placeholder="Contoh: Keperluan wisata keluarga, pickup di bandara, butuh child seat, dll.">{{ old('catatan') }}</textarea>
                            <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">Informasi ini akan membantu admin dan
                                sopir mempersiapkan layanan yang sesuai</p>
                            @error('catatan')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <!-- Submit Actions -->
                    <div class="flex items-center justify-end space-x-3 pt-6">
                        <a href="{{ route('admin.transaksi.index') }}"
                            class="inline-flex items-center px-6 py-3 bg-gray-100 hover:bg-gray-200 dark:bg-gray-700 dark:hover:bg-gray-600 text-gray-700 dark:text-gray-300 text-sm font-medium rounded-xl transition-colors duration-200">
                            <iconify-icon icon="heroicons:x-mark-20-solid" class="w-4 h-4 mr-2"></iconify-icon>
                            Batal
                        </a>
                        <button type="submit" :disabled="!isFormValid()"
                            :class="isFormValid() ? 'bg-indigo-600 hover:bg-indigo-700 text-white' :
                                'bg-gray-300 dark:bg-gray-600 text-gray-500 dark:text-gray-400 cursor-not-allowed'"
                            class="inline-flex items-center px-6 py-3 text-sm font-medium rounded-xl transition-colors duration-200">
                            <iconify-icon icon="heroicons:plus-20-solid" class="w-4 h-4 mr-2"></iconify-icon>
                            <span x-text="isFormValid() ? 'Buat Transaksi' : 'Lengkapi Data'"></span>
                        </button>
                    </div>
                </form>
            </div>

            <!-- Right: Live Summary Sidebar -->
            <div class="lg:col-span-1">
                <div class="sticky top-0 space-y-6">
                    <!-- Live Calculation Card -->
                    <div
                        class="bg-gradient-to-br from-indigo-50 to-purple-50 dark:from-indigo-900/20 dark:to-purple-900/20 rounded-xl border border-indigo-200 dark:border-indigo-800 p-6">
                        <div class="flex items-center space-x-3 mb-6">
                            <div class="w-8 h-8 bg-indigo-600 rounded-full flex items-center justify-center">
                                <iconify-icon icon="heroicons:calculator-20-solid"
                                    class="w-4 h-4 text-white"></iconify-icon>
                            </div>
                            <h3 class="text-lg font-semibold text-gray-900 dark:text-white">Ringkasan Biaya</h3>
                        </div>

                        <!-- Cost Breakdown -->
                        <div class="space-y-4" x-show="selectedPricing && duration > 0">
                            <!-- Car Rental Cost -->
                            <div
                                class="flex items-center justify-between py-2 border-b border-indigo-200 dark:border-indigo-700">
                                <div class="flex items-center space-x-2">
                                    <iconify-icon icon="heroicons:truck-20-solid"
                                        class="w-4 h-4 text-indigo-600 dark:text-indigo-400"></iconify-icon>
                                    <span class="text-sm text-gray-700 dark:text-gray-300">Sewa Mobil</span>
                                </div>
                                <div class="text-right">
                                    <p class="font-medium text-gray-900 dark:text-white"
                                        x-text="formatCurrency(carRentalCost)"></p>
                                    <p class="text-xs text-gray-500 dark:text-gray-400"
                                        x-text="`${formatCurrency(dailyCarRate)} × ${duration} hari`"></p>
                                </div>
                            </div>

                            <!-- Total Cost -->
                            <div
                                class="flex items-center justify-between pt-4 border-t-2 border-indigo-300 dark:border-indigo-600">
                                <span class="text-lg font-semibold text-gray-900 dark:text-white">Total</span>
                                <span class="text-2xl font-bold text-indigo-600 dark:text-indigo-400"
                                    x-text="formatCurrency(totalCost)"></span>
                            </div>

                            <!-- Average Comparison -->
                            <div x-show="totalCost !== {{ $analytics['avg_total'] }}"
                                class="p-3 bg-white/50 dark:bg-gray-800/50 rounded-lg">
                                <div class="flex items-center justify-between text-sm">
                                    <span class="text-gray-600 dark:text-gray-400">Rata-rata transaksi:</span>
                                    <span
                                        class="font-medium text-gray-900 dark:text-white">{{ 'Rp ' . number_format($analytics['avg_total'], 0, ',', '.') }}</span>
                                </div>
                                <div class="mt-1 text-xs"
                                    :class="totalCost > {{ $analytics['avg_total'] }} ?
                                        'text-orange-600 dark:text-orange-400' : 'text-green-600 dark:text-green-400'">
                                    <span
                                        x-text="totalCost > {{ $analytics['avg_total'] }} ? 'Di atas rata-rata' : 'Di bawah rata-rata'"></span>
                                    <span
                                        x-text="`(${Math.abs(((totalCost - {{ $analytics['avg_total'] }}) / {{ $analytics['avg_total'] }}) * 100).toFixed(1)}%)`"></span>
                                </div>
                            </div>
                        </div>

                        <!-- Placeholder when no selection -->
                        <div x-show="!selectedPricing || duration === 0" class="text-center py-8">
                            <div
                                class="w-16 h-16 bg-indigo-100 dark:bg-indigo-900/30 rounded-full flex items-center justify-center mx-auto mb-3">
                                <iconify-icon icon="heroicons:currency-dollar-20-solid"
                                    class="w-8 h-8 text-indigo-600 dark:text-indigo-400"></iconify-icon>
                            </div>
                            <p class="text-gray-600 dark:text-gray-400 text-sm">Pilih mobil dan durasi untuk melihat
                                perhitungan biaya</p>
                        </div>
                    </div>

                    <!-- Transaction Summary -->
                    <div class="bg-white dark:bg-gray-800 rounded-xl border border-gray-200 dark:border-gray-700 p-6">
                        <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4 flex items-center">
                            <iconify-icon icon="heroicons:clipboard-document-list-20-solid"
                                class="w-5 h-5 mr-2 text-gray-600 dark:text-gray-400"></iconify-icon>
                            Detail Transaksi
                        </h3>

                        <div class="space-y-3 text-sm">
                            <!-- Customer Info -->
                            <div x-show="selectedCustomer">
                                <div class="flex items-center space-x-2 mb-1">
                                    <iconify-icon icon="heroicons:user-20-solid"
                                        class="w-4 h-4 text-gray-500"></iconify-icon>
                                    <span class="font-medium text-gray-700 dark:text-gray-300">Pelanggan</span>
                                </div>
                                <p class="text-gray-900 dark:text-white ml-6" x-text="customerInfo.nama"></p>
                                <p class="text-gray-600 dark:text-gray-400 ml-6" x-text="customerInfo.telepon"></p>
                            </div>

                            <!-- Car Info -->
                            <div x-show="selectedCar">
                                <div class="flex items-center space-x-2 mb-1">
                                    <iconify-icon icon="heroicons:truck-20-solid"
                                        class="w-4 h-4 text-gray-500"></iconify-icon>
                                    <span class="font-medium text-gray-700 dark:text-gray-300">Mobil</span>
                                </div>
                                <p class="text-gray-900 dark:text-white ml-6" x-text="`${carInfo.merk} ${carInfo.model}`">
                                </p>
                                <p class="text-gray-600 dark:text-gray-400 ml-6" x-text="carInfo.plat"></p>
                            </div>

                            <!-- Rental Period -->
                            <div x-show="rentalDate && duration > 0">
                                <div class="flex items-center space-x-2 mb-1">
                                    <iconify-icon icon="heroicons:calendar-days-20-solid"
                                        class="w-4 h-4 text-gray-500"></iconify-icon>
                                    <span class="font-medium text-gray-700 dark:text-gray-300">Periode</span>
                                </div>
                                <p class="text-gray-900 dark:text-white ml-6" x-text="formatDateRange()"></p>
                                <p class="text-gray-600 dark:text-gray-400 ml-6" x-text="`${duration} hari`"></p>
                            </div>

                            <!-- Driver Info -->
                            <div x-show="selectedDriver">
                                <div class="flex items-center space-x-2 mb-1">
                                    <iconify-icon icon="heroicons:user-circle-20-solid"
                                        class="w-4 h-4 text-gray-500"></iconify-icon>
                                    <span class="font-medium text-gray-700 dark:text-gray-300">Sopir</span>
                                </div>
                                <p class="text-gray-900 dark:text-white ml-6" x-text="getDriverInfo().name"></p>
                            </div>
                        </div>

                        <!-- Validation Status -->
                        <div class="mt-6 pt-4 border-t border-gray-200 dark:border-gray-700">
                            <div class="flex items-center space-x-2">
                                <div :class="isFormValid() ? 'bg-green-500' : 'bg-orange-500'"
                                    class="w-2 h-2 rounded-full"></div>
                                <span
                                    :class="isFormValid() ? 'text-green-600 dark:text-green-400' :
                                        'text-orange-600 dark:text-orange-400'"
                                    class="text-sm font-medium"
                                    x-text="isFormValid() ? 'Siap untuk dibuat' : 'Lengkapi data terlebih dahulu'">
                                </span>
                            </div>
                        </div>
                    </div>

                    <!-- Quick Tips -->
                    <div
                        class="bg-gradient-to-br from-yellow-50 to-orange-50 dark:from-yellow-900/10 dark:to-orange-900/10 rounded-xl border border-yellow-200 dark:border-yellow-800 p-4">
                        <div class="flex items-start space-x-2">
                            <iconify-icon icon="heroicons:light-bulb-20-solid"
                                class="w-5 h-5 text-yellow-600 dark:text-yellow-400 mt-0.5"></iconify-icon>
                            <div>
                                <h4 class="text-sm font-medium text-yellow-800 dark:text-yellow-200 mb-2">Tips</h4>
                                <ul class="text-xs text-yellow-700 dark:text-yellow-300 space-y-1">
                                    <li>• Periksa ketersediaan mobil sebelum konfirmasi</li>
                                    <li>• Rata-rata durasi sewa: {{ $analytics['avg_duration'] }} hari</li>
                                    <li>• Pelanggan dapat membatalkan {{ $settings['cancellation_hours'] }} jam sebelumnya
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>

    @push('scripts')
        <script>
            document.addEventListener('alpine:init', () => {
                Alpine.data('transactionForm', () => ({
                    // Form Data
                    selectedCustomer: '{{ old('pelanggan_id', '') }}',
                    selectedCar: '{{ old('mobil_id', '') }}',
                    selectedPricing: '{{ old('harga_sewa_id', '') }}',
                    selectedDriver: '{{ old('sopir_id', '') }}',
                    rentalDate: '{{ old('tanggal_sewa', date('Y-m-d')) }}',
                    returnDate: '{{ old('tanggal_kembali', '') }}',
                    duration: {{ old('durasi_hari', $analytics['avg_duration']) }},

                    // Data Collections
                    customerInfo: {},
                    carInfo: {},
                    pricingOptions: [],

                    // Calculation Variables
                    dailyCarRate: 0,
                    carRentalCost: 0,
                    totalCost: 0,

                    // Driver requirement check
                    requiresDriver: false,

                    // Data from Backend
                    pelangganData: @json($pelanggan->keyBy('id')),
                    mobilData: @json($mobil->keyBy('id')),
                    hargaSewaData: @json($hargaSewa),
                    sopirData: @json($sopir->keyBy('id')),

                    init() {
                        // Initialize with old values if exists
                        if (this.selectedCustomer) {
                            this.updateCustomerInfo(this.selectedCustomer);
                        }
                        if (this.selectedCar) {
                            this.updateCarInfo(this.selectedCar);
                            this.loadPricingOptions(this.selectedCar);
                        }

                        // Calculate return date if not set
                        if (this.rentalDate && !this.returnDate && this.duration > 0) {
                            this.calculateReturnDate();
                        }

                        if (this.selectedPricing && this.duration > 0) {
                            this.updateCalculation();
                        }
                        // Check initial driver requirement
                        this.checkDriverRequirement();
                    },

                    updateCustomerInfo(customerId) {
                        if (customerId && this.pelangganData[customerId]) {
                            this.customerInfo = {
                                nama: this.pelangganData[customerId].nama,
                                telepon: this.pelangganData[customerId].telepon,
                                email: this.pelangganData[customerId].email || '-',
                                alamat: this.pelangganData[customerId].alamat || '-',
                                ktp: this.pelangganData[customerId].no_ktp || '-'
                            };
                        }
                    },

                    updateCarInfo(carId) {
                        if (carId && this.mobilData[carId]) {
                            const car = this.mobilData[carId];
                            this.carInfo = {
                                merk: car.merk || '',
                                model: car.model || '',
                                plat: car.plat_nomor || '',
                                tahun: car.tahun || '',
                                warna: car.warna || '',
                                kapasitas: car.kapasitas_penumpang || '',
                                transmisi: car.transmisi || '',
                                bahan_bakar: car.jenis_bahan_bakar || ''
                            };
                        }
                    },

                    loadPricingOptions(carId) {
                        this.pricingOptions = [];

                        // Reset pricing and driver selection when car changes
                        this.selectedPricing = '';
                        this.selectedDriver = '';
                        this.requiresDriver = false;

                        if (carId && this.hargaSewaData[carId]) {
                            this.pricingOptions = this.hargaSewaData[carId] || [];
                        }
                    },

                    updateCalculation() {
                        this.dailyCarRate = 0;
                        this.carRentalCost = 0;
                        this.totalCost = 0;

                        // Calculate return date when duration or rental date changes
                        if (this.rentalDate && this.duration > 0) {
                            this.calculateReturnDate();
                        }

                        // Check driver requirement first
                        this.checkDriverRequirement();

                        // Calculate car rental cost (tanpa biaya sopir)
                        if (this.selectedPricing && this.duration > 0) {
                            const pricing = this.pricingOptions.find(p => p.id == this.selectedPricing);
                            if (pricing) {
                                this.dailyCarRate = pricing.harga_per_hari;
                                this.carRentalCost = this.dailyCarRate * this.duration;
                            }
                        }

                        // Total = Car Rental only (no driver cost)
                        this.totalCost = this.carRentalCost;
                    },

                    checkDriverRequirement() {
                        const previousRequirement = this.requiresDriver;
                        this.requiresDriver = false;

                        if (this.selectedPricing) {
                            const pricing = this.pricingOptions.find(p => p.id == this.selectedPricing);
                            if (pricing && pricing.jenis_sewa && pricing.jenis_sewa.slug) {
                                // Check if slug contains 'driver'
                                this.requiresDriver = pricing.jenis_sewa.slug.toLowerCase().includes(
                                    'driver');
                            }
                        }

                        // Handle driver selection based on requirement changes
                        if (!this.requiresDriver && previousRequirement) {
                            // Driver is no longer required but was before - clear selection
                            this.selectedDriver = '';
                            console.log('Driver cleared - no longer required for this package');
                        } else if (this.requiresDriver && !this.selectedDriver) {
                            // Driver is required but not selected - keep empty for user to choose
                            console.log('Driver required - user needs to select one');
                        }
                    },

                    setDuration(days) {
                        this.duration = days;
                        this.calculateReturnDate();
                        this.updateCalculation();
                    },

                    calculateReturnDate() {
                        if (this.rentalDate && this.duration > 0) {
                            const startDate = new Date(this.rentalDate);
                            const returnDate = new Date(startDate);
                            // Duration 1 hari = kembali hari yang sama
                            returnDate.setDate(startDate.getDate() + parseInt(this.duration - 1));
                            this.returnDate = returnDate.toISOString().split('T')[0];
                        }
                    },

                    calculateDurationFromDates() {
                        if (this.rentalDate && this.returnDate) {
                            const startDate = new Date(this.rentalDate);
                            const endDate = new Date(this.returnDate);

                            // Calculate difference in days
                            const diffTime = endDate - startDate;
                            const diffDays = Math.ceil(diffTime / (1000 * 60 * 60 * 24));

                            // Duration minimal 1 hari (same day rental)
                            this.duration = Math.max(1, diffDays + 1);
                            this.updateCalculation();
                        }
                    },

                    formatDisplayDate(dateString) {
                        if (!dateString) return '';
                        const date = new Date(dateString);
                        return date.toLocaleDateString('id-ID', {
                            weekday: 'long',
                            year: 'numeric',
                            month: 'long',
                            day: 'numeric'
                        });
                    },

                    formatDateRange() {
                        if (this.rentalDate && this.duration > 0) {
                            const startDate = new Date(this.rentalDate);
                            const endDate = new Date(startDate);
                            endDate.setDate(startDate.getDate() + parseInt(this.duration - 1));

                            const formatOptions = {
                                day: 'numeric',
                                month: 'short',
                                year: 'numeric'
                            };
                            return `${startDate.toLocaleDateString('id-ID', formatOptions)} - ${endDate.toLocaleDateString('id-ID', formatOptions)}`;
                        }
                        return '';
                    },

                    getDriverInfo() {
                        if (this.selectedDriver && this.sopirData[this.selectedDriver]) {
                            const driver = this.sopirData[this.selectedDriver];
                            return {
                                name: driver.nama
                            };
                        }
                        return {
                            name: 'Tanpa Sopir'
                        };
                    },

                    formatCurrency(amount) {
                        return 'Rp ' + new Intl.NumberFormat('id-ID').format(amount || 0);
                    },

                    isFormValid() {
                        const baseValid = this.selectedCustomer &&
                            this.selectedCar &&
                            this.selectedPricing &&
                            this.rentalDate &&
                            this.returnDate &&
                            this.duration > 0;

                        // If driver is required, check if driver is selected
                        if (this.requiresDriver) {
                            return baseValid && this.selectedDriver && this.selectedDriver !== '';
                        }

                        return baseValid;
                    },

                    getDriverValidationMessage() {
                        if (this.requiresDriver && (!this.selectedDriver || this.selectedDriver === '')) {
                            return 'Pilih sopir untuk melanjutkan - diperlukan untuk paket ini';
                        }
                        return '';
                    },

                    validateAvailability() {
                        // Real-time availability checking
                        if (this.selectedCar && this.rentalDate && this.returnDate) {
                            console.log('Checking availability:', {
                                car: this.selectedCar,
                                from: this.rentalDate,
                                to: this.returnDate,
                                duration: this.duration
                            });
                            // Note: Backend will validate on submit with conflict checking
                            // This could be enhanced with AJAX call to check availability in real-time
                        }
                    }
                }));
            });
        </script>
    @endpush
@endsection
