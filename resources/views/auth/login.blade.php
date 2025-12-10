<!DOCTYPE html>
<html lang="id" class="h-full">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - TJ Rent Car</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script src="https://cdn.jsdelivr.net/npm/iconify-icon@3.0.0/dist/iconify-icon.min.js"></script>

    <script>
        // Dark mode initialization (same as admin layout)
        (function() {
            'use strict';
            const theme = localStorage.getItem('theme');
            const root = document.documentElement;
            if (theme === 'dark') {
                root.classList.add('dark');
            } else if (theme === 'light') {
                root.classList.remove('dark');
            } else {
                if (window.matchMedia('(prefers-color-scheme: dark)').matches) {
                    root.classList.add('dark');
                }
            }
        })();
    </script>

    @livewireScripts()
</head>

<body class="h-full bg-gray-50 dark:bg-gray-900">
    <div class="min-h-screen flex">
        <!-- Left Side - Form (Mobile: Full width, Desktop: 50%) -->
        <div class="flex-1 flex flex-col justify-center py-8 px-4 sm:px-6 lg:px-20 xl:px-24">
            <div class="mx-auto w-full max-w-sm lg:w-96">
                <!-- Logo & Title -->
                <div class="mb-8 text-center lg:text-start">
                    <div class="flex items-center justify-center lg:justify-start mb-1">
                        <img src="/logo/logo.png" alt="TJ Rent Car" class="h-32 w-auto">
                    </div>
                    <h2 class="text-2xl font-bold text-gray-900 dark:text-white">
                        Selamat Datang
                    </h2>
                    <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
                        Masuk ke sistem manajemen rental mobil
                    </p>
                </div>

                <!-- Login Form -->
                <form class="space-y-5" action="#" method="POST">
                    @csrf

                    <!-- Email Field -->
                    <div>
                        <label for="email" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                            Alamat Email
                        </label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <iconify-icon icon="heroicons:envelope-solid"
                                    class="h-5 w-5 text-gray-400"></iconify-icon>
                            </div>
                            <input id="email" name="email" type="email" required
                                class="block w-full pl-10 pr-3 py-2.5 border border-gray-300 dark:border-gray-600 rounded-lg text-gray-900 dark:text-white placeholder-gray-400 bg-white dark:bg-gray-800 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition-colors text-sm"
                                placeholder="admin@admin.com" value="{{ old('email') }}">
                        </div>
                        @error('email')
                            <p class="mt-1.5 text-xs text-red-600 dark:text-red-400">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Password Field -->
                    <div>
                        <label for="password" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                            Kata Sandi
                        </label>
                        <div class="relative" x-data="{ showPassword: false }">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <iconify-icon icon="heroicons:lock-closed-solid"
                                    class="h-5 w-5 text-gray-400"></iconify-icon>
                            </div>
                            <input id="password" name="password" :type="showPassword ? 'text' : 'password'" required
                                class="block w-full pl-10 pr-10 py-2.5 border border-gray-300 dark:border-gray-600 rounded-lg text-gray-900 dark:text-white placeholder-gray-400 bg-white dark:bg-gray-800 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition-colors text-sm"
                                placeholder="••••••••">
                            <button type="button" @click="showPassword = !showPassword"
                                class="absolute inset-y-0 right-0 pr-3 flex items-center">
                                <iconify-icon x-show="!showPassword" icon="heroicons:eye-solid"
                                    class="h-5 w-5 text-gray-400 hover:text-gray-600 dark:hover:text-gray-300"></iconify-icon>
                                <iconify-icon x-show="showPassword" icon="heroicons:eye-slash-solid"
                                    class="h-5 w-5 text-gray-400 hover:text-gray-600 dark:hover:text-gray-300"></iconify-icon>
                            </button>
                        </div>
                        @error('password')
                            <p class="mt-1.5 text-xs text-red-600 dark:text-red-400">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Remember Me -->
                    <div class="flex items-center">
                        <input id="remember-me" name="remember" type="checkbox"
                            class="h-4 w-4 text-indigo-600 focus:ring-indigo-500 border-gray-300 dark:border-gray-600 rounded bg-white dark:bg-gray-700">
                        <label for="remember-me" class="ml-2 block text-sm text-gray-700 dark:text-gray-300">
                            Ingat saya
                        </label>
                    </div>

                    <!-- Submit Button -->
                    <button type="submit"
                        class="w-full flex justify-center items-center py-2.5 px-4 border border-transparent rounded-lg text-sm font-medium text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 dark:focus:ring-offset-gray-900 transition-colors">
                        <iconify-icon icon="heroicons:arrow-right-solid" class="mr-2 h-4 w-4"></iconify-icon>
                        Masuk ke Dashboard
                    </button>
                </form>

                <!-- Footer -->
                <div class="mt-8">
                    <p class="text-xs text-center text-gray-500 dark:text-gray-400">
                        © {{ date('Y') }} TJ Rent Car. Semua hak dilindungi.
                    </p>
                    <p
                        class="mt-2 text-xs text-center text-gray-400 dark:text-gray-500 flex items-center justify-center">
                        <iconify-icon icon="heroicons:heart-solid" class="w-3 h-3 mr-1 text-red-500"></iconify-icon>
                        Aman & Terpercaya
                    </p>
                </div>
            </div>
        </div>

        <!-- Right Side - Hero Image (Hidden on mobile, visible on lg+) -->
        <div class="hidden lg:block relative w-0 flex-1">
            <div class="absolute inset-0 bg-gray-100 dark:bg-gray-800">
                <!-- Subtle Pattern Overlay -->
                <div class="absolute inset-0 opacity-[0.03] dark:opacity-[0.05]"
                    style="background-image: radial-gradient(circle at 1px 1px, rgb(0 0 0) 1px, transparent 0); background-size: 40px 40px;">
                </div>

                <!-- Content -->
                <div class="relative h-full flex flex-col items-center justify-center p-12">
                    <div class="max-w-md text-center">

                        <h3 class="text-3xl font-bold mb-4 text-gray-900 dark:text-white">
                            Sistem Manajemen Rental Mobil
                        </h3>
                        <p class="text-base text-gray-600 dark:text-gray-400 mb-8">
                            Kelola bisnis rental mobil Anda dengan mudah dan efisien
                        </p>

                        <!-- Features -->
                        <div class="space-y-4 text-left">
                            <div class="flex items-start space-x-3">
                                <div
                                    class="flex-shrink-0 w-6 h-6 bg-indigo-100 dark:bg-indigo-900/30 rounded-full flex items-center justify-center mt-0.5">
                                    <iconify-icon icon="heroicons:check-solid"
                                        class="w-4 h-4 text-indigo-600 dark:text-indigo-400"></iconify-icon>
                                </div>
                                <div>
                                    <p class="font-medium text-gray-900 dark:text-white">Manajemen Transaksi</p>
                                    <p class="text-sm text-gray-600 dark:text-gray-400">Memudahkan pengelolaan transaksi
                                        rental mobil Anda</p>
                                </div>
                            </div>
                            <div class="flex items-start space-x-3">
                                <div
                                    class="flex-shrink-0 w-6 h-6 bg-indigo-100 dark:bg-indigo-900/30 rounded-full flex items-center justify-center mt-0.5">
                                    <iconify-icon icon="heroicons:check-solid"
                                        class="w-4 h-4 text-indigo-600 dark:text-indigo-400"></iconify-icon>
                                </div>
                                <div>
                                    <p class="font-medium text-gray-900 dark:text-white">Laporan Lengkap</p>
                                    <p class="text-sm text-gray-600 dark:text-gray-400">Export laporan pembayaran dan
                                        transaksi</p>
                                </div>
                            </div>
                            <div class="flex items-start space-x-3">
                                <div
                                    class="flex-shrink-0 w-6 h-6 bg-indigo-100 dark:bg-indigo-900/30 rounded-full flex items-center justify-center mt-0.5">
                                    <iconify-icon icon="heroicons:check-solid"
                                        class="w-4 h-4 text-indigo-600 dark:text-indigo-400"></iconify-icon>
                                </div>
                                <div>
                                    <p class="font-medium text-gray-900 dark:text-white">Dashboard Interaktif</p>
                                    <p class="text-sm text-gray-600 dark:text-gray-400">Visualisasi data dengan grafik
                                        dan statistik</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Toast Notifications -->
    @if (session('error'))
        <div x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 5000)"
            x-transition:enter="transform transition ease-out duration-300"
            x-transition:enter-start="translate-x-full opacity-0" x-transition:enter-end="translate-x-0 opacity-100"
            x-transition:leave="transform transition ease-in duration-200"
            x-transition:leave-start="translate-x-0 opacity-100" x-transition:leave-end="translate-x-full opacity-0"
            class="fixed top-6 right-6 bg-red-50 dark:bg-red-900/50 border border-red-200 dark:border-red-700 text-red-800 dark:text-red-200 px-4 py-3 rounded-xl shadow-lg max-w-sm">
            <div class="flex items-center">
                <iconify-icon icon="heroicons:exclamation-circle-20-solid"
                    class="w-5 h-5 mr-2 text-red-600 dark:text-red-400"></iconify-icon>
                <span class="text-sm font-medium">{{ session('error') }}</span>
            </div>
        </div>
    @endif

    @if (session('success'))
        <div x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 5000)"
            x-transition:enter="transform transition ease-out duration-300"
            x-transition:enter-start="translate-x-full opacity-0" x-transition:enter-end="translate-x-0 opacity-100"
            x-transition:leave="transform transition ease-in duration-200"
            x-transition:leave-start="translate-x-0 opacity-100" x-transition:leave-end="translate-x-full opacity-0"
            class="fixed top-6 right-6 bg-green-50 dark:bg-green-900/50 border border-green-200 dark:border-green-700 text-green-800 dark:text-green-200 px-4 py-3 rounded-xl shadow-lg max-w-sm">
            <div class="flex items-center">
                <iconify-icon icon="heroicons:check-circle-20-solid"
                    class="w-5 h-5 mr-2 text-green-600 dark:text-green-400"></iconify-icon>
                <span class="text-sm font-medium">{{ session('success') }}</span>
            </div>
        </div>
    @endif
</body>

</html>
