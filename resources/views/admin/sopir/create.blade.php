@extends('layouts.admin')

@section('title', 'Tambah Sopir')
@section('page-title', 'Tambah Sopir')
@section('page-subtitle', 'Daftarkan sopir baru ke sistem')

@section('content')
    <div class="max-w-3xl mx-auto">
        <!-- Back Button -->
        <div class="mb-6">
            <a href="{{ route('admin.sopir.index') }}"
                class="inline-flex items-center text-sm text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-white">
                <iconify-icon icon="heroicons:arrow-left-20-solid" class="w-4 h-4 mr-2"></iconify-icon>
                Kembali ke Daftar Sopir
            </a>
        </div>

        <!-- Form Card -->
        <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-sm border border-gray-100 dark:border-gray-700">
            <div class="px-8 py-6 border-b border-gray-200 dark:border-gray-700">
                <div class="flex items-center gap-3">
                    <div class="flex-shrink-0">
                        <div
                            class="w-10 h-10 bg-gradient-to-r from-blue-500 to-indigo-600 rounded-xl flex items-center justify-center">
                            <iconify-icon icon="heroicons:user-plus-20-solid" class="w-5 h-5 text-white"></iconify-icon>
                        </div>
                    </div>
                    <div>
                        <h3 class="text-lg font-semibold text-gray-900 dark:text-white">Tambah Sopir Baru</h3>
                        <p class="text-sm text-gray-600 dark:text-gray-400">Isi formulir untuk mendaftarkan sopir baru</p>
                    </div>
                </div>
            </div>

            <form method="POST" action="{{ route('admin.sopir.store') }}" class="p-8 space-y-6">
                @csrf

                <!-- Personal Information Section -->
                <div class="space-y-6">
                    <h4
                        class="text-md font-medium text-gray-900 dark:text-white border-b border-gray-200 dark:border-gray-700 pb-2">
                        Informasi Sopir
                    </h4>

                    <!-- Nama -->
                    <div>
                        <label for="nama" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                            Nama Lengkap <span class="text-red-500">*</span>
                        </label>
                        <input type="text" id="nama" name="nama" value="{{ old('nama') }}" required
                            class="w-full px-4 py-3 bg-gray-50 dark:bg-gray-700 border border-gray-200 dark:border-gray-600 rounded-xl focus:ring-2 focus:ring-indigo-500 dark:focus:ring-indigo-400 focus:border-transparent @error('nama') !border-red-300 @enderror"
                            placeholder="Masukkan nama lengkap sopir">
                        @error('nama')
                            <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Telepon -->
                    <div>
                        <label for="telepon" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                            Nomor Telepon <span class="text-red-500">*</span>
                        </label>
                        <input type="tel" id="telepon" name="telepon" value="{{ old('telepon') }}" required
                            class="w-full px-4 py-3 bg-gray-50 dark:bg-gray-700 border border-gray-200 dark:border-gray-600 rounded-xl focus:ring-2 focus:ring-indigo-500 dark:focus:ring-indigo-400 focus:border-transparent @error('telepon') !border-red-300 @enderror"
                            placeholder="08xxxxxxxxxx" maxlength="30">
                        @error('telepon')
                            <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Nomor SIM -->
                    <div>
                        <label for="no_sim" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                            Nomor SIM <span class="text-red-500">*</span>
                        </label>
                        <input type="text" id="no_sim" name="no_sim" value="{{ old('no_sim') }}" required
                            class="w-full px-4 py-3 bg-gray-50 dark:bg-gray-700 border border-gray-200 dark:border-gray-600 rounded-xl focus:ring-2 focus:ring-indigo-500 dark:focus:ring-indigo-400 focus:border-transparent @error('no_sim') !border-red-300 @enderror"
                            placeholder="Nomor SIM" maxlength="50">
                        @error('no_sim')
                            <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Status -->
                    <div>
                        <label for="status" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                            Status <span class="text-red-500">*</span>
                        </label>
                        <select id="status" name="status" required
                            class="w-full px-4 py-3 bg-gray-50 dark:bg-gray-700 border border-gray-200 dark:border-gray-600 rounded-xl focus:ring-2 focus:ring-indigo-500 dark:focus:ring-indigo-400 focus:border-transparent @error('status') !border-red-300 @enderror">
                            <option value="">Pilih Status</option>
                            <option value="tersedia" {{ old('status') == 'tersedia' ? 'selected' : '' }}>Tersedia</option>
                            <option value="ditugaskan" {{ old('status') == 'ditugaskan' ? 'selected' : '' }}>Ditugaskan
                            </option>
                            <option value="libur" {{ old('status') == 'libur' ? 'selected' : '' }}>Libur</option>
                        </select>
                        @error('status')
                            <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Catatan -->
                    <div>
                        <label for="catatan" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                            Catatan
                        </label>
                        <textarea id="catatan" name="catatan" rows="3"
                            class="w-full px-4 py-3 bg-gray-50 dark:bg-gray-700 border border-gray-200 dark:border-gray-600 rounded-xl focus:ring-2 focus:ring-indigo-500 dark:focus:ring-indigo-400 focus:border-transparent @error('catatan') !border-red-300 @enderror"
                            placeholder="Catatan tambahan tentang sopir (opsional)">{{ old('catatan') }}</textarea>
                        @error('catatan')
                            <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <!-- Form Actions -->
                <div class="flex flex-col sm:flex-row gap-3 pt-6 border-t border-gray-200 dark:border-gray-700">
                    <button type="submit"
                        class="flex-1 flex items-center sm:flex-none px-6 py-3 bg-gradient-to-r from-blue-500 to-indigo-600 hover:from-blue-600 hover:to-indigo-700 text-white font-medium rounded-xl transition-all duration-200 shadow-lg hover:shadow-xl">
                        <iconify-icon icon="heroicons:check-20-solid" class="w-4 h-4 mr-2 inline"></iconify-icon>
                        Simpan Sopir
                    </button>
                    <a href="{{ route('admin.sopir.index') }}"
                        class="flex-1 flex items-center sm:flex-none px-6 py-3 bg-gray-100 dark:bg-gray-700 hover:bg-gray-200 dark:hover:bg-gray-600 text-gray-700 dark:text-gray-300 font-medium rounded-xl transition-colors duration-200 text-center">
                        <iconify-icon icon="heroicons:x-mark-20-solid" class="w-4 h-4 mr-2 inline"></iconify-icon>
                        Batal
                    </a>
                </div>
            </form>
        </div>
    </div>

    <!-- Form Validation Script -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const simExpired = document.getElementById('sim_expired');
            const today = new Date().toISOString().split('T')[0];

            // Set minimum date to today
            simExpired.min = today;
        });
    </script>
@endsection
