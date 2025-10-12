<div class="fixed inset-y-0 left-0 z-50 w-64 bg-white dark:bg-gray-800 shadow-xl transform transition-transform duration-300 lg:translate-x-0 flex flex-col"
    :class="{ '-translate-x-full': !sidebarOpen, 'translate-x-0': sidebarOpen }">

    <!-- Logo -->
    <div class="flex items-center justify-center h-20 px-6 bg-indigo-600 dark:bg-indigo-700">
        <div class="flex items-center space-x-2">
            <iconify-icon icon="heroicons:bolt-solid" width="32" height="32"
                class="w-8 h-8 text-white flex items-center justify-center"></iconify-icon>
            <h1 class="text-xl font-bold text-white">TJ Rent Car</h1>
        </div>
    </div>

    <!-- Navigation -->
    <nav class="flex-1 overflow-y-auto">
        <div class="px-4 py-6 space-y-6">

            <!-- Main Menu -->
            <div>
                <!-- Dashboard -->
                <a href="{{ route('admin.dashboard') }}"
                    class="flex items-center px-2 py-2 text-gray-700 dark:text-gray-200 rounded-lg hover:bg-indigo-50 dark:hover:bg-gray-700 hover:text-indigo-600 dark:hover:text-indigo-400 transition-all duration-200 group {{ request()->routeIs('admin.dashboard') ? 'bg-indigo-100 dark:bg-indigo-900/50 text-indigo-700 dark:text-indigo-300 shadow-sm' : '' }}">
                    <div
                        class="flex items-center justify-center w-8 h-8 rounded-lg {{ request()->routeIs('admin.dashboard') ? 'bg-indigo-500 text-white' : 'bg-gray-100 dark:bg-gray-700 text-gray-600 dark:text-gray-400 group-hover:bg-indigo-500 group-hover:text-white' }} transition-colors duration-200">
                        <iconify-icon icon="heroicons:home-20-solid" class="w-5 h-5"></iconify-icon>
                    </div>
                    <span class="ml-3 font-medium">Dashboard</span>
                </a>
            </div>

            <!-- Master Data -->
            <div>
                <h3 class="px-2 text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider mb-3">
                    Master Data
                </h3>
                <div class="space-y-1">
                    <!-- Pengguna -->
                    <a href="#"
                        class="flex items-center px-2 py-2 text-gray-700 dark:text-gray-200 rounded-lg hover:bg-indigo-50 dark:hover:bg-gray-700 hover:text-indigo-600 dark:hover:text-indigo-400 transition-all duration-200 group">
                        <div
                            class="flex items-center justify-center w-8 h-8 rounded-lg bg-gray-100 dark:bg-gray-700 text-gray-600 dark:text-gray-400 group-hover:bg-indigo-500 group-hover:text-white transition-colors duration-200">
                            <iconify-icon icon="heroicons:users-20-solid" class="w-5 h-5"></iconify-icon>
                        </div>
                        <span class="ml-3 font-medium">Pengguna</span>
                    </a>
                    <!-- Pelanggan -->
                    <a href="#"
                        class="flex items-center px-2 py-2 text-gray-700 dark:text-gray-200 rounded-lg hover:bg-indigo-50 dark:hover:bg-gray-700 hover:text-indigo-600 dark:hover:text-indigo-400 transition-all duration-200 group">
                        <div
                            class="flex items-center justify-center w-8 h-8 rounded-lg bg-gray-100 dark:bg-gray-700 text-gray-600 dark:text-gray-400 group-hover:bg-indigo-500 group-hover:text-white transition-colors duration-200">
                            <iconify-icon icon="heroicons:user-group-20-solid" class="w-5 h-5"></iconify-icon>
                        </div>
                        <span class="ml-3 font-medium">Pelanggan</span>
                    </a>

                    <!-- Mobil -->
                    <a href="{{ route('admin.cars.index') }}"
                        class="flex items-center px-2 py-2 text-gray-700 dark:text-gray-200 rounded-lg hover:bg-indigo-50 dark:hover:bg-gray-700 hover:text-indigo-600 dark:hover:text-indigo-400 transition-all duration-200 group {{ request()->routeIs('admin.cars.*') ? 'bg-indigo-100 dark:bg-indigo-900/50 text-indigo-700 dark:text-indigo-300 shadow-sm' : '' }}">
                        <div
                            class="flex items-center justify-center w-8 h-8 rounded-lg {{ request()->routeIs('admin.cars.*') ? 'bg-indigo-500 text-white' : 'bg-gray-100 dark:bg-gray-700 text-gray-600 dark:text-gray-400 group-hover:bg-indigo-500 group-hover:text-white' }} transition-colors duration-200">
                            <iconify-icon icon="heroicons:truck-20-solid" class="w-5 h-5"></iconify-icon>
                        </div>
                        <span class="ml-3 font-medium">Mobil</span>
                    </a>

                    <!-- Sopir -->
                    <a href="#"
                        class="flex items-center px-2 py-2 text-gray-700 dark:text-gray-200 rounded-lg hover:bg-indigo-50 dark:hover:bg-gray-700 hover:text-indigo-600 dark:hover:text-indigo-400 transition-all duration-200 group">
                        <div
                            class="flex items-center justify-center w-8 h-8 rounded-lg bg-gray-100 dark:bg-gray-700 text-gray-600 dark:text-gray-400 group-hover:bg-indigo-500 group-hover:text-white transition-colors duration-200">
                            <iconify-icon icon="heroicons:identification-20-solid" class="w-5 h-5"></iconify-icon>
                        </div>
                        <span class="ml-3 font-medium">Sopir</span>
                    </a>

                    <!-- Harga Sewa -->
                    <a href="#"
                        class="flex items-center px-2 py-2 text-gray-700 dark:text-gray-200 rounded-lg hover:bg-indigo-50 dark:hover:bg-gray-700 hover:text-indigo-600 dark:hover:text-indigo-400 transition-all duration-200 group">
                        <div
                            class="flex items-center justify-center w-8 h-8 rounded-lg bg-gray-100 dark:bg-gray-700 text-gray-600 dark:text-gray-400 group-hover:bg-indigo-500 group-hover:text-white transition-colors duration-200">
                            <iconify-icon icon="heroicons:currency-dollar-20-solid" class="w-5 h-5"></iconify-icon>
                        </div>
                        <span class="ml-3 font-medium">Harga Sewa</span>
                    </a>

                    <!-- Jadwal Mobil -->
                    <a href="#"
                        class="flex items-center px-2 py-2 text-gray-700 dark:text-gray-200 rounded-lg hover:bg-indigo-50 dark:hover:bg-gray-700 hover:text-indigo-600 dark:hover:text-indigo-400 transition-all duration-200 group">
                        <div
                            class="flex items-center justify-center w-8 h-8 rounded-lg bg-gray-100 dark:bg-gray-700 text-gray-600 dark:text-gray-400 group-hover:bg-indigo-500 group-hover:text-white transition-colors duration-200">
                            <iconify-icon icon="heroicons:calendar-days-20-solid" class="w-5 h-5"></iconify-icon>
                        </div>
                        <span class="ml-3 font-medium">Jadwal Mobil</span>
                    </a>
                </div>
            </div>

            <!-- Transaksi -->
            <div>
                <h3 class="px-2 text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider mb-3">
                    Transaksi
                </h3>
                <div class="space-y-1">
                    <!-- Rental -->
                    <a href="#"
                        class="flex items-center px-2 py-2 text-gray-700 dark:text-gray-200 rounded-lg hover:bg-indigo-50 dark:hover:bg-gray-700 hover:text-indigo-600 dark:hover:text-indigo-400 transition-all duration-200 group">
                        <div
                            class="flex items-center justify-center w-8 h-8 rounded-lg bg-gray-100 dark:bg-gray-700 text-gray-600 dark:text-gray-400 group-hover:bg-indigo-500 group-hover:text-white transition-colors duration-200">
                            <iconify-icon icon="heroicons:clipboard-document-list-20-solid"
                                class="w-5 h-5"></iconify-icon>
                        </div>
                        <span class="ml-3 font-medium">Rental</span>
                    </a>

                    <!-- Pembayaran -->
                    <a href="#"
                        class="flex items-center px-2 py-2 text-gray-700 dark:text-gray-200 rounded-lg hover:bg-indigo-50 dark:hover:bg-gray-700 hover:text-indigo-600 dark:hover:text-indigo-400 transition-all duration-200 group">
                        <div
                            class="flex items-center justify-center w-8 h-8 rounded-lg bg-gray-100 dark:bg-gray-700 text-gray-600 dark:text-gray-400 group-hover:bg-indigo-500 group-hover:text-white transition-colors duration-200">
                            <iconify-icon icon="heroicons:credit-card-20-solid" class="w-5 h-5"></iconify-icon>
                        </div>
                        <span class="ml-3 font-medium">Pembayaran</span>
                    </a>

                    <!-- Pengembalian -->
                    <a href="#"
                        class="flex items-center px-2 py-2 text-gray-700 dark:text-gray-200 rounded-lg hover:bg-indigo-50 dark:hover:bg-gray-700 hover:text-indigo-600 dark:hover:text-indigo-400 transition-all duration-200 group">
                        <div
                            class="flex items-center justify-center w-8 h-8 rounded-lg bg-gray-100 dark:bg-gray-700 text-gray-600 dark:text-gray-400 group-hover:bg-indigo-500 group-hover:text-white transition-colors duration-200">
                            <iconify-icon icon="heroicons:arrow-uturn-left-20-solid" class="w-5 h-5"></iconify-icon>
                        </div>
                        <span class="ml-3 font-medium">Pengembalian</span>
                    </a>
                </div>
            </div>

            <!-- Laporan -->
            <div>
                <h3 class="px-2 text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider mb-3">
                    Laporan
                </h3>
                <div class="space-y-1">
                    <!-- Laporan Transaksi -->
                    <a href="#"
                        class="flex items-center px-2 py-2 text-gray-700 dark:text-gray-200 rounded-lg hover:bg-indigo-50 dark:hover:bg-gray-700 hover:text-indigo-600 dark:hover:text-indigo-400 transition-all duration-200 group">
                        <div
                            class="flex items-center justify-center w-8 h-8 rounded-lg bg-gray-100 dark:bg-gray-700 text-gray-600 dark:text-gray-400 group-hover:bg-indigo-500 group-hover:text-white transition-colors duration-200">
                            <iconify-icon icon="heroicons:chart-bar-20-solid" class="w-5 h-5"></iconify-icon>
                        </div>
                        <span class="ml-3 font-medium">Laporan Transaksi</span>
                    </a>

                    <!-- Laporan Pelanggan -->
                    <a href="#"
                        class="flex items-center px-2 py-2 text-gray-700 dark:text-gray-200 rounded-lg hover:bg-indigo-50 dark:hover:bg-gray-700 hover:text-indigo-600 dark:hover:text-indigo-400 transition-all duration-200 group">
                        <div
                            class="flex items-center justify-center w-8 h-8 rounded-lg bg-gray-100 dark:bg-gray-700 text-gray-600 dark:text-gray-400 group-hover:bg-indigo-500 group-hover:text-white transition-colors duration-200">
                            <iconify-icon icon="heroicons:user-group-20-solid" class="w-5 h-5"></iconify-icon>
                        </div>
                        <span class="ml-3 font-medium">Laporan Pelanggan</span>
                    </a>

                    <!-- Laporan Keuangan -->
                    <a href="#"
                        class="flex items-center px-2 py-2 text-gray-700 dark:text-gray-200 rounded-lg hover:bg-indigo-50 dark:hover:bg-gray-700 hover:text-indigo-600 dark:hover:text-indigo-400 transition-all duration-200 group">
                        <div
                            class="flex items-center justify-center w-8 h-8 rounded-lg bg-gray-100 dark:bg-gray-700 text-gray-600 dark:text-gray-400 group-hover:bg-indigo-500 group-hover:text-white transition-colors duration-200">
                            <iconify-icon icon="heroicons:banknotes-20-solid" class="w-5 h-5"></iconify-icon>
                        </div>
                        <span class="ml-3 font-medium">Laporan Keuangan</span>
                    </a>

                    <!-- Laporan Statistik -->
                    <a href="#"
                        class="flex items-center px-2 py-2 text-gray-700 dark:text-gray-200 rounded-lg hover:bg-indigo-50 dark:hover:bg-gray-700 hover:text-indigo-600 dark:hover:text-indigo-400 transition-all duration-200 group">
                        <div
                            class="flex items-center justify-center w-8 h-8 rounded-lg bg-gray-100 dark:bg-gray-700 text-gray-600 dark:text-gray-400 group-hover:bg-indigo-500 group-hover:text-white transition-colors duration-200">
                            <iconify-icon icon="heroicons:chart-bar-20-solid" class="w-5 h-5"></iconify-icon>
                        </div>
                        <span class="ml-3 font-medium">Laporan Statistik</span>
                    </a>

                    <!-- Laporan Mobil -->
                    <a href="#"
                        class="flex items-center px-2 py-2 text-gray-700 dark:text-gray-200 rounded-lg hover:bg-indigo-50 dark:hover:bg-gray-700 hover:text-indigo-600 dark:hover:text-indigo-400 transition-all duration-200 group">
                        <div
                            class="flex items-center justify-center w-8 h-8 rounded-lg bg-gray-100 dark:bg-gray-700 text-gray-600 dark:text-gray-400 group-hover:bg-indigo-500 group-hover:text-white transition-colors duration-200">
                            <iconify-icon icon="heroicons:document-chart-bar-20-solid" class="w-5 h-5"></iconify-icon>
                        </div>
                        <span class="ml-3 font-medium">Laporan Mobil</span>
                    </a>
                </div>
            </div>

            <!-- Sistem -->
            <div>
                <h3 class="px-2 text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider mb-3">
                    Sistem
                </h3>
                <div class="space-y-1">
                    <!-- Pengguna -->
                    <a href="#"
                        class="flex items-center px-2 py-2 text-gray-700 dark:text-gray-200 rounded-lg hover:bg-indigo-50 dark:hover:bg-gray-700 hover:text-indigo-600 dark:hover:text-indigo-400 transition-all duration-200 group">
                        <div
                            class="flex items-center justify-center w-8 h-8 rounded-lg bg-gray-100 dark:bg-gray-700 text-gray-600 dark:text-gray-400 group-hover:bg-indigo-500 group-hover:text-white transition-colors duration-200">
                            <iconify-icon icon="heroicons:users-20-solid" class="w-5 h-5"></iconify-icon>
                        </div>
                        <span class="ml-3 font-medium">Pengguna</span>
                    </a>

                    <!-- Pengaturan -->
                    <a href="#"
                        class="flex items-center px-2 py-2 text-gray-700 dark:text-gray-200 rounded-lg hover:bg-indigo-50 dark:hover:bg-gray-700 hover:text-indigo-600 dark:hover:text-indigo-400 transition-all duration-200 group">
                        <div
                            class="flex items-center justify-center w-8 h-8 rounded-lg bg-gray-100 dark:bg-gray-700 text-gray-600 dark:text-gray-400 group-hover:bg-indigo-500 group-hover:text-white transition-colors duration-200">
                            <iconify-icon icon="heroicons:cog-6-tooth-20-solid" class="w-5 h-5"></iconify-icon>
                        </div>
                        <span class="ml-3 font-medium">Pengaturan</span>
                    </a>

                    <!-- Backup Data -->
                    <a href="#"
                        class="flex items-center px-2 py-2 text-gray-700 dark:text-gray-200 rounded-lg hover:bg-indigo-50 dark:hover:bg-gray-700 hover:text-indigo-600 dark:hover:text-indigo-400 transition-all duration-200 group">
                        <div
                            class="flex items-center justify-center w-8 h-8 rounded-lg bg-gray-100 dark:bg-gray-700 text-gray-600 dark:text-gray-400 group-hover:bg-indigo-500 group-hover:text-white transition-colors duration-200">
                            <iconify-icon icon="heroicons:cloud-arrow-down-20-solid" class="w-5 h-5"></iconify-icon>
                        </div>
                        <span class="ml-3 font-medium">Backup Data</span>
                    </a>

                    <!-- Restore Data -->
                    <a href="#"
                        class="flex items-center px-2 py-2 text-gray-700 dark:text-gray-200 rounded-lg hover:bg-indigo-50 dark:hover:bg-gray-700 hover:text-indigo-600 dark:hover:text-indigo-400 transition-all duration-200 group">
                        <div
                            class="flex items-center justify-center w-8 h-8 rounded-lg bg-gray-100 dark:bg-gray-700 text-gray-600 dark:text-gray-400 group-hover:bg-indigo-500 group-hover:text-white transition-colors duration-200">
                            <iconify-icon icon="heroicons:cloud-arrow-up-20-solid" class="w-5 h-5"></iconify-icon>
                        </div>
                        <span class="ml-3 font-medium">Restore Data</span>
                    </a>

                    <!-- Log Sistem -->
                    <a href="#"
                        class="flex items-center px-2 py-2 text-gray-700 dark:text-gray-200 rounded-lg hover:bg-indigo-50 dark:hover:bg-gray-700 hover:text-indigo-600 dark:hover:text-indigo-400 transition-all duration-200 group">
                        <div
                            class="flex items-center justify-center w-8 h-8 rounded-lg bg-gray-100 dark:bg-gray-700 text-gray-600 dark:text-gray-400 group-hover:bg-indigo-500 group-hover:text-white transition-colors duration-200">
                            <iconify-icon icon="heroicons:document-text-20-solid" class="w-5 h-5"></iconify-icon>
                        </div>
                        <span class="ml-3 font-medium">Log Sistem</span>
                    </a>
                </div>
            </div>
        </div>

        <!-- Bottom padding for better scroll -->
        <div class="pb-6"></div>
    </nav>
</div>
