@extends('layouts.admin')

@section('title', 'Edit Sopir')

@section('content')
    <div class="max-w-4xl mx-auto">
        <!-- Header -->
        <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-sm border border-gray-200 dark:border-gray-700 p-6 mb-6">
            <div class="flex items-center justify-between">
                <div>
                    <h1 class="text-2xl font-bold text-gray-900 dark:text-white">Edit Sopir</h1>
                    <p class="text-sm text-gray-600 dark:text-gray-400">Perbarui informasi sopir {{ $sopir->nama }}</p>
                </div>
                <a href="{{ route('admin.sopir.index') }}"
                    class="inline-flex items-center px-4 py-2 bg-gray-500 hover:bg-gray-600 text-white text-sm font-medium rounded-xl transition-colors duration-200">
                    <iconify-icon icon="heroicons:arrow-left-20-solid" class="w-4 h-4 mr-2"></iconify-icon>
                    Kembali
                </a>
            </div>
        </div>

        <!-- Form -->
        <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-sm border border-gray-200 dark:border-gray-700">
            <form method="POST" action="{{ route('admin.sopir.update', $sopir) }}" enctype="multipart/form-data"
                class="p-6">
                @csrf
                @method('PUT')

                <!-- Form Grid -->
                <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                    <!-- Left Column -->
                    <div class="space-y-6">
                        <!-- Personal Information -->
                        <div>
                            <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4 flex items-center">
                                <iconify-icon icon="heroicons:user-20-solid"
                                    class="w-5 h-5 mr-2 text-indigo-600"></iconify-icon>
                                Informasi Personal
                            </h3>

                            <!-- Name -->
                            <div class="mb-4">
                                <label for="nama"
                                    class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                    Nama Lengkap <span class="text-red-500">*</span>
                                </label>
                                <input type="text" name="nama" id="nama" value="{{ old('nama', $sopir->nama) }}"
                                    class="w-full px-4 py-3 rounded-xl border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition-colors duration-200 @error('nama') border-red-500 @enderror"
                                    placeholder="Masukkan nama lengkap sopir" required>
                                @error('nama')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- No KTP -->
                            <div class="mb-4">
                                <label for="no_ktp"
                                    class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                    Nomor KTP <span class="text-red-500">*</span>
                                </label>
                                <input type="text" name="no_ktp" id="no_ktp"
                                    value="{{ old('no_ktp', $sopir->no_ktp) }}"
                                    class="w-full px-4 py-3 rounded-xl border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition-colors duration-200 @error('no_ktp') border-red-500 @enderror"
                                    placeholder="Masukkan nomor KTP (16 digit)" maxlength="16" pattern="[0-9]{16}"
                                    title="KTP harus 16 digit angka" required>
                                @error('no_ktp')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Phone -->
                            <div class="mb-4">
                                <label for="no_telepon"
                                    class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                    Nomor Telepon <span class="text-red-500">*</span>
                                </label>
                                <input type="tel" name="no_telepon" id="no_telepon"
                                    value="{{ old('no_telepon', $sopir->no_telepon) }}"
                                    class="w-full px-4 py-3 rounded-xl border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition-colors duration-200 @error('no_telepon') border-red-500 @enderror"
                                    placeholder="Masukkan nomor telepon aktif" required>
                                @error('no_telepon')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Address -->
                            <div class="mb-4">
                                <label for="alamat"
                                    class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                    Alamat <span class="text-red-500">*</span>
                                </label>
                                <textarea name="alamat" id="alamat" rows="3"
                                    class="w-full px-4 py-3 rounded-xl border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition-colors duration-200 @error('alamat') border-red-500 @enderror"
                                    placeholder="Masukkan alamat lengkap" required>{{ old('alamat', $sopir->alamat) }}</textarea>
                                @error('alamat')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <!-- Right Column -->
                    <div class="space-y-6">
                        <!-- License Information -->
                        <div>
                            <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4 flex items-center">
                                <iconify-icon icon="heroicons:identification-20-solid"
                                    class="w-5 h-5 mr-2 text-indigo-600"></iconify-icon>
                                Informasi SIM
                            </h3>

                            <!-- License Number -->
                            <div class="mb-4">
                                <label for="no_sim"
                                    class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                    Nomor SIM <span class="text-red-500">*</span>
                                </label>
                                <input type="text" name="no_sim" id="no_sim"
                                    value="{{ old('no_sim', $sopir->no_sim) }}"
                                    class="w-full px-4 py-3 rounded-xl border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition-colors duration-200 @error('no_sim') border-red-500 @enderror"
                                    placeholder="Masukkan nomor SIM" required>
                                @error('no_sim')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Expired Date -->
                            <div class="mb-4">
                                <label for="masa_berlaku_sim"
                                    class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                    Masa Berlaku SIM <span class="text-red-500">*</span>
                                </label>
                                <input type="date" name="masa_berlaku_sim" id="masa_berlaku_sim"
                                    value="{{ old('masa_berlaku_sim', $sopir->masa_berlaku_sim?->format('Y-m-d')) }}"
                                    min="{{ date('Y-m-d') }}"
                                    class="w-full px-4 py-3 rounded-xl border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition-colors duration-200 @error('masa_berlaku_sim') border-red-500 @enderror"
                                    required>
                                @error('masa_berlaku_sim')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Status -->
                            <div class="mb-4">
                                <label for="status"
                                    class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                    Status <span class="text-red-500">*</span>
                                </label>
                                <select name="status" id="status"
                                    class="w-full px-4 py-3 rounded-xl border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition-colors duration-200 @error('status') border-red-500 @enderror"
                                    required>
                                    <option value="">Pilih Status</option>
                                    <option value="tersedia"
                                        {{ old('status', $sopir->status) === 'tersedia' ? 'selected' : '' }}>Tersedia
                                    </option>
                                    <option value="ditugaskan"
                                        {{ old('status', $sopir->status) === 'ditugaskan' ? 'selected' : '' }}>Ditugaskan
                                    </option>
                                    <option value="libur"
                                        {{ old('status', $sopir->status) === 'libur' ? 'selected' : '' }}>Libur</option>
                                </select>
                                @error('status')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <!-- Photo Upload -->
                        <div>
                            <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4 flex items-center">
                                <iconify-icon icon="heroicons:camera-20-solid"
                                    class="w-5 h-5 mr-2 text-indigo-600"></iconify-icon>
                                Foto Sopir
                            </h3>

                            <!-- Current Photo -->
                            @if ($sopir->foto)
                                <div class="mb-4">
                                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                        Foto Saat Ini
                                    </label>
                                    <div class="w-32 h-32 rounded-xl overflow-hidden bg-gray-100 dark:bg-gray-700">
                                        <img src="{{ Storage::url($sopir->foto) }}" alt="Foto {{ $sopir->nama }}"
                                            class="w-full h-full object-cover">
                                    </div>
                                </div>
                            @endif

                            <div class="mb-4">
                                <label for="foto"
                                    class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                    {{ $sopir->foto ? 'Ganti Foto' : 'Upload Foto' }} (Optional)
                                </label>
                                <input type="file" name="foto" id="foto" accept="image/*"
                                    class="w-full px-4 py-3 rounded-xl border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition-colors duration-200 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-semibold file:bg-indigo-50 file:text-indigo-700 hover:file:bg-indigo-100 @error('foto') border-red-500 @enderror">
                                <p class="mt-1 text-sm text-gray-500">Format: JPG, JPEG, PNG. Maksimal 2MB.</p>
                                @error('foto')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Photo Preview -->
                            <div id="photo-preview" class="hidden">
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                    Preview Foto Baru
                                </label>
                                <img id="preview-img"
                                    class="w-32 h-32 object-cover rounded-xl border border-gray-300 dark:border-gray-600">
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Submit Buttons -->
                <div class="flex items-center justify-end space-x-3 pt-6 border-t border-gray-200 dark:border-gray-700">
                    <a href="{{ route('admin.sopir.index') }}"
                        class="px-6 py-2 bg-gray-500 hover:bg-gray-600 text-white text-sm font-medium rounded-xl transition-colors duration-200">
                        Batal
                    </a>
                    <button type="submit"
                        class="px-6 py-2 flex items-center bg-indigo-600 hover:bg-indigo-700 text-white text-sm font-medium rounded-xl transition-colors duration-200">
                        <iconify-icon icon="heroicons:check-20-solid" class="w-4 h-4 mr-2 inline-block"></iconify-icon>
                        Perbarui Sopir
                    </button>
                </div>
            </form>
        </div>
    </div>

    @push('scripts')
        <script>
            // Photo preview functionality
            document.getElementById('foto').addEventListener('change', function(e) {
                const file = e.target.files[0];
                const preview = document.getElementById('photo-preview');
                const previewImg = document.getElementById('preview-img');

                if (file) {
                    const reader = new FileReader();
                    reader.onload = function(e) {
                        previewImg.src = e.target.result;
                        preview.classList.remove('hidden');
                    };
                    reader.readAsDataURL(file);
                } else {
                    preview.classList.add('hidden');
                }
            });

            // KTP number formatting
            document.getElementById('no_ktp').addEventListener('input', function(e) {
                // Remove non-numeric characters
                let value = e.target.value.replace(/\D/g, '');
                // Limit to 16 digits
                value = value.substring(0, 16);
                e.target.value = value;
            });

            // Phone number formatting
            document.getElementById('no_telepon').addEventListener('input', function(e) {
                let value = e.target.value.replace(/\D/g, '');
                if (value.startsWith('0')) {
                    // Format: 0xxx-xxxx-xxxx
                    if (value.length > 4 && value.length <= 8) {
                        value = value.replace(/(\d{4})(\d+)/, '$1-$2');
                    } else if (value.length > 8) {
                        value = value.replace(/(\d{4})(\d{4})(\d+)/, '$1-$2-$3');
                    }
                }
                e.target.value = value;
            });
        </script>
    @endpush
@endsection
