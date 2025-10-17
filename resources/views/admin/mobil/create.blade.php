@extends('layouts.admin')

@section('title', 'Tambah Mobil Baru')
@section('page-title', 'Tambah Mobil Baru')
@section('page-subtitle', 'Tambahkan kendaraan baru ke armada sewa')

@section('content')
    <div class="max-w-4xl mx-auto">
        <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-sm border border-gray-100 dark:border-gray-700">
            <!-- Header -->
            <div class="px-6 py-4 border-b border-gray-200 dark:border-gray-700">
                <div class="flex items-center justify-between">
                    <h3 class="text-lg font-semibold text-gray-800 dark:text-white">Informasi Mobil</h3>
                    <a href="{{ route('admin.mobil.index') }}"
                        class="inline-flex items-center px-4 py-2 bg-gray-500 hover:bg-gray-600 text-white text-sm font-medium rounded-xl transition-colors duration-200">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                        </svg>
                        Kembali ke Daftar Mobil
                    </a>
                </div>
            </div>

            @if ($errors->any())
                <div class="px-6 py-4 border-b border-gray-200 dark:border-gray-700">
                    <div class="mb-4 bg-red-50 dark:bg-red-900/50 border border-red-200 dark:border-red-800 text-red-700 dark:text-red-300 px-4 py-3 rounded-xl"
                        x-data="{ show: true }" x-show="show" x-transition>
                        <div class="flex items-center justify-between">
                            <div class="flex items-center">
                                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M6 18L18 6M6 6l12 12" />
                                </svg>
                                <div>
                                    <strong class="font-medium">Terjadi kesalahan:</strong>
                                    <ul class="mt-1 list-disc list-inside">
                                        @foreach ($errors->all() as $error)
                                            <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            </div>
                            <button @click="show = false" class="text-red-500 hover:text-red-700">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M6 18L18 6M6 6l12 12" />
                                </svg>
                            </button>
                        </div>
                    </div>
                </div>
            @endif
            <!-- Form -->
            <form action="{{ route('admin.mobil.store') }}" method="POST" enctype="multipart/form-data" class="p-6">
                @csrf

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Informasi Dasar -->
                    <div class="space-y-6">
                        <h4
                            class="text-md font-semibold text-gray-800 dark:text-white border-b border-gray-200 dark:border-gray-700 pb-2">
                            <i class="fas fa-car mr-2 text-indigo-500"></i>Informasi Dasar
                        </h4>

                        <!-- Nama Mobil -->
                        <div>
                            <label for="nama_mobil"
                                class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Nama Mobil *</label>
                            <input type="text" name="nama_mobil" id="nama_mobil" value="{{ old('nama_mobil') }}" required
                                class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-xl focus:ring-2 focus:ring-indigo-500 dark:focus:ring-indigo-400 focus:border-transparent bg-white dark:bg-gray-700 text-gray-900 dark:text-white"
                                placeholder="Contoh: Toyota Avanza G">
                            @error('nama_mobil')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Merek -->
                        <div>
                            <label for="merk"
                                class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Merek *</label>
                            <input type="text" name="merk" id="merk" value="{{ old('merk') }}" required
                                class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-xl focus:ring-2 focus:ring-indigo-500 dark:focus:ring-indigo-400 focus:border-transparent bg-white dark:bg-gray-700 text-gray-900 dark:text-white"
                                placeholder="Contoh: Toyota, Honda, Suzuki">
                            @error('merk')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Model -->
                        <div>
                            <label for="model"
                                class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Model *</label>
                            <input type="text" name="model" id="model" value="{{ old('model') }}" required
                                class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-xl focus:ring-2 focus:ring-indigo-500 dark:focus:ring-indigo-400 focus:border-transparent bg-white dark:bg-gray-700 text-gray-900 dark:text-white"
                                placeholder="Contoh: Avanza, Jazz, Xpander">
                            @error('model')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Tahun -->
                        <div>
                            <label for="tahun"
                                class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Tahun *</label>
                            <input type="number" name="tahun" id="tahun" value="{{ old('tahun') }}" required
                                min="1990" max="{{ date('Y') + 1 }}"
                                class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-xl focus:ring-2 focus:ring-indigo-500 dark:focus:ring-indigo-400 focus:border-transparent bg-white dark:bg-gray-700 text-gray-900 dark:text-white"
                                placeholder="2023">
                            @error('tahun')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Plat Nomor -->
                        <div>
                            <label for="plat_nomor"
                                class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Plat Nomor *</label>
                            <input type="text" name="plat_nomor" id="plat_nomor" value="{{ old('plat_nomor') }}"
                                required
                                class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-xl focus:ring-2 focus:ring-indigo-500 dark:focus:ring-indigo-400 focus:border-transparent bg-white dark:bg-gray-700 text-gray-900 dark:text-white"
                                placeholder="Contoh: B 1234 XYZ">
                            @error('plat_nomor')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Warna -->
                        <div>
                            <label for="warna"
                                class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Warna *</label>
                            <input type="text" name="warna" id="warna" value="{{ old('warna') }}" required
                                class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-xl focus:ring-2 focus:ring-indigo-500 dark:focus:ring-indigo-400 focus:border-transparent bg-white dark:bg-gray-700 text-gray-900 dark:text-white"
                                placeholder="Contoh: Putih, Hitam, Silver">
                            @error('warna')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <!-- Spesifikasi Teknis -->
                    <div class="space-y-6">
                        <h4
                            class="text-md font-semibold text-gray-800 dark:text-white border-b border-gray-200 dark:border-gray-700 pb-2">
                            <i class="fas fa-cogs mr-2 text-indigo-500"></i>Spesifikasi Teknis
                        </h4>

                        <!-- Kapasitas Penumpang -->
                        <div>
                            <label for="kapasitas_penumpang"
                                class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Kapasitas Penumpang
                                *</label>
                            <input type="number" name="kapasitas_penumpang" id="kapasitas_penumpang"
                                value="{{ old('kapasitas_penumpang') }}" required min="1" max="50"
                                class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-xl focus:ring-2 focus:ring-indigo-500 dark:focus:ring-indigo-400 focus:border-transparent bg-white dark:bg-gray-700 text-gray-900 dark:text-white"
                                placeholder="Contoh: 7">
                            @error('kapasitas_penumpang')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Transmisi -->
                        <div>
                            <label for="transmisi"
                                class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Transmisi *</label>
                            <select name="transmisi" id="transmisi" required
                                class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-xl focus:ring-2 focus:ring-indigo-500 dark:focus:ring-indigo-400 focus:border-transparent bg-white dark:bg-gray-700 text-gray-900 dark:text-white">
                                <option value="">Pilih Transmisi</option>
                                <option value="manual" {{ old('transmisi') == 'manual' ? 'selected' : '' }}>Manual
                                </option>
                                <option value="automatic" {{ old('transmisi') == 'automatic' ? 'selected' : '' }}>Otomatis
                                </option>
                                <option value="cvt" {{ old('transmisi') == 'cvt' ? 'selected' : '' }}>CVT</option>
                            </select>
                            @error('transmisi')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Jenis Bahan Bakar -->
                        <div>
                            <label for="jenis_bahan_bakar"
                                class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Jenis Bahan Bakar
                                *</label>
                            <select name="jenis_bahan_bakar" id="jenis_bahan_bakar" required
                                class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-xl focus:ring-2 focus:ring-indigo-500 dark:focus:ring-indigo-400 focus:border-transparent bg-white dark:bg-gray-700 text-gray-900 dark:text-white">
                                <option value="">Pilih Jenis Bahan Bakar</option>
                                <option value="bensin" {{ old('jenis_bahan_bakar') == 'bensin' ? 'selected' : '' }}>Bensin
                                </option>
                                <option value="diesel" {{ old('jenis_bahan_bakar') == 'diesel' ? 'selected' : '' }}>Diesel
                                </option>
                                <option value="hybrid" {{ old('jenis_bahan_bakar') == 'hybrid' ? 'selected' : '' }}>Hybrid
                                </option>
                                <option value="listrik" {{ old('jenis_bahan_bakar') == 'listrik' ? 'selected' : '' }}>
                                    Listrik</option>
                            </select>
                            @error('jenis_bahan_bakar')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Status -->
                        <div>
                            <label for="status"
                                class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Status *</label>
                            <select name="status" id="status" required
                                class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-xl focus:ring-2 focus:ring-indigo-500 dark:focus:ring-indigo-400 focus:border-transparent bg-white dark:bg-gray-700 text-gray-900 dark:text-white">
                                <option value="">Pilih Status</option>
                                <option value="tersedia" {{ old('status') == 'tersedia' ? 'selected' : '' }}>Tersedia
                                </option>
                                <option value="disewa" {{ old('status') == 'disewa' ? 'selected' : '' }}>Disewa</option>
                                <option value="perawatan" {{ old('status') == 'perawatan' ? 'selected' : '' }}>Perawatan
                                </option>
                                <option value="nonaktif" {{ old('status') == 'nonaktif' ? 'selected' : '' }}>Non Aktif
                                </option>
                            </select>
                            @error('status')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Foto -->
                        <div>
                            <label for="foto"
                                class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Foto Mobil</label>
                            <input type="file" name="foto" id="foto" accept="image/*"
                                class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-xl focus:ring-2 focus:ring-indigo-500 dark:focus:ring-indigo-400 focus:border-transparent bg-white dark:bg-gray-700 text-gray-900 dark:text-white">
                            @error('foto')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                            <p class="mt-1 text-xs text-gray-500 dark:text-gray-400">Maksimal ukuran file: 2MB. Format yang
                                didukung: JPG, PNG</p>
                        </div>
                    </div>
                </div>

                <!-- Tombol Submit -->
                <div
                    class="flex items-center justify-end space-x-3 mt-8 pt-6 border-t border-gray-200 dark:border-gray-700">
                    <a href="{{ route('admin.mobil.index') }}"
                        class="px-6 py-2 bg-gray-500 hover:bg-gray-600 text-white font-medium rounded-xl transition-colors duration-200">
                        Batal
                    </a>
                    <button type="submit"
                        class="px-6 py-2 bg-indigo-600 hover:bg-indigo-700 text-white font-medium rounded-xl transition-colors duration-200">
                        Simpan Mobil
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection
