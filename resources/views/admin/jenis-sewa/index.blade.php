@extends('layouts.admin')

@section('title', 'Manajemen Jenis Sewa')

@section('content')
    <!-- Header -->
    <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-sm border border-gray-200 dark:border-gray-700 p-6 mb-6">
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-2xl font-bold text-gray-900 dark:text-white">Manajemen Jenis Sewa</h1>
                <p class="text-sm text-gray-600 dark:text-gray-400">Kelola jenis-jenis layanan rental mobil</p>
            </div>
            <a href="{{ route('admin.jenis-sewa.create') }}"
                class="inline-flex items-center px-4 py-2 bg-indigo-600 hover:bg-indigo-700 text-white text-sm font-medium rounded-xl transition-colors duration-200">
                <iconify-icon icon="heroicons:plus-20-solid" class="w-4 h-4 mr-2"></iconify-icon>
                Tambah Jenis Sewa
            </a>
        </div>
    </div>

    <!-- Stats Cards -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-6">
        <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-sm border border-gray-200 dark:border-gray-700 p-6">
            <div class="flex items-center">
                <div class="p-2 bg-indigo-100 dark:bg-indigo-900/50 rounded-xl">
                    <iconify-icon icon="heroicons:document-text-20-solid"
                        class="w-6 h-6 text-indigo-600 dark:text-indigo-400"></iconify-icon>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-gray-600 dark:text-gray-400">Total Jenis Sewa</p>
                    <p class="text-2xl font-bold text-gray-900 dark:text-white">{{ number_format($stats['total']) }}</p>
                </div>
            </div>
        </div>

        <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-sm border border-gray-200 dark:border-gray-700 p-6">
            <div class="flex items-center">
                <div class="p-2 bg-green-100 dark:bg-green-900/50 rounded-xl">
                    <iconify-icon icon="heroicons:check-circle-20-solid"
                        class="w-6 h-6 text-green-600 dark:text-green-400"></iconify-icon>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-gray-600 dark:text-gray-400">Jenis Aktif</p>
                    <p class="text-2xl font-bold text-gray-900 dark:text-white">{{ number_format($stats['aktif']) }}</p>
                </div>
            </div>
        </div>

        <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-sm border border-gray-200 dark:border-gray-700 p-6">
            <div class="flex items-center">
                <div class="p-2 bg-orange-100 dark:bg-orange-900/50 rounded-xl">
                    <iconify-icon icon="heroicons:exclamation-triangle-20-solid"
                        class="w-6 h-6 text-orange-600 dark:text-orange-400"></iconify-icon>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-gray-600 dark:text-gray-400">Dengan Denda</p>
                    <p class="text-2xl font-bold text-gray-900 dark:text-white">{{ number_format($stats['dengan_denda']) }}
                    </p>
                </div>
            </div>
        </div>

        <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-sm border border-gray-200 dark:border-gray-700 p-6">
            <div class="flex items-center">
                <div class="p-2 bg-blue-100 dark:bg-blue-900/50 rounded-xl">
                    <iconify-icon icon="heroicons:shield-check-20-solid"
                        class="w-6 h-6 text-blue-600 dark:text-blue-400"></iconify-icon>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-gray-600 dark:text-gray-400">Tanpa Denda</p>
                    <p class="text-2xl font-bold text-gray-900 dark:text-white">{{ number_format($stats['tanpa_denda']) }}
                    </p>
                </div>
            </div>
        </div>
    </div>

    <!-- Search and Filter -->
    <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-sm border border-gray-200 dark:border-gray-700 p-6 mb-6">
        <form method="GET" action="{{ route('admin.jenis-sewa.index') }}" class="flex flex-col md:flex-row gap-4">
            <!-- Search -->
            <div class="flex-1">
                <div class="relative">
                    <input type="text" name="search" value="{{ request('search') }}"
                        placeholder="Cari berdasarkan nama jenis atau deskripsi..."
                        class="w-full px-4 py-3 pl-10 pr-4 text-sm bg-gray-50 dark:bg-gray-700 border border-gray-200 dark:border-gray-600 rounded-xl focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition-colors duration-200">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <iconify-icon icon="heroicons:magnifying-glass-20-solid"
                            class="w-4 h-4 text-gray-400"></iconify-icon>
                    </div>
                </div>
            </div>

            <!-- Actions -->
            <div class="flex gap-3">
                <button type="submit"
                    class="px-4 py-2 bg-indigo-600 hover:bg-indigo-700 text-white text-sm font-medium rounded-xl transition-colors duration-200">
                    Cari
                </button>

                @if (request()->hasAny(['search']))
                    <a href="{{ route('admin.jenis-sewa.index') }}"
                        class="px-4 py-2 bg-gray-500 hover:bg-gray-600 text-white text-sm font-medium rounded-xl transition-colors duration-200">
                        Hapus Filter
                    </a>
                @endif
            </div>
        </form>
    </div>

    <!-- Table Card -->
    <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-sm border border-gray-200 dark:border-gray-700">
        <!-- Header -->
        <div class="px-6 py-4 border-b border-gray-200 dark:border-gray-700">
            <div class="flex items-center justify-between">
                <div>
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-white">Daftar Jenis Sewa</h3>
                    <p class="text-sm text-gray-600 dark:text-gray-400">Template layanan rental yang tersedia</p>
                </div>
            </div>
        </div>

        <!-- Table -->
        <div class="overflow-x-auto">
            <table class="w-full divide-y divide-gray-200 dark:divide-gray-700">
                <thead class="bg-gray-50 dark:bg-gray-700">
                    <tr>
                        <th
                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                            Jenis Sewa</th>
                        <th
                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                            Deskripsi</th>
                        <th
                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                            Tarif Denda</th>
                        <th
                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                            Total Mobil</th>
                        <th
                            class="px-6 py-3 text-right text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                            Aksi</th>
                    </tr>
                </thead>
                <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                    @forelse ($jenisSewa as $jenis)
                        <tr class="hover:bg-gray-50 dark:hover:bg-gray-700/50 transition-colors duration-200">
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="flex items-center">
                                    <div
                                        class="flex-shrink-0 w-10 h-10 bg-gradient-to-br from-indigo-500 to-purple-600 rounded-xl flex items-center justify-center">
                                        <iconify-icon icon="heroicons:document-text-20-solid"
                                            class="w-5 h-5 text-white"></iconify-icon>
                                    </div>
                                    <div class="ml-4">
                                        <div class="text-sm font-medium text-gray-900 dark:text-white">
                                            {{ $jenis->nama_jenis }}</div>
                                        <div class="text-sm text-gray-500 dark:text-gray-400">{{ $jenis->slug }}</div>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4">
                                <div class="text-sm text-gray-900 dark:text-white max-w-xs truncate"
                                    title="{{ $jenis->deskripsi }}">
                                    {{ $jenis->deskripsi ?: '-' }}
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                @if ($jenis->tarif_denda_per_hari)
                                    <span
                                        class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-orange-100 text-orange-800 dark:bg-orange-900 dark:text-orange-200">
                                        <iconify-icon icon="heroicons:exclamation-triangle-20-solid"
                                            class="w-3 h-3 mr-1"></iconify-icon>
                                        Rp {{ number_format($jenis->tarif_denda_per_hari, 0, ',', '.') }}/hari
                                    </span>
                                @else
                                    <span
                                        class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200">
                                        <iconify-icon icon="heroicons:shield-check-20-solid"
                                            class="w-3 h-3 mr-1"></iconify-icon>
                                        Tanpa Denda
                                    </span>
                                @endif
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm font-medium text-gray-900 dark:text-white">
                                    {{ $jenis->total_mobil }} Mobil
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                <div class="flex items-center justify-end space-x-2">
                                    <a href="{{ route('admin.jenis-sewa.show', $jenis) }}"
                                        class="text-gray-400 hover:text-gray-600 dark:hover:text-gray-300"
                                        title="Lihat Detail">
                                        <iconify-icon icon="heroicons:eye-20-solid" class="w-4 h-4"></iconify-icon>
                                    </a>
                                    <a href="{{ route('admin.jenis-sewa.edit', $jenis) }}"
                                        class="text-indigo-600 hover:text-indigo-900 dark:text-indigo-400 dark:hover:text-indigo-300"
                                        title="Edit">
                                        <iconify-icon icon="heroicons:pencil-20-solid" class="w-4 h-4"></iconify-icon>
                                    </a>
                                    <form method="POST" action="{{ route('admin.jenis-sewa.destroy', $jenis) }}"
                                        onsubmit="return confirm('Apakah Anda yakin ingin menghapus jenis sewa ini?')"
                                        class="inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit"
                                            class="text-red-600 hover:text-red-900 dark:text-red-400 dark:hover:text-red-300"
                                            title="Hapus">
                                            <iconify-icon icon="heroicons:trash-20-solid" class="w-4 h-4"></iconify-icon>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-6 py-12 text-center">
                                <div class="flex flex-col items-center">
                                    <iconify-icon icon="heroicons:document-text-20-solid"
                                        class="w-12 h-12 text-gray-400 mb-4"></iconify-icon>
                                    <h3 class="text-sm font-medium text-gray-900 dark:text-white mb-1">Tidak ada jenis sewa
                                    </h3>
                                    <p class="text-sm text-gray-500 dark:text-gray-400 mb-4">Mulai dengan menambahkan jenis
                                        sewa pertama</p>
                                    <a href="{{ route('admin.jenis-sewa.create') }}"
                                        class="inline-flex items-center px-4 py-2 bg-indigo-600 hover:bg-indigo-700 text-white text-sm font-medium rounded-xl transition-colors duration-200">
                                        <iconify-icon icon="heroicons:plus-20-solid" class="w-4 h-4 mr-2"></iconify-icon>
                                        Tambah Jenis Sewa
                                    </a>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if ($jenisSewa->hasPages())
            <div class="px-6 py-4 border-t border-gray-200 dark:border-gray-700">
                {{ $jenisSewa->appends(request()->query())->links() }}
            </div>
        @endif
    </div>
@endsection
