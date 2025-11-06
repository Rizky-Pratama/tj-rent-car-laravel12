@extends('layouts.admin')

@section('title', 'Tambah Jenis Sewa')

@section('content')
    <div class="max-w-3xl mx-auto">
        <!-- Header -->
        <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-sm border border-gray-200 dark:border-gray-700 p-6 mb-6">
            <div class="flex items-center justify-between">
                <div>
                    <h1 class="text-2xl font-bold text-gray-900 dark:text-white">Tambah Jenis Sewa</h1>
                    <p class="text-sm text-gray-600 dark:text-gray-400">Buat template layanan rental baru</p>
                </div>
                <a href="{{ route('admin.jenis-sewa.index') }}"
                    class="inline-flex items-center px-4 py-2 bg-gray-500 hover:bg-gray-600 text-white text-sm font-medium rounded-xl transition-colors duration-200">
                    <iconify-icon icon="heroicons:arrow-left-20-solid" class="w-4 h-4 mr-2"></iconify-icon>
                    Kembali
                </a>
            </div>
        </div>

        <!-- Form -->
        <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-sm border border-gray-200 dark:border-gray-700">
            <form method="POST" action="{{ route('admin.jenis-sewa.store') }}" class="p-6">
                @csrf

                <div class="space-y-6">
                    <!-- Basic Information -->
                    <div>
                        <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4 flex items-center">
                            <iconify-icon icon="heroicons:document-text-20-solid"
                                class="w-5 h-5 mr-2 text-indigo-600"></iconify-icon>
                            Informasi Dasar
                        </h3>

                        <!-- Nama Jenis -->
                        <div class="mb-4">
                            <label for="nama_jenis" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                Nama Jenis Sewa <span class="text-red-500">*</span>
                            </label>
                            <input type="text" name="nama_jenis" id="nama_jenis" value="{{ old('nama_jenis') }}"
                                class="w-full px-4 py-3 rounded-xl border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition-colors duration-200 @error('nama_jenis') border-red-500 @enderror"
                                placeholder="Contoh: Harian, Mingguan, Bulanan, Luar Kota" required>
                            @error('nama_jenis')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                            <p class="mt-1 text-xs text-gray-500">Nama jenis sewa harus unik dan deskriptif</p>
                        </div>

                        <!-- Deskripsi -->
                        <div class="mb-4">
                            <label for="deskripsi" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                Deskripsi
                            </label>
                            <textarea name="deskripsi" id="deskripsi" rows="4"
                                class="w-full px-4 py-3 rounded-xl border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition-colors duration-200 @error('deskripsi') border-red-500 @enderror"
                                placeholder="Jelaskan detail tentang jenis sewa ini, ketentuan khusus, atau informasi penting lainnya...">{{ old('deskripsi') }}</textarea>
                            @error('deskripsi')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <!-- Penalty Settings -->
                    <div>
                        <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4 flex items-center">
                            <iconify-icon icon="heroicons:exclamation-triangle-20-solid"
                                class="w-5 h-5 mr-2 text-orange-600"></iconify-icon>
                            Pengaturan Denda
                        </h3>

                        <div
                            class="bg-orange-50 dark:bg-orange-900/20 border border-orange-200 dark:border-orange-800 rounded-xl p-4 mb-4">
                            <div class="flex items-start">
                                <iconify-icon icon="heroicons:information-circle-20-solid"
                                    class="w-5 h-5 text-orange-600 dark:text-orange-400 mt-0.5 mr-3"></iconify-icon>
                                <div class="text-sm text-orange-700 dark:text-orange-300">
                                    <p class="font-medium mb-1">Tentang Tarif Denda:</p>
                                    <p>Tarif denda per hari akan dikenakan untuk keterlambatan pengembalian mobil. Kosongkan
                                        jika tidak ada denda untuk jenis sewa ini.</p>
                                </div>
                            </div>
                        </div>

                        <!-- Tarif Denda -->
                        <div class="mb-4">
                            <label for="tarif_denda_per_hari"
                                class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                Tarif Denda per Hari (Rp)
                            </label>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <span class="text-gray-500 dark:text-gray-400 sm:text-sm">Rp</span>
                                </div>
                                <input type="number" name="tarif_denda_per_hari" id="tarif_denda_per_hari"
                                    value="{{ old('tarif_denda_per_hari') }}" min="0" step="1000"
                                    class="w-full pl-12 pr-4 py-3 rounded-xl border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition-colors duration-200 @error('tarif_denda_per_hari') border-red-500 @enderror"
                                    placeholder="50000">
                            </div>
                            @error('tarif_denda_per_hari')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                            <p class="mt-1 text-xs text-gray-500">Kosongkan jika tidak ada denda untuk jenis sewa ini</p>
                        </div>
                    </div>

                    <!-- Preview Section -->
                    <div class="bg-gray-50 dark:bg-gray-700/50 rounded-xl p-4">
                        <h4 class="text-sm font-medium text-gray-900 dark:text-white mb-3 flex items-center">
                            <iconify-icon icon="heroicons:eye-20-solid"
                                class="w-4 h-4 mr-2 text-gray-600 dark:text-gray-400"></iconify-icon>
                            Preview
                        </h4>
                        <div class="space-y-2 text-sm">
                            <div class="flex justify-between">
                                <span class="text-gray-600 dark:text-gray-400">Nama Jenis:</span>
                                <span class="font-medium text-gray-900 dark:text-white" id="preview-nama">-</span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-gray-600 dark:text-gray-400">Slug:</span>
                                <span class="font-mono text-gray-900 dark:text-white" id="preview-slug">-</span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-gray-600 dark:text-gray-400">Denda:</span>
                                <span class="font-medium text-gray-900 dark:text-white" id="preview-denda">-</span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Submit Buttons -->
                <div
                    class="flex items-center justify-end space-x-3 pt-6 border-t border-gray-200 dark:border-gray-700 mt-6">
                    <a href="{{ route('admin.jenis-sewa.index') }}"
                        class="px-6 py-2 bg-gray-500 hover:bg-gray-600 text-white text-sm font-medium rounded-xl transition-colors duration-200">
                        Batal
                    </a>
                    <button type="submit"
                        class="px-6 py-2 flex items-center bg-indigo-600 hover:bg-indigo-700 text-white text-sm font-medium rounded-xl transition-colors duration-200">
                        <iconify-icon icon="heroicons:check-20-solid" class="w-4 h-4 mr-2 inline-block"></iconify-icon>
                        Simpan Jenis Sewa
                    </button>
                </div>
            </form>
        </div>
    </div>

    @push('scripts')
        <script>
            function generateSlug(text) {
                return text
                    .toLowerCase()
                    .replace(/[^\w\s-]/g, '')
                    .replace(/\s+/g, '-')
                    .replace(/-+/g, '-')
                    .trim();
            }

            function formatRupiah(value) {
                if (!value) return 'Tanpa Denda';
                return 'Rp ' + new Intl.NumberFormat('id-ID').format(value) + '/hari';
            }

            // Live preview updates
            document.getElementById('nama_jenis').addEventListener('input', function(e) {
                const nama = e.target.value;
                const slug = generateSlug(nama);

                document.getElementById('preview-nama').textContent = nama || '-';
                document.getElementById('preview-slug').textContent = slug || '-';
            });

            document.getElementById('tarif_denda_per_hari').addEventListener('input', function(e) {
                const denda = e.target.value;
                document.getElementById('preview-denda').textContent = formatRupiah(denda);
            });

            // Format input number
            document.getElementById('tarif_denda_per_hari').addEventListener('input', function(e) {
                let value = e.target.value.replace(/\D/g, '');
                e.target.value = value;
            });

            // Initial preview
            document.addEventListener('DOMContentLoaded', function() {
                const namaInput = document.getElementById('nama_jenis');
                const dendaInput = document.getElementById('tarif_denda_per_hari');

                if (namaInput.value) {
                    document.getElementById('preview-nama').textContent = namaInput.value;
                    document.getElementById('preview-slug').textContent = generateSlug(namaInput.value);
                }

                if (dendaInput.value) {
                    document.getElementById('preview-denda').textContent = formatRupiah(dendaInput.value);
                }
            });
        </script>
    @endpush
@endsection
