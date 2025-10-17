@extends('layouts.admin')

@section('title', 'Edit Pelanggan')

@section('content')
    <div class="max-w-4xl mx-auto">
        <!-- Header -->
        <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-sm border border-gray-200 dark:border-gray-700 p-6 mb-6">
            <div class="flex items-center justify-between">
                <div>
                    <h1 class="text-2xl font-bold text-gray-900 dark:text-white">Edit Pelanggan</h1>
                    <p class="text-sm text-gray-600 dark:text-gray-400">Perbarui informasi pelanggan {{ $pelanggan->nama }}
                    </p>
                </div>
                <a href="{{ route('admin.pelanggan.index') }}"
                    class="inline-flex items-center px-4 py-2 bg-gray-500 hover:bg-gray-600 text-white text-sm font-medium rounded-xl transition-colors duration-200">
                    <iconify-icon icon="heroicons:arrow-left-20-solid" class="w-4 h-4 mr-2"></iconify-icon>
                    Kembali
                </a>
            </div>
        </div>

        <!-- Form -->
        <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-sm border border-gray-200 dark:border-gray-700">
            <form method="POST" action="{{ route('admin.pelanggan.update', $pelanggan) }}" class="p-6">
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
                                <input type="text" name="nama" id="nama"
                                    value="{{ old('nama', $pelanggan->nama) }}"
                                    class="w-full px-4 py-3 rounded-xl border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition-colors duration-200 @error('nama') border-red-500 @enderror"
                                    placeholder="Masukkan nama lengkap" required>
                                @error('nama')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Email -->
                            <div class="mb-4">
                                <label for="email"
                                    class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                    Email <span class="text-red-500">*</span>
                                </label>
                                <input type="email" name="email" id="email"
                                    value="{{ old('email', $pelanggan->email) }}"
                                    class="w-full px-4 py-3 rounded-xl border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition-colors duration-200 @error('email') border-red-500 @enderror"
                                    placeholder="Masukkan alamat email" required>
                                @error('email')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Phone -->
                            <div class="mb-4">
                                <label for="telepon"
                                    class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                    Nomor Telepon <span class="text-red-500">*</span>
                                </label>
                                <input type="tel" name="telepon" id="telepon"
                                    value="{{ old('telepon', $pelanggan->telepon) }}"
                                    class="w-full px-4 py-3 rounded-xl border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition-colors duration-200 @error('telepon') border-red-500 @enderror"
                                    placeholder="Masukkan nomor telepon" required>
                                @error('telepon')
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
                                    placeholder="Masukkan alamat lengkap" required>{{ old('alamat', $pelanggan->alamat) }}</textarea>
                                @error('alamat')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <!-- Right Column -->
                    <div class="space-y-6">
                        <!-- Identity Information -->
                        <div>
                            <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4 flex items-center">
                                <iconify-icon icon="heroicons:identification-20-solid"
                                    class="w-5 h-5 mr-2 text-indigo-600"></iconify-icon>
                                Informasi Identitas
                            </h3>

                            <!-- KTP Number -->
                            <div class="mb-4">
                                <label for="no_ktp"
                                    class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                    Nomor KTP <span class="text-red-500">*</span>
                                </label>
                                <input type="text" name="no_ktp" id="no_ktp"
                                    value="{{ old('no_ktp', $pelanggan->no_ktp) }}"
                                    class="w-full px-4 py-3 rounded-xl border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition-colors duration-200 @error('no_ktp') border-red-500 @enderror"
                                    placeholder="Masukkan nomor KTP (16 digit)" maxlength="16" pattern="[0-9]{16}"
                                    title="KTP harus 16 digit angka" required>
                                @error('no_ktp')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- SIM Number -->
                            <div class="mb-4">
                                <label for="no_sim"
                                    class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                    Nomor SIM <span class="text-red-500">*</span>
                                </label>
                                <input type="text" name="no_sim" id="no_sim"
                                    value="{{ old('no_sim', $pelanggan->no_sim) }}"
                                    class="w-full px-4 py-3 rounded-xl border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition-colors duration-200 @error('no_sim') border-red-500 @enderror"
                                    placeholder="Masukkan nomor SIM" required>
                                @error('no_sim')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Birth Date -->
                            <div class="mb-4">
                                <label for="tanggal_lahir"
                                    class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                    Tanggal Lahir <span class="text-red-500">*</span>
                                </label>
                                <input type="date" name="tanggal_lahir" id="tanggal_lahir"
                                    value="{{ old('tanggal_lahir', $pelanggan->tanggal_lahir?->format('Y-m-d')) }}"
                                    max="{{ date('Y-m-d', strtotime('-17 years')) }}"
                                    class="w-full px-4 py-3 rounded-xl border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition-colors duration-200 @error('tanggal_lahir') border-red-500 @enderror"
                                    required>
                                @error('tanggal_lahir')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                                <p class="mt-1 text-xs text-gray-500">Minimal umur 17 tahun</p>
                            </div>

                            <!-- Gender -->
                            <div class="mb-4">
                                <label for="jenis_kelamin"
                                    class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                    Jenis Kelamin <span class="text-red-500">*</span>
                                </label>
                                <select name="jenis_kelamin" id="jenis_kelamin"
                                    class="w-full px-4 py-3 rounded-xl border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition-colors duration-200 @error('jenis_kelamin') border-red-500 @enderror"
                                    required>
                                    <option value="">Pilih Jenis Kelamin</option>
                                    <option value="L"
                                        {{ old('jenis_kelamin', $pelanggan->jenis_kelamin) === 'L' ? 'selected' : '' }}>
                                        Laki-laki</option>
                                    <option value="P"
                                        {{ old('jenis_kelamin', $pelanggan->jenis_kelamin) === 'P' ? 'selected' : '' }}>
                                        Perempuan</option>
                                </select>
                                @error('jenis_kelamin')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Submit Buttons -->
                <div class="flex items-center justify-end space-x-3 pt-6 border-t border-gray-200 dark:border-gray-700">
                    <a href="{{ route('admin.pelanggan.index') }}"
                        class="px-6 py-2 bg-gray-500 hover:bg-gray-600 text-white text-sm font-medium rounded-xl transition-colors duration-200">
                        Batal
                    </a>
                    <button type="submit"
                        class="px-6 py-2 bg-indigo-600 hover:bg-indigo-700 text-white text-sm font-medium rounded-xl transition-colors duration-200">
                        <iconify-icon icon="heroicons:check-20-solid" class="w-4 h-4 mr-2 inline-block"></iconify-icon>
                        Perbarui Pelanggan
                    </button>
                </div>
            </form>
        </div>
    </div>

    @push('scripts')
        <script>
            // KTP number formatting
            document.getElementById('no_ktp').addEventListener('input', function(e) {
                // Remove non-numeric characters
                let value = e.target.value.replace(/\D/g, '');
                // Limit to 16 digits
                value = value.substring(0, 16);
                e.target.value = value;
            });

            // Phone number formatting
            document.getElementById('telepon').addEventListener('input', function(e) {
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

            // Age validation
            document.getElementById('tanggal_lahir').addEventListener('change', function(e) {
                const birthDate = new Date(e.target.value);
                const today = new Date();
                const age = today.getFullYear() - birthDate.getFullYear();
                const monthDiff = today.getMonth() - birthDate.getMonth();

                if (monthDiff < 0 || (monthDiff === 0 && today.getDate() < birthDate.getDate())) {
                    age--;
                }

                if (age < 17) {
                    alert('Pelanggan harus berusia minimal 17 tahun');
                    e.target.value = '';
                }
            });
        </script>
    @endpush
@endsection
