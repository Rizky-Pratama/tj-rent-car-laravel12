<!DOCTYPE html>
<html lang="id" class="h-full">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - TJ Rent Car Admin</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script src="https://cdn.jsdelivr.net/npm/iconify-icon@3.0.0/dist/iconify-icon.min.js"></script>

    @livewireScripts()
</head>

<body
    class="h-full bg-gradient-to-br from-indigo-50 via-white to-purple-50 dark:from-gray-900 dark:via-gray-800 dark:to-indigo-900">
    <!-- Background Pattern -->
    <div class="absolute inset-0 overflow-hidden">
        <svg class="absolute left-[max(50%,25rem)] top-0 h-[64rem] w-[128rem] -translate-x-1/2 stroke-gray-200 dark:stroke-gray-700 [mask-image:radial-gradient(64rem_64rem_at_top,white,transparent)]"
            aria-hidden="true">
            <defs>
                <pattern id="e813992c-7d03-4cc4-a2bd-151760b470a0" width="200" height="200" x="50%" y="-1"
                    patternUnits="userSpaceOnUse">
                    <path d="M100 200V.5M.5 .5H200" fill="none" />
                </pattern>
            </defs>
            <rect width="100%" height="100%" stroke-width="0" fill="url(#e813992c-7d03-4cc4-a2bd-151760b470a0)" />
        </svg>
    </div>

    <div class="relative min-h-full flex items-center justify-center py-12 px-4 sm:px-6 lg:px-8">
        <div class="max-w-md w-full space-y-8">
            <!-- Header -->
            <div class="text-center">
                <div class="flex justify-center">
                    <div class="w-46 h-46 flex items-center justify-center">
                        {{-- <iconify-icon icon="heroicons:bolt-solid" class="w-10 h-10 text-white"></iconify-icon> --}}
                        <img src="/logo/logo.png" alt="Logo">
                    </div>
                </div>
                <h2 class="text-3xl font-bold text-gray-900 dark:text-white">
                    Selamat Datang
                </h2>
                <div class="mt-2 flex items-center justify-center space-x-2">
                    <h3 class="text-xl font-semibold text-indigo-600 dark:text-indigo-400">TJ Rent Car</h3>
                </div>
                <p class="mt-2 text-sm text-gray-600 dark:text-gray-400">
                    Masuk ke sistem manajemen rental mobil
                </p>
            </div>

            <!-- Login Form -->
            <div
                class="bg-white dark:bg-gray-800 rounded-2xl shadow-xl border border-gray-100 dark:border-gray-700 p-8">
                <form class="space-y-6" action="#" method="POST">
                    @csrf
                    <div class="space-y-5">
                        <!-- Email Field -->
                        <div>
                            <label for="email"
                                class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">
                                Alamat Email
                            </label>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                    <iconify-icon icon="heroicons:envelope-20-solid"
                                        class="h-5 w-5 text-gray-400 dark:text-gray-500"></iconify-icon>
                                </div>
                                <input id="email" name="email" type="email" required
                                    class="block w-full pl-11 pr-4 py-3.5 border border-gray-200 dark:border-gray-600 rounded-xl text-gray-900 dark:text-white placeholder-gray-400 dark:placeholder-gray-500 bg-gray-50 dark:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 dark:focus:ring-indigo-400 focus:border-transparent transition-all duration-200 sm:text-sm"
                                    placeholder="admin@tjrentcar.com" value="{{ old('email') }}">
                            </div>
                            @error('email')
                                <p class="mt-2 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Password Field -->
                        <div>
                            <label for="password"
                                class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">
                                Kata Sandi
                            </label>
                            <div class="relative" x-data="{ showPassword: false }">
                                <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                    <iconify-icon icon="heroicons:lock-closed-20-solid"
                                        class="h-5 w-5 text-gray-400 dark:text-gray-500"></iconify-icon>
                                </div>
                                <input id="password" name="password" :type="showPassword ? 'text' : 'password'"
                                    required
                                    class="block w-full pl-11 pr-11 py-3.5 border border-gray-200 dark:border-gray-600 rounded-xl text-gray-900 dark:text-white placeholder-gray-400 dark:placeholder-gray-500 bg-gray-50 dark:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 dark:focus:ring-indigo-400 focus:border-transparent transition-all duration-200 sm:text-sm"
                                    placeholder="Masukkan kata sandi Anda">
                                <div class="absolute inset-y-0 right-0 pr-4 flex items-center">
                                    <button type="button" @click="showPassword = !showPassword"
                                        class="text-gray-400 dark:text-gray-500 hover:text-gray-600 dark:hover:text-gray-400 transition-colors duration-200">
                                        <iconify-icon x-show="!showPassword" icon="heroicons:eye-20-solid"
                                            class="h-5 w-5"></iconify-icon>
                                        <iconify-icon x-show="showPassword" icon="heroicons:eye-slash-20-solid"
                                            class="h-5 w-5"></iconify-icon>
                                    </button>
                                </div>
                            </div>
                            @error('password')
                                <p class="mt-2 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Remember Me & Forgot Password -->
                        <div class="flex items-center justify-between">
                            <div class="flex items-center">
                                <input id="remember-me" name="remember" type="checkbox"
                                    class="h-4 w-4 text-indigo-600 focus:ring-indigo-500 border-gray-300 dark:border-gray-600 rounded bg-gray-50 dark:bg-gray-700">
                                <label for="remember-me" class="ml-2 block text-sm text-gray-700 dark:text-gray-300">
                                    Ingat saya
                                </label>
                            </div>
                        </div>
                    </div>

                    <!-- Submit Button -->
                    <div class="pt-2">
                        <button type="submit"
                            class="group relative w-full flex justify-center items-center py-3.5 px-4 border border-transparent text-sm font-semibold rounded-xl text-white bg-gradient-to-r from-indigo-600 to-purple-600 hover:from-indigo-700 hover:to-purple-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 dark:focus:ring-offset-gray-800 shadow-lg hover:shadow-xl transform hover:-translate-y-0.5 transition-all duration-200">
                            <iconify-icon icon="heroicons:arrow-right-20-solid" class="mr-2 h-5 w-5"></iconify-icon>
                            Masuk ke Dashboard
                        </button>
                    </div>
                </form>
            </div>

            <!-- Footer -->
            <div class="text-center mt-8">
                <p class="text-xs text-gray-500 dark:text-gray-400">
                    © {{ date('Y') }} TJ Rent Car. Semua hak dilindungi.
                </p>
                <div class="flex items-center justify-center mt-2 space-x-4 text-xs text-gray-400 dark:text-gray-500">
                    <span class="flex items-center">
                        <iconify-icon icon="heroicons:shield-check-20-solid" class="w-3 h-3 mr-1"></iconify-icon>
                        Aman & Terpercaya
                    </span>
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
