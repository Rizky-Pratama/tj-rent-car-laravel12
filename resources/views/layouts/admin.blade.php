<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title', 'Admin Dashboard') - TJ Rent Car</title>

    <script>
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

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <!-- Iconify Icons -->
    <script src="https://cdn.jsdelivr.net/npm/iconify-icon@3.0.0/dist/iconify-icon.min.js"></script>

    <!-- Assets (includes theme.js for Alpine integration) -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    @livewireScripts()

    @stack('styles')
</head>

<body class="font-sans antialiased bg-gray-50 dark:bg-gray-900" x-data="themeManager()" x-init="initTheme()">
    <div class="min-h-screen flex">
        <!-- Sidebar -->
        <x-admin.sidebar />

        <!-- Main Content -->
        <div class="flex-1 flex flex-col overflow-hidden lg:ml-64">
            <!-- Navbar -->
            <x-admin.navbar />

            <!-- Page Content -->
            <main class="flex-1 overflow-x-hidden overflow-y-auto bg-gray-50 dark:bg-gray-900">
                <div class="container mx-auto px-6 py-8">
                    <!-- Flash Messages -->
                    @if (session('success'))
                        <div class="mb-6 bg-emerald-50 dark:bg-emerald-900/50 border border-emerald-200 dark:border-emerald-800 text-emerald-700 dark:text-emerald-300 px-4 py-3 rounded-xl"
                            x-data="{ show: true }" x-show="show" x-transition>
                            <div class="flex items-center justify-between">
                                <div class="flex items-center">
                                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M5 13l4 4L19 7" />
                                    </svg>
                                    {{ session('success') }}
                                </div>
                                <button @click="show = false" class="text-emerald-500 hover:text-emerald-700">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M6 18L18 6M6 6l12 12" />
                                    </svg>
                                </button>
                            </div>
                        </div>
                    @endif

                    @if (session('error'))
                        <div class="mb-6 bg-red-50 dark:bg-red-900/50 border border-red-200 dark:border-red-800 text-red-700 dark:text-red-300 px-4 py-3 rounded-xl"
                            x-data="{ show: true }" x-show="show" x-transition>
                            <div class="flex items-center justify-between">
                                <div class="flex items-center">
                                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M6 18L18 6M6 6l12 12" />
                                    </svg>
                                    {{ session('error') }}
                                </div>
                                <button @click="show = false" class="text-red-500 hover:text-red-700">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M6 18L18 6M6 6l12 12" />
                                    </svg>
                                </button>
                            </div>
                        </div>
                    @endif

                    @if (isset($breadcrumbs))
                        <x-admin.breadcrumb :breadcrumbs="$breadcrumbs" />
                    @endif

                    @yield('content')
                </div>
            </main>
        </div>
    </div>

    <!-- Mobile sidebar overlay -->
    <div class="fixed inset-0 z-40 bg-black bg-opacity-50 lg:hidden" x-show="sidebarOpen"
        x-transition:enter="transition-opacity ease-linear duration-300" x-transition:enter-start="opacity-0"
        x-transition:enter-end="opacity-100" x-transition:leave="transition-opacity ease-linear duration-300"
        x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0" @click="sidebarOpen = false"
        style="display: none;">
    </div>

    @stack('scripts')
</body>

</html>
