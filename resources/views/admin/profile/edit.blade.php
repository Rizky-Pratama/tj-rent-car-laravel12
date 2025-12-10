@extends('layouts.admin')

@section('title', 'Edit Profil')
@section('page-title', 'Edit Profil')
@section('page-subtitle', 'Perbarui informasi profil dan keamanan akun Anda')

@section('content')
    <div class="max-w-4xl mx-auto space-y-6">
        <!-- Profile Information Card -->
        <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-sm border border-gray-100 dark:border-gray-700 p-6">
            <div class="flex items-center mb-6">
                <div class="flex-shrink-0">
                    <div
                        class="w-10 h-10 bg-gradient-to-r from-indigo-500 to-purple-600 rounded-lg flex items-center justify-center">
                        <iconify-icon icon="heroicons:user-solid" class="w-5 h-5 text-white"></iconify-icon>
                    </div>
                </div>
                <div class="ml-4">
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-white">Informasi Profil</h3>
                    <p class="text-sm text-gray-600 dark:text-gray-400">Perbarui informasi profil Anda</p>
                </div>
            </div>

            <form action="{{ route('admin.profile.update') }}" method="POST">
                @csrf
                @method('PUT')

                <div class="space-y-6">
                    <!-- Name -->
                    <div>
                        <label for="nama" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                            Nama Lengkap *
                        </label>
                        <input type="text" name="nama" id="nama" value="{{ old('nama', $user->nama) }}" required
                            class="block w-full px-4 py-2.5 border border-gray-300 dark:border-gray-600 rounded-lg text-gray-900 dark:text-white bg-white dark:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition-colors text-sm">
                        @error('nama')
                            <p class="mt-1 text-xs text-red-600 dark:text-red-400">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Email -->
                    <div>
                        <label for="email" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                            Email *
                        </label>
                        <input type="email" name="email" id="email" value="{{ old('email', $user->email) }}"
                            required
                            class="block w-full px-4 py-2.5 border border-gray-300 dark:border-gray-600 rounded-lg text-gray-900 dark:text-white bg-white dark:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition-colors text-sm">
                        @error('email')
                            <p class="mt-1 text-xs text-red-600 dark:text-red-400">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Phone -->
                    <div>
                        <label for="telepon" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                            Telepon
                        </label>
                        <input type="text" name="telepon" id="telepon" value="{{ old('telepon', $user->telepon) }}"
                            placeholder="08xxxxxxxxxx"
                            class="block w-full px-4 py-2.5 border border-gray-300 dark:border-gray-600 rounded-lg text-gray-900 dark:text-white bg-white dark:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition-colors text-sm">
                        @error('telepon')
                            <p class="mt-1 text-xs text-red-600 dark:text-red-400">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Address -->
                    <div>
                        <label for="alamat" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                            Alamat
                        </label>
                        <textarea name="alamat" id="alamat" rows="3" placeholder="Masukkan alamat lengkap..."
                            class="block w-full px-4 py-2.5 border border-gray-300 dark:border-gray-600 rounded-lg text-gray-900 dark:text-white bg-white dark:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition-colors text-sm">{{ old('alamat', $user->alamat) }}</textarea>
                        @error('alamat')
                            <p class="mt-1 text-xs text-red-600 dark:text-red-400">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <!-- Actions -->
                <div class="flex justify-end space-x-3 mt-6 pt-6 border-t border-gray-200 dark:border-gray-700">
                    <a href="{{ route('admin.profile.show') }}"
                        class="px-4 py-2 border border-gray-300 dark:border-gray-600 text-gray-700 dark:text-gray-300 bg-white dark:bg-gray-800 rounded-lg hover:bg-gray-50 dark:hover:bg-gray-700 font-medium transition-colors text-sm">
                        Batal
                    </a>
                    <button type="submit"
                        class="px-4 py-2 bg-indigo-600 hover:bg-indigo-700 text-white font-medium rounded-lg transition-colors text-sm flex items-center">
                        <iconify-icon icon="heroicons:check-solid" class="w-4 h-4 mr-2"></iconify-icon>
                        Simpan Perubahan
                    </button>
                </div>
            </form>
        </div>

        <!-- Change Password Card -->
        <div id="password-section"
            class="bg-white dark:bg-gray-800 rounded-2xl shadow-sm border border-gray-100 dark:border-gray-700 p-6">
            <div class="flex items-center mb-6">
                <div class="flex-shrink-0">
                    <div
                        class="w-10 h-10 bg-gradient-to-r from-red-500 to-pink-600 rounded-lg flex items-center justify-center">
                        <iconify-icon icon="heroicons:lock-closed-solid" class="w-5 h-5 text-white"></iconify-icon>
                    </div>
                </div>
                <div class="ml-4">
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-white">Ubah Password</h3>
                    <p class="text-sm text-gray-600 dark:text-gray-400">Pastikan akun Anda menggunakan password yang kuat
                    </p>
                </div>
            </div>

            <form action="{{ route('admin.profile.password') }}" method="POST">
                @csrf
                @method('PUT')

                <div class="space-y-6">
                    <!-- Current Password -->
                    <div>
                        <label for="current_password"
                            class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                            Password Saat Ini *
                        </label>
                        <div class="relative" x-data="{ show: false }">
                            <input :type="show ? 'text' : 'password'" name="current_password" id="current_password" required
                                class="block w-full px-4 py-2.5 pr-10 border border-gray-300 dark:border-gray-600 rounded-lg text-gray-900 dark:text-white bg-white dark:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition-colors text-sm">
                            <button type="button" @click="show = !show"
                                class="absolute inset-y-0 right-0 pr-3 flex items-center">
                                <iconify-icon x-show="!show" icon="heroicons:eye-solid"
                                    class="h-5 w-5 text-gray-400 hover:text-gray-600 dark:hover:text-gray-300"></iconify-icon>
                                <iconify-icon x-show="show" icon="heroicons:eye-slash-solid"
                                    class="h-5 w-5 text-gray-400 hover:text-gray-600 dark:hover:text-gray-300"></iconify-icon>
                            </button>
                        </div>
                        @error('current_password')
                            <p class="mt-1 text-xs text-red-600 dark:text-red-400">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- New Password -->
                    <div>
                        <label for="password" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                            Password Baru *
                        </label>
                        <div class="relative" x-data="{ show: false }">
                            <input :type="show ? 'text' : 'password'" name="password" id="password" required
                                class="block w-full px-4 py-2.5 pr-10 border border-gray-300 dark:border-gray-600 rounded-lg text-gray-900 dark:text-white bg-white dark:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition-colors text-sm">
                            <button type="button" @click="show = !show"
                                class="absolute inset-y-0 right-0 pr-3 flex items-center">
                                <iconify-icon x-show="!show" icon="heroicons:eye-solid"
                                    class="h-5 w-5 text-gray-400 hover:text-gray-600 dark:hover:text-gray-300"></iconify-icon>
                                <iconify-icon x-show="show" icon="heroicons:eye-slash-solid"
                                    class="h-5 w-5 text-gray-400 hover:text-gray-600 dark:hover:text-gray-300"></iconify-icon>
                            </button>
                        </div>
                        @error('password')
                            <p class="mt-1 text-xs text-red-600 dark:text-red-400">{{ $message }}</p>
                        @enderror
                        <p class="mt-1 text-xs text-gray-500 dark:text-gray-400">
                            Minimal 8 karakter
                        </p>
                    </div>

                    <!-- Confirm Password -->
                    <div>
                        <label for="password_confirmation"
                            class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                            Konfirmasi Password Baru *
                        </label>
                        <div class="relative" x-data="{ show: false }">
                            <input :type="show ? 'text' : 'password'" name="password_confirmation"
                                id="password_confirmation" required
                                class="block w-full px-4 py-2.5 pr-10 border border-gray-300 dark:border-gray-600 rounded-lg text-gray-900 dark:text-white bg-white dark:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition-colors text-sm">
                            <button type="button" @click="show = !show"
                                class="absolute inset-y-0 right-0 pr-3 flex items-center">
                                <iconify-icon x-show="!show" icon="heroicons:eye-solid"
                                    class="h-5 w-5 text-gray-400 hover:text-gray-600 dark:hover:text-gray-300"></iconify-icon>
                                <iconify-icon x-show="show" icon="heroicons:eye-slash-solid"
                                    class="h-5 w-5 text-gray-400 hover:text-gray-600 dark:hover:text-gray-300"></iconify-icon>
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Actions -->
                <div class="flex justify-end mt-6 pt-6 border-t border-gray-200 dark:border-gray-700">
                    <button type="submit"
                        class="px-4 py-2 bg-red-600 hover:bg-red-700 text-white font-medium rounded-lg transition-colors text-sm flex items-center">
                        <iconify-icon icon="heroicons:key-solid" class="w-4 h-4 mr-2"></iconify-icon>
                        Ubah Password
                    </button>
                </div>
            </form>
        </div>
    </div>


@endsection
