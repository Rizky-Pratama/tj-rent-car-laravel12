@extends('layouts.admin')

@section('title', 'Edit Pengguna')
@section('page-title', 'Edit Pengguna')
@section('page-subtitle', 'Perbarui informasi pengguna')

@section('content')
    <div class="max-w-4xl mx-auto">
        <!-- Header -->
        <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-sm border border-gray-200 dark:border-gray-700 p-6 mb-6">
            <div class="flex items-center justify-between">
                <div>
                    <h1 class="text-2xl font-bold text-gray-900 dark:text-white">Edit Pengguna</h1>
                    <p class="text-sm text-gray-600 dark:text-gray-400">Perbarui informasi pengguna {{ $user->nama }}</p>
                </div>
                <a href="{{ route('admin.users.index') }}"
                    class="inline-flex items-center px-4 py-2 bg-gray-500 hover:bg-gray-600 text-white text-sm font-medium rounded-xl transition-colors duration-200">
                    <iconify-icon icon="heroicons:arrow-left-20-solid" class="w-4 h-4 mr-2"></iconify-icon>
                    Kembali
                </a>
            </div>
        </div>

        <!-- Form -->
        <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-sm border border-gray-200 dark:border-gray-700">
            <form method="POST" action="{{ route('admin.users.update', $user) }}" class="p-6">
                @csrf
                @method('PUT')

                <!-- Form Grid -->
                <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                    <!-- Left Column - Personal Info -->
                    <div class="space-y-6">
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
                                <input type="text" name="nama" id="nama" value="{{ old('nama', $user->nama) }}"
                                    required
                                    class="w-full px-4 py-3 rounded-xl border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition-colors duration-200 @error('nama') border-red-500 @enderror"
                                    placeholder="Masukkan nama lengkap">
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
                                <input type="email" name="email" id="email" value="{{ old('email', $user->email) }}"
                                    required
                                    class="w-full px-4 py-3 rounded-xl border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition-colors duration-200 @error('email') border-red-500 @enderror"
                                    placeholder="Masukkan alamat email">
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
                                    value="{{ old('telepon', $user->telepon) }}" required
                                    class="w-full px-4 py-3 rounded-xl border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition-colors duration-200 @error('telepon') border-red-500 @enderror"
                                    placeholder="Masukkan nomor telepon">
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
                                <textarea name="alamat" id="alamat" rows="3" required
                                    class="w-full px-4 py-3 rounded-xl border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition-colors duration-200 @error('alamat') border-red-500 @enderror"
                                    placeholder="Masukkan alamat lengkap">{{ old('alamat', $user->alamat) }}</textarea>
                                @error('alamat')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <!-- Right Column - Account Info -->
                    <div class="space-y-6">
                        <div>
                            <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4 flex items-center">
                                <iconify-icon icon="heroicons:cog-6-tooth-20-solid"
                                    class="w-5 h-5 mr-2 text-indigo-600"></iconify-icon>
                                Informasi Akun
                            </h3>

                            <!-- Nama -->
                            <div>
                                <label for="nama"
                                    class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                                    Nama Lengkap
                                </label>
                                <input type="text" name="nama" id="nama" value="{{ old('nama', $user->nama) }}"
                                    required
                                    class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-xl focus:ring-2 focus:ring-indigo-500 dark:focus:ring-indigo-400 focus:border-transparent bg-white dark:bg-gray-700 text-gray-900 dark:text-white">
                                @error('nama')
                                    <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Email -->
                            <div>
                                <label for="email"
                                    class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                                    Email
                                </label>
                                <input type="email" name="email" id="email"
                                    value="{{ old('email', $user->email) }}" required
                                    class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-xl focus:ring-2 focus:ring-indigo-500 dark:focus:ring-indigo-400 focus:border-transparent bg-white dark:bg-gray-700 text-gray-900 dark:text-white">
                                @error('email')
                                    <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Telepon -->
                            <div>
                                <label for="telepon"
                                    class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                                    Telepon
                                </label>
                                <input type="text" name="telepon" id="telepon"
                                    value="{{ old('telepon', $user->telepon) }}" required
                                    class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-xl focus:ring-2 focus:ring-indigo-500 dark:focus:ring-indigo-400 focus:border-transparent bg-white dark:bg-gray-700 text-gray-900 dark:text-white">
                                @error('telepon')
                                    <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Alamat -->
                            <div>
                                <label for="alamat"
                                    class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                                    Alamat
                                </label>
                                <textarea name="alamat" id="alamat" rows="3" required
                                    class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-xl focus:ring-2 focus:ring-indigo-500 dark:focus:ring-indigo-400 focus:border-transparent bg-white dark:bg-gray-700 text-gray-900 dark:text-white">{{ old('alamat', $user->alamat) }}</textarea>
                                @error('alamat')
                                    <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Role -->
                            <div class="mb-4">
                                <label for="role"
                                    class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                    Role <span class="text-red-500">*</span>
                                </label>
                                <select name="role" id="role" required
                                    class="w-full px-4 py-3 rounded-xl border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition-colors duration-200 @error('role') border-red-500 @enderror">
                                    <option value="">Pilih Role</option>
                                    <option value="admin" {{ old('role', $user->role) === 'admin' ? 'selected' : '' }}>
                                        Admin</option>
                                    <option value="staf" {{ old('role', $user->role) === 'staf' ? 'selected' : '' }}>
                                        Staf</option>
                                </select>
                                @error('role')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Password -->
                            <div class="mb-4">
                                <label for="password"
                                    class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                    Password Baru
                                </label>
                                <input type="password" name="password" id="password"
                                    class="w-full px-4 py-3 rounded-xl border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition-colors duration-200 @error('password') border-red-500 @enderror"
                                    placeholder="Kosongkan jika tidak ingin mengubah">
                                @error('password')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                                <p class="mt-1 text-xs text-gray-500">Minimal 8 karakter (kosongkan jika tidak ingin
                                    mengubah)</p>
                            </div>

                            <!-- Password Confirmation -->
                            <div class="mb-4">
                                <label for="password_confirmation"
                                    class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                    Konfirmasi Password Baru
                                </label>
                                <input type="password" name="password_confirmation" id="password_confirmation"
                                    class="w-full px-4 py-3 rounded-xl border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition-colors duration-200"
                                    placeholder="Ulangi password baru">
                            </div>

                            <!-- Status -->
                            <div class="mb-4">
                                <label for="aktif"
                                    class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                    Status <span class="text-red-500">*</span>
                                </label>
                                <select name="aktif" id="aktif" required
                                    class="w-full px-4 py-3 rounded-xl border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition-colors duration-200 @error('aktif') border-red-500 @enderror">
                                    <option value="1" {{ old('aktif', $user->aktif) == '1' ? 'selected' : '' }}>Aktif
                                    </option>
                                    <option value="0" {{ old('aktif', $user->aktif) == '0' ? 'selected' : '' }}>Tidak
                                        Aktif</option>
                                </select>
                                @error('aktif')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Submit Buttons -->
                <div class="flex items-center justify-end space-x-3 pt-6 border-t border-gray-200 dark:border-gray-700">
                    <a href="{{ route('admin.users.index') }}"
                        class="px-6 py-2 bg-gray-500 hover:bg-gray-600 text-white text-sm font-medium rounded-xl transition-colors duration-200">
                        Batal
                    </a>
                    <button type="submit"
                        class="px-6 py-2 bg-indigo-600 hover:bg-indigo-700 text-white text-sm font-medium rounded-xl transition-colors duration-200">
                        <iconify-icon icon="heroicons:check-20-solid" class="w-4 h-4 mr-2 inline-block"></iconify-icon>
                        Perbarui Pengguna
                    </button>
                </div>
            </form>
        </div>
    </div>

    @push('scripts')
        <script>
            // Password confirmation validation
            document.getElementById('password_confirmation').addEventListener('input', function(e) {
                const password = document.getElementById('password').value;
                const confirmation = e.target.value;

                if (password !== confirmation && confirmation !== '' && password !== '') {
                    e.target.setCustomValidity('Password tidak cocok');
                } else {
                    e.target.setCustomValidity('');
                }
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
        </script>
    @endpush
@endsection
