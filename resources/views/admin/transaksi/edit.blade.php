@extends('layouts.admin')

@section('title', 'Edit Transaksi')
@section('page-title', 'Edit Transaksi')
@section('page-subtitle', 'Ubah data transaksi rental mobil')

@section('content')
    <div class="max-w-7xl mx-auto">
        <!-- Back Button -->
        <div class="mb-6">
            <a href="{{ route('admin.transaksi.show', $transaksi->id) }}"
                class="inline-flex items-center text-sm text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-white">
                <iconify-icon icon="heroicons:arrow-left-20-solid" class="w-4 h-4 mr-2"></iconify-icon>
                Kembali ke Detail Transaksi
            </a>
        </div>

        <!-- Smart Dashboard Layout -->
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6" x-data="editTransactionForm()">
            <!-- Left: Form Sections -->
            <div class="lg:col-span-2 space-y-6">
                <form action="{{ route('admin.transaksi.update', $transaksi->id) }}" method="POST" class="space-y-6">
                    @csrf
                    @method('PUT')

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
                                                {{ old('pelanggan_id', $transaksi->pelanggan_id) == $item->id ? 'selected' : '' }}>
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
                                            {{ old('mobil_id', $transaksi->mobil_id) == $item->id ? 'selected' : '' }}>
                                            {{ $item->merk }} {{ $item->model }} - {{ $item->plat_nomor }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('mobil_id')
                                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Car Info Preview -->
                            <div x-show="selectedCar" x-transition class="p-4 bg-gray-50 dark:bg-gray-700/50 rounded-lg">
                                <div class="grid grid-cols-2 md:grid-cols-4 gap-3 text-sm">
                                    <div class="flex items-center space-x-2">
                                        <iconify-icon icon="heroicons:calendar-20-solid"
                                            class="w-4 h-4 text-gray-500"></iconify-icon>
                                        <div>
                                            <span class="text-gray-600 dark:text-gray-400">Tahun:</span>
                                            <span x-text="carInfo.year"
                                                class="font-medium text-gray-900 dark:text-white ml-1"></span>
                                        </div>
                                    </div>
                                    <div class="flex items-center space-x-2">
                                        <iconify-icon icon="heroicons:swatch-20-solid"
                                            class="w-4 h-4 text-gray-500"></iconify-icon>
                                        <div>
                                            <span class="text-gray-600 dark:text-gray-400">Warna:</span>
                                            <span x-text="carInfo.color"
                                                class="font-medium text-gray-900 dark:text-white ml-1"></span>
                                        </div>
                                    </div>
                                    <div class="flex items-center space-x-2">
                                        <iconify-icon icon="heroicons:users-20-solid"
                                            class="w-4 h-4 text-gray-500"></iconify-icon>
                                        <div>
                                            <span class="text-gray-600 dark:text-gray-400">Kapasitas:</span>
                                            <span x-text="carInfo.capacity"
                                                class="font-medium text-gray-900 dark:text-white ml-1"></span>
                                        </div>
                                    </div>
                                    <div class="flex items-center space-x-2">
                                        <iconify-icon icon="heroicons:cog-6-tooth-20-solid"
                                            class="w-4 h-4 text-gray-500"></iconify-icon>
                                        <div>
                                            <span class="text-gray-600 dark:text-gray-400">Transmisi:</span>
                                            <span x-text="carInfo.transmission"
                                                class="font-medium text-gray-900 dark:text-white ml-1"></span>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Pricing Package Selection -->
                            <div x-show="selectedCar" x-transition>
                                <label for="harga_sewa_id"
                                    class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-3">
                                    <iconify-icon icon="heroicons:tag-20-solid"
                                        class="w-4 h-4 inline mr-1"></iconify-icon>
                                    Paket Sewa *
                                </label>
                                <select name="harga_sewa_id" id="harga_sewa_id" required x-model="selectedPricing"
                                    @change="updateCalculation()"
                                    class="w-full px-4 py-3 bg-white dark:bg-gray-700 border border-gray-300 dark:border-gray-600 rounded-lg text-gray-900 dark:text-white focus:ring-2 focus:ring-indigo-500 dark:focus:ring-indigo-400 focus:border-transparent transition-colors duration-200">
                                    <option value="">-- Pilih Paket Sewa --</option>
                                    @foreach ($hargaSewa as $item)
                                        <option value="{{ $item->id }}" data-harga="{{ $item->harga_per_hari }}"
                                            {{ old('harga_sewa_id', $transaksi->harga_sewa_id) == $item->id ? 'selected' : '' }}>
                                            {{ $item->jenisSewa->nama_jenis }} - Rp
                                            {{ number_format($item->harga_per_hari, 0, ',', '.') }}/hari
                                        </option>
                                    @endforeach
                                </select>
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
                                <div class="w-8 h-8 bg-purple-600 rounded-full flex items-center justify-center">
                                    <iconify-icon icon="heroicons:calendar-days-20-solid"
                                        class="w-4 h-4 text-white"></iconify-icon>
                                </div>
                                <div>
                                    <h3 class="text-lg font-semibold text-gray-900 dark:text-white">Periode Sewa</h3>
                                    <p class="text-sm text-gray-500 dark:text-gray-400">Tentukan tanggal dan durasi sewa
                                    </p>
                                </div>
                            </div>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <!-- Rental Date -->
                            <div>
                                <label for="tanggal_sewa"
                                    class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-3">
                                    <iconify-icon icon="heroicons:calendar-20-solid"
                                        class="w-4 h-4 inline mr-1"></iconify-icon>
                                    Tanggal Mulai Sewa *
                                </label>
                                <input type="date" name="tanggal_sewa" id="tanggal_sewa" required
                                    value="{{ old('tanggal_sewa', $transaksi->tanggal_sewa->format('Y-m-d')) }}"
                                    x-model="rentalDate" @change="updateCalculation()" min="{{ date('Y-m-d') }}"
                                    class="w-full px-4 py-3 bg-white dark:bg-gray-700 border border-gray-300 dark:border-gray-600 rounded-lg text-gray-900 dark:text-white focus:ring-2 focus:ring-indigo-500 dark:focus:ring-indigo-400 focus:border-transparent transition-colors duration-200">
                                @error('tanggal_sewa')
                                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Duration -->
                            <div>
                                <label for="durasi_hari"
                                    class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-3">
                                    <iconify-icon icon="heroicons:clock-20-solid"
                                        class="w-4 h-4 inline mr-1"></iconify-icon>
                                    Durasi Sewa (Hari) *
                                </label>
                                <input type="number" name="durasi_hari" id="durasi_hari" required
                                    value="{{ old('durasi_hari', $transaksi->durasi_hari) }}" x-model.number="duration"
                                    @input="updateCalculation()" min="1" max="30" step="1"
                                    class="w-full px-4 py-3 bg-white dark:bg-gray-700 border border-gray-300 dark:border-gray-600 rounded-lg text-gray-900 dark:text-white focus:ring-2 focus:ring-indigo-500 dark:focus:ring-indigo-400 focus:border-transparent transition-colors duration-200">
                                <input type="hidden" name="tanggal_kembali" :value="getReturnDate()">
                                @error('durasi_hari')
                                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Quick Duration Buttons -->
                            <div class="md:col-span-2">
                                <p class="text-sm text-gray-600 dark:text-gray-400 mb-2">Durasi Populer:</p>
                                <div class="flex flex-wrap gap-2">
                                    <button type="button" @click="setDuration(1)"
                                        class="px-3 py-1 text-sm bg-gray-100 dark:bg-gray-700 hover:bg-indigo-100 dark:hover:bg-indigo-800 text-gray-700 dark:text-gray-300 rounded-lg transition-colors">1
                                        Hari</button>
                                    <button type="button" @click="setDuration(3)"
                                        class="px-3 py-1 text-sm bg-gray-100 dark:bg-gray-700 hover:bg-indigo-100 dark:hover:bg-indigo-800 text-gray-700 dark:text-gray-300 rounded-lg transition-colors">3
                                        Hari</button>
                                    <button type="button" @click="setDuration(7)"
                                        class="px-3 py-1 text-sm bg-gray-100 dark:bg-gray-700 hover:bg-indigo-100 dark:hover:bg-indigo-800 text-gray-700 dark:text-gray-300 rounded-lg transition-colors">1
                                        Minggu</button>
                                    <button type="button" @click="setDuration(14)"
                                        class="px-3 py-1 text-sm bg-gray-100 dark:bg-gray-700 hover:bg-indigo-100 dark:hover:bg-indigo-800 text-gray-700 dark:text-gray-300 rounded-lg transition-colors">2
                                        Minggu</button>
                                    <button type="button" @click="setDuration(30)"
                                        class="px-3 py-1 text-sm bg-gray-100 dark:bg-gray-700 hover:bg-indigo-100 dark:hover:bg-indigo-800 text-gray-700 dark:text-gray-300 rounded-lg transition-colors">1
                                        Bulan</button>
                                </div>
                            </div>

                            <!-- Return Date Display -->
                            <div class="md:col-span-2" x-show="rentalDate && duration">
                                <div
                                    class="p-3 bg-purple-50 dark:bg-purple-900/20 rounded-lg border border-purple-200 dark:border-purple-800">
                                    <div class="flex items-center space-x-2 mb-1">
                                        <iconify-icon icon="heroicons:calendar-20-solid"
                                            class="w-4 h-4 text-purple-600 dark:text-purple-400"></iconify-icon>
                                        <span class="text-sm font-medium text-purple-800 dark:text-purple-200">Tanggal
                                            Pengembalian</span>
                                    </div>
                                    <p x-text="getReturnDate()"
                                        class="text-sm text-purple-700 dark:text-purple-300 font-medium"></p>
                                </div>
                            </div>
                        </div>

                        <!-- Driver Selection -->
                        <div class="mt-6 border-t border-gray-200 dark:border-gray-700 pt-6" x-show="requiresDriver"
                            x-transition>
                            <label for="sopir_id" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-3">
                                <iconify-icon icon="heroicons:user-20-solid" class="w-4 h-4 inline mr-1"></iconify-icon>
                                Pilihan Sopir <span class="text-red-500" x-show="requiresDriver">*</span>
                                <span class="text-gray-500" x-show="!requiresDriver">(Opsional)</span>
                            </label>
                            <div class="space-y-3">
                                <!-- Self Drive Option - only show if driver not required -->
                                <label x-show="!requiresDriver"
                                    class="flex items-center p-3 bg-gray-50 dark:bg-gray-700 rounded-lg cursor-pointer hover:bg-gray-100 dark:hover:bg-gray-600 transition-colors">
                                    <input type="radio" name="sopir_id" value="" x-model="selectedDriver"
                                        @change="updateCalculation()"
                                        {{ old('sopir_id', $transaksi->sopir_id) == '' ? 'checked' : '' }}
                                        class="w-4 h-4 text-indigo-600 border-gray-300 focus:ring-indigo-500 dark:focus:ring-indigo-400">
                                    <div class="ml-3">
                                        <div class="flex items-center space-x-2">
                                            <iconify-icon icon="heroicons:key-20-solid"
                                                class="w-4 h-4 text-gray-600 dark:text-gray-400"></iconify-icon>
                                            <span class="text-sm font-medium text-gray-900 dark:text-white">Self
                                                Drive</span>
                                        </div>
                                        <p class="text-xs text-gray-500 dark:text-gray-400">Anda mengemudi sendiri</p>
                                    </div>
                                </label>

                                <!-- Driver Options -->
                                @foreach ($sopir as $item)
                                    <label
                                        class="flex items-center p-3 bg-gray-50 dark:bg-gray-700 rounded-lg cursor-pointer hover:bg-gray-100 dark:hover:bg-gray-600 transition-colors">
                                        <input type="radio" name="sopir_id" value="{{ $item->id }}"
                                            x-model="selectedDriver" @change="updateCalculation()"
                                            {{ old('sopir_id', $transaksi->sopir_id) == $item->id ? 'checked' : '' }}
                                            :required="requiresDriver"
                                            class="w-4 h-4 text-indigo-600 border-gray-300 focus:ring-indigo-500 dark:focus:ring-indigo-400">
                                        <div class="ml-3 flex-1">
                                            <div class="flex items-center justify-between">
                                                <div class="flex items-center space-x-2">
                                                    <iconify-icon icon="heroicons:user-20-solid"
                                                        class="w-4 h-4 text-gray-600 dark:text-gray-400"></iconify-icon>
                                                    <span
                                                        class="text-sm font-medium text-gray-900 dark:text-white">{{ $item->nama }}</span>
                                                </div>
                                                @if ($item->tarif_per_hari)
                                                    <span class="text-xs text-gray-500 dark:text-gray-400">
                                                        Rp {{ number_format($item->tarif_per_hari, 0, ',', '.') }}/hari
                                                    </span>
                                                @endif
                                            </div>
                                            <div
                                                class="flex items-center space-x-4 text-xs text-gray-500 dark:text-gray-400 mt-1">
                                                <span>{{ $item->telepon }}</span>
                                                @if ($item->pengalaman_tahun)
                                                    <span>{{ $item->pengalaman_tahun }} tahun pengalaman</span>
                                                @endif
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
                            <div class="w-8 h-8 bg-yellow-600 rounded-full flex items-center justify-center">
                                <iconify-icon icon="heroicons:pencil-square-20-solid"
                                    class="w-4 h-4 text-white"></iconify-icon>
                            </div>
                            <h3 class="text-lg font-semibold text-gray-900 dark:text-white">Catatan & Informasi Tambahan
                            </h3>
                        </div>

                        <div>
                            <label for="catatan" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                <iconify-icon icon="heroicons:document-text-20-solid"
                                    class="w-4 h-4 inline mr-1"></iconify-icon>
                                Catatan Khusus (Opsional)
                            </label>
                            <textarea name="catatan" id="catatan" rows="4"
                                class="w-full px-4 py-3 bg-white dark:bg-gray-700 border border-gray-300 dark:border-gray-600 rounded-lg text-gray-900 dark:text-white focus:ring-2 focus:ring-indigo-500 dark:focus:ring-indigo-400 focus:border-transparent transition-colors duration-200 resize-none"
                                placeholder="Contoh: Perubahan keperluan, pickup di bandara, butuh child seat, dll.">{{ old('catatan', $transaksi->catatan) }}</textarea>
                            <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">Informasi ini akan membantu admin dan
                                sopir mempersiapkan layanan yang sesuai</p>
                            @error('catatan')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <!-- Submit Actions -->
                    <div class="flex items-center justify-end space-x-3 pt-6">
                        <a href="{{ route('admin.transaksi.show', $transaksi->id) }}"
                            class="inline-flex items-center px-6 py-3 bg-gray-100 hover:bg-gray-200 dark:bg-gray-700 dark:hover:bg-gray-600 text-gray-700 dark:text-gray-300 text-sm font-medium rounded-xl transition-colors duration-200">
                            <iconify-icon icon="heroicons:x-mark-20-solid" class="w-4 h-4 mr-2"></iconify-icon>
                            Batal
                        </a>
                        <button type="submit" :disabled="!isFormValid()"
                            :class="isFormValid() ? 'bg-indigo-600 hover:bg-indigo-700 text-white' :
                                'bg-gray-300 dark:bg-gray-600 text-gray-500 dark:text-gray-400 cursor-not-allowed'"
                            class="inline-flex items-center px-6 py-3 text-sm font-medium rounded-xl transition-colors duration-200">
                            <iconify-icon icon="heroicons:check-20-solid" class="w-4 h-4 mr-2"></iconify-icon>
                            <span x-text="isFormValid() ? 'Update Transaksi' : 'Lengkapi Data'"></span>
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
                            <div class="flex justify-between items-center p-3 bg-white/60 dark:bg-white/10 rounded-lg">
                                <div>
                                    <span class="text-sm text-gray-600 dark:text-gray-400">Sewa Mobil</span>
                                    <p class="text-xs text-gray-500 dark:text-gray-500"
                                        x-text="duration + ' hari × Rp ' + dailyCarRate.toLocaleString('id-ID')"></p>
                                </div>
                                <span class="font-semibold text-gray-900 dark:text-white"
                                    x-text="'Rp ' + carRentalCost.toLocaleString('id-ID')"></span>
                            </div>

                            <!-- Driver Cost -->
                            <div x-show="driverCost > 0"
                                class="flex justify-between items-center p-3 bg-white/60 dark:bg-white/10 rounded-lg">
                                <div>
                                    <span class="text-sm text-gray-600 dark:text-gray-400">Biaya Sopir</span>
                                    <p class="text-xs text-gray-500 dark:text-gray-500"
                                        x-text="duration + ' hari × Rp ' + dailyDriverRate.toLocaleString('id-ID')"></p>
                                </div>
                                <span class="font-semibold text-gray-900 dark:text-white"
                                    x-text="'Rp ' + driverCost.toLocaleString('id-ID')"></span>
                            </div>

                            <!-- Total Cost -->
                            <div
                                class="flex justify-between items-center p-4 bg-gradient-to-r from-indigo-600 to-purple-600 rounded-lg text-white">
                                <span class="font-semibold">Total Biaya</span>
                                <span class="text-xl font-bold" x-text="'Rp ' + totalCost.toLocaleString('id-ID')"></span>
                            </div>
                        </div>

                        <!-- Current Transaction Info -->
                        <div x-show="!selectedPricing || duration === 0" class="space-y-4">
                            <div class="p-3 bg-white/60 dark:bg-white/10 rounded-lg">
                                <div class="flex justify-between items-center">
                                    <span class="text-sm text-gray-600 dark:text-gray-400">Status Saat Ini</span>
                                    <span
                                        class="px-2 py-1 text-xs rounded-full {{ $statusConfig[$transaksi->status]['bg'] ?? 'bg-gray-100' }} {{ $statusConfig[$transaksi->status]['text'] ?? 'text-gray-800' }}">
                                        {{ $statusConfig[$transaksi->status]['label'] ?? ucfirst($transaksi->status) }}
                                    </span>
                                </div>
                            </div>
                            <div class="p-3 bg-white/60 dark:bg-white/10 rounded-lg">
                                <div class="flex justify-between items-center">
                                    <span class="text-sm text-gray-600 dark:text-gray-400">Total Saat Ini</span>
                                    <span class="font-bold text-gray-900 dark:text-white">Rp
                                        {{ number_format($transaksi->total_biaya, 0, ',', '.') }}</span>
                                </div>
                            </div>
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
                                <div class="flex justify-between py-2 border-b border-gray-100 dark:border-gray-700">
                                    <span class="text-gray-600 dark:text-gray-400">Pelanggan:</span>
                                    <span x-text="customerInfo.name"
                                        class="font-medium text-gray-900 dark:text-white"></span>
                                </div>
                                <div class="flex justify-between py-1 text-xs text-gray-500 dark:text-gray-400">
                                    <span>Telepon:</span>
                                    <span x-text="customerInfo.phone"></span>
                                </div>
                            </div>

                            <!-- Car Info -->
                            <div x-show="selectedCar">
                                <div class="flex justify-between py-2 border-b border-gray-100 dark:border-gray-700">
                                    <span class="text-gray-600 dark:text-gray-400">Kendaraan:</span>
                                    <span x-text="carInfo.brand + ' ' + carInfo.model"
                                        class="font-medium text-gray-900 dark:text-white"></span>
                                </div>
                                <div class="flex justify-between py-1 text-xs text-gray-500 dark:text-gray-400">
                                    <span>Plat Nomor:</span>
                                    <span x-text="carInfo.plat"></span>
                                </div>
                            </div>

                            <!-- Rental Period -->
                            <div x-show="rentalDate && duration > 0">
                                <div class="flex justify-between py-2 border-b border-gray-100 dark:border-gray-700">
                                    <span class="text-gray-600 dark:text-gray-400">Periode:</span>
                                    <span x-text="formatDateRange()"
                                        class="font-medium text-gray-900 dark:text-white"></span>
                                </div>
                                <div class="flex justify-between py-1 text-xs text-gray-500 dark:text-gray-400">
                                    <span>Durasi:</span>
                                    <span x-text="duration + ' hari'"></span>
                                </div>
                            </div>

                            <!-- Driver Info -->
                            <div x-show="selectedDriver">
                                <div class="flex justify-between py-2 border-b border-gray-100 dark:border-gray-700">
                                    <span class="text-gray-600 dark:text-gray-400">Sopir:</span>
                                    <span x-text="getDriverInfo().name"
                                        class="font-medium text-gray-900 dark:text-white"></span>
                                </div>
                            </div>
                        </div>

                        <!-- Validation Status -->
                        <div class="mt-6 pt-4 border-t border-gray-200 dark:border-gray-700">
                            <div class="flex items-center space-x-2">
                                <iconify-icon
                                    :icon="isFormValid() ? 'heroicons:check-circle-20-solid' :
                                        'heroicons:exclamation-circle-20-solid'"
                                    :class="isFormValid() ? 'text-green-500' : 'text-yellow-500'"
                                    class="w-5 h-5"></iconify-icon>
                                <span
                                    :class="isFormValid() ? 'text-green-700 dark:text-green-300' :
                                        'text-yellow-700 dark:text-yellow-300'"
                                    class="text-sm font-medium"
                                    x-text="isFormValid() ? 'Siap untuk diupdate' : 'Lengkapi data yang diperlukan'"></span>
                            </div>
                        </div>
                    </div>

                    <!-- Quick Actions -->
                    <div class="bg-white dark:bg-gray-800 rounded-xl border border-gray-200 dark:border-gray-700 p-6">
                        <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">Aksi Cepat</h3>

                        <div class="space-y-3">
                            <a href="{{ route('admin.transaksi.show', $transaksi->id) }}"
                                class="block w-full text-center py-2 px-4 bg-gray-100 hover:bg-gray-200 dark:bg-gray-700 dark:hover:bg-gray-600 text-gray-700 dark:text-gray-300 rounded-lg transition-colors">
                                <iconify-icon icon="heroicons:eye-20-solid" class="w-4 h-4 inline mr-2"></iconify-icon>
                                Lihat Detail
                            </a>
                            <a href="{{ route('admin.transaksi.payment', $transaksi->id) }}"
                                class="block w-full text-center py-2 px-4 bg-indigo-100 hover:bg-indigo-200 dark:bg-indigo-800 dark:hover:bg-indigo-700 text-indigo-700 dark:text-indigo-300 rounded-lg transition-colors">
                                <iconify-icon icon="heroicons:credit-card-20-solid"
                                    class="w-4 h-4 inline mr-2"></iconify-icon>
                                Kelola Pembayaran
                            </a>
                        </div>
                    </div>

                    <!-- Quick Tips -->
                    <div
                        class="bg-gradient-to-br from-yellow-50 to-orange-50 dark:from-yellow-900/10 dark:to-orange-900/10 rounded-xl border border-yellow-200 dark:border-yellow-800 p-4">
                        <div class="flex items-start space-x-2">
                            <iconify-icon icon="heroicons:light-bulb-20-solid"
                                class="w-5 h-5 text-yellow-600 dark:text-yellow-400 mt-0.5"></iconify-icon>
                            <div>
                                <p class="text-sm font-medium text-yellow-800 dark:text-yellow-200 mb-1">Tips Edit
                                    Transaksi:</p>
                                <ul class="text-xs text-yellow-700 dark:text-yellow-300 space-y-1">
                                    <li>• Hanya transaksi dengan status pending yang dapat diedit</li>
                                    <li>• Perubahan mobil/sopir akan mempengaruhi ketersediaan</li>
                                    <li>• Total biaya akan otomatis dikalkulasi ulang</li>
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
                Alpine.data('editTransactionForm', () => ({
                    // Form Data - Pre-filled with existing transaction data
                    selectedCustomer: '{{ old('pelanggan_id', $transaksi->pelanggan_id) }}',
                    selectedCar: '{{ old('mobil_id', $transaksi->mobil_id) }}',
                    selectedPricing: '{{ old('harga_sewa_id', $transaksi->harga_sewa_id) }}',
                    selectedDriver: '{{ old('sopir_id', $transaksi->sopir_id) }}',
                    rentalDate: '{{ old('tanggal_sewa', $transaksi->tanggal_sewa->format('Y-m-d')) }}',
                    duration: {{ old('durasi_hari', $transaksi->durasi_hari) }},

                    // Data Collections
                    customerInfo: {},
                    carInfo: {},
                    pricingOptions: [],

                    // Calculation Variables
                    dailyCarRate: 0,
                    dailyDriverRate: 0,
                    carRentalCost: 0,
                    driverCost: 0,
                    totalCost: 0,

                    // Driver requirement check
                    requiresDriver: false,

                    // Data from Backend
                    pelangganData: @json($pelanggan->keyBy('id')),
                    mobilData: @json($mobil->keyBy('id')),
                    hargaSewaData: @json($hargaSewa->groupBy('mobil_id')),
                    sopirData: @json($sopir->keyBy('id')),

                    init() {
                        // Initialize with existing transaction values
                        if (this.selectedCustomer) {
                            this.updateCustomerInfo(this.selectedCustomer);
                        }
                        if (this.selectedCar) {
                            this.updateCarInfo(this.selectedCar);
                            this.loadPricingOptions(this.selectedCar);
                        }
                        if (this.selectedPricing && this.duration > 0) {
                            this.updateCalculation();
                        }
                        // Check initial driver requirement
                        this.checkDriverRequirement();
                    },

                    updateCustomerInfo(customerId) {
                        if (customerId && this.pelangganData[customerId]) {
                            const customer = this.pelangganData[customerId];
                            this.customerInfo = {
                                name: customer.nama,
                                phone: customer.telepon,
                                email: customer.email || '-',
                                alamat: customer.alamat || '-',
                                ktp: customer.no_ktp || '-'
                            };
                        }
                    },

                    updateCarInfo(carId) {
                        if (carId && this.mobilData[carId]) {
                            const car = this.mobilData[carId];
                            this.carInfo = {
                                brand: car.merk,
                                model: car.model,
                                plat: car.plat_nomor,
                                year: car.tahun,
                                color: car.warna,
                                capacity: car.kapasitas_penumpang,
                                transmission: car.transmisi || 'Manual',
                                fuel: car.jenis_bahan_bakar || 'Bensin'
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

                        console.log('Car changed - pricing and driver selection reset');
                    },

                    updateCalculation() {
                        this.dailyCarRate = 0;
                        this.dailyDriverRate = 0;
                        this.carRentalCost = 0;
                        this.driverCost = 0;
                        this.totalCost = 0;

                        // Check driver requirement first
                        this.checkDriverRequirement();

                        // Calculate car rental cost
                        if (this.selectedPricing && this.duration > 0) {
                            const pricing = this.pricingOptions.find(p => p.id == this.selectedPricing);
                            if (pricing) {
                                this.dailyCarRate = pricing.harga_per_hari;
                                this.carRentalCost = this.dailyCarRate * this.duration;
                            }
                        }

                        // Calculate driver cost
                        if (this.selectedDriver && this.duration > 0) {
                            const driver = this.sopirData[this.selectedDriver];
                            if (driver && driver.tarif_per_hari) {
                                this.dailyDriverRate = driver.tarif_per_hari;
                                this.driverCost = this.dailyDriverRate * this.duration;
                            }
                        }

                        this.totalCost = this.carRentalCost + this.driverCost;
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
                        this.updateCalculation();
                    },

                    getReturnDate() {
                        if (this.rentalDate && this.duration > 0) {
                            const startDate = new Date(this.rentalDate);
                            const returnDate = new Date(startDate);
                            returnDate.setDate(startDate.getDate() + parseInt(this.duration));
                            return returnDate.toISOString().split('T')[0];
                        }
                        return '';
                    },

                    formatDateRange() {
                        if (this.rentalDate && this.duration > 0) {
                            const startDate = new Date(this.rentalDate);
                            const endDate = new Date(startDate);
                            endDate.setDate(startDate.getDate() + parseInt(this.duration));

                            const formatOptions = {
                                weekday: 'short',
                                year: 'numeric',
                                month: 'short',
                                day: 'numeric'
                            };
                            return `${startDate.toLocaleDateString('id-ID', formatOptions)} - ${endDate.toLocaleDateString('id-ID', formatOptions)}`;
                        }
                        return '';
                    },

                    getDriverInfo() {
                        if (this.selectedDriver && this.sopirData[this.selectedDriver]) {
                            const driver = this.sopirData[this.selectedDriver];
                            return {
                                name: driver.nama,
                                phone: driver.telepon,
                                experience: driver.pengalaman_tahun
                            };
                        }
                        return {
                            name: 'Self Drive',
                            phone: '',
                            experience: ''
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
                    }
                }));
            });
        </script>
    @endpush
@endsection
