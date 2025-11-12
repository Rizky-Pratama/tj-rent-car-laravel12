<header
    class="bg-white dark:bg-gray-800 h-20 flex items-center shadow-sm border-b border-gray-200 dark:border-gray-700 sticky top-0 z-30">
    <div class="w-full flex items-center justify-between px-6">
        <!-- Left side -->
        <div class="flex items-center space-x-4">
            <!-- Mobile menu button -->
            <button @click="sidebarOpen = !sidebarOpen"
                class="lg:hidden p-2 rounded-xl text-gray-600 dark:text-gray-400 hover:bg-gray-100 dark:hover:bg-gray-700 transition-colors duration-200">
                <iconify-icon icon="heroicons:bars-3-20-solid" class="w-6 h-6"></iconify-icon>
            </button>

            <!-- Page title -->
            <div class="hidden md:block">
                <h2 class="text-2xl font-bold text-gray-800 dark:text-white">@yield('page-title', 'Dashboard')</h2>
                <p class="text-sm text-gray-500 dark:text-gray-400">@yield('page-subtitle', 'Welcome to your admin panel')</p>
            </div>
        </div>

        <!-- Right side items -->
        <div class="flex items-center space-x-3">

            <!-- Dark mode toggle -->
            <button @click="toggleTheme()"
                class="p-2.5 rounded-xl flex items-center text-gray-600 dark:text-gray-400 hover:bg-gray-100 dark:hover:bg-gray-700 transition-all duration-200"
                title="Toggle Dark Mode">
                <iconify-icon x-show="!darkMode" icon="heroicons:moon-20-solid" class="w-5 h-5"></iconify-icon>
                <iconify-icon x-show="darkMode" icon="heroicons:sun-20-solid" class="w-5 h-5"
                    style="display: none;"></iconify-icon>
            </button>
            <div x-data="{ open: false }" class="relative">
                <button @click="open = !open"
                    class="flex items-center space-x-2 p-2 rounded-xl hover:bg-gray-100 dark:hover:bg-gray-700 transition-all duration-200">
                    <img class="w-8 h-8 rounded-full ring-2 ring-gray-200 dark:ring-gray-600"
                        src="https://ui-avatars.com/api/?name=Admin+User&color=7C3AED&background=EDE9FE&size=32"
                        alt="Avatar">
                    <div class="hidden md:block text-left">
                        <div class="text-sm font-medium text-gray-700 dark:text-gray-200">Admin User</div>
                        <div class="text-xs text-gray-500 dark:text-gray-400">Administrator</div>
                    </div>
                    <iconify-icon icon="heroicons:chevron-down-20-solid"
                        class="w-4 h-4 text-gray-400 transition-transform duration-200"
                        :class="{ 'rotate-180': open }"></iconify-icon>
                </button>

                <div x-show="open" @click.away="open = false" x-transition:enter="transition ease-out duration-200"
                    x-transition:enter-start="opacity-0 scale-95" x-transition:enter-end="opacity-100 scale-100"
                    x-transition:leave="transition ease-in duration-75" x-transition:leave-start="opacity-100 scale-100"
                    x-transition:leave-end="opacity-0 scale-95"
                    class="absolute right-0 mt-3 w-56 bg-white dark:bg-gray-800 rounded-xl shadow-lg border border-gray-200 dark:border-gray-700 z-50"
                    style="display: none;">

                    <div class="py-2">
                        @auth
                            <div class="px-4 py-3 border-b border-gray-200 dark:border-gray-700">
                                <p class="text-sm font-medium text-gray-800 dark:text-white">{{ Auth::user()->nama }}</p>
                                <p class="text-xs text-gray-500 dark:text-gray-400">{{ Auth::user()->email }}</p>
                                <span
                                    class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-indigo-100 text-indigo-800 dark:bg-indigo-900 dark:text-indigo-200">
                                    {{ ucfirst(Auth::user()->role) }}
                                </span>
                            </div>

                            <a href="#"
                                class="flex items-center px-4 py-3 text-sm text-gray-700 dark:text-gray-200 hover:bg-gray-100 dark:hover:bg-gray-700 transition-colors duration-150">
                                <iconify-icon icon="heroicons:user-20-solid" class="w-4 h-4 mr-3"></iconify-icon>
                                Profil Saya
                            </a>

                            <a href="#"
                                class="flex items-center px-4 py-3 text-sm text-gray-700 dark:text-gray-200 hover:bg-gray-100 dark:hover:bg-gray-700 transition-colors duration-150">
                                <iconify-icon icon="heroicons:cog-6-tooth-20-solid" class="w-4 h-4 mr-3"></iconify-icon>
                                Pengaturan Akun
                            </a>

                            <hr class="my-2 border-gray-200 dark:border-gray-700">

                            <form method="POST" action="{{ route('logout') }}" class="m-0">
                                @csrf
                                <button type="submit"
                                    class="flex items-center w-full px-4 py-3 text-sm text-red-600 dark:text-red-400 hover:bg-red-50 dark:hover:bg-red-900/20 transition-colors duration-150">
                                    <iconify-icon icon="heroicons:arrow-right-start-on-rectangle-20-solid"
                                        class="w-4 h-4 mr-3"></iconify-icon>
                                    Keluar
                                </button>
                            </form>
                        @else
                            <div class="px-4 py-3">
                                <a href="{{ route('login') }}" class="text-sm text-indigo-600 hover:text-indigo-500">
                                    Masuk ke Sistem
                                </a>
                            </div>
                        @endauth
                    </div>
                </div>
            </div>
        </div>
    </div>
</header>
