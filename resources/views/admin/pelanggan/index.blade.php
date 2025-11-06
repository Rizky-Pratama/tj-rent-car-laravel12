@extends('layouts.admin')

@section('title', 'Manajemen Pelanggan')

@section('content')
    <!-- Header -->
    <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-sm border border-gray-200 dark:border-gray-700 p-6 mb-6">
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-2xl font-bold text-gray-900 dark:text-white">Manajemen Pelanggan</h1>
                <p class="text-sm text-gray-600 dark:text-gray-400">Kelola data pelanggan rental mobil</p>
            </div>
            <a href="{{ route('admin.pelanggan.create') }}"
                class="inline-flex items-center px-4 py-2 bg-indigo-600 hover:bg-indigo-700 text-white text-sm font-medium rounded-xl transition-colors duration-200">
                <iconify-icon icon="heroicons:plus-20-solid" class="w-4 h-4 mr-2"></iconify-icon>
                Tambah Pelanggan Baru
            </a>
        </div>
    </div>

    <!-- Stats Cards -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-6">
        <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-sm border border-gray-200 dark:border-gray-700 p-6">
            <div class="flex items-center">
                <div class="p-2 bg-indigo-100 dark:bg-indigo-900/50 rounded-xl">
                    <iconify-icon icon="heroicons:users-20-solid"
                        class="w-6 h-6 text-indigo-600 dark:text-indigo-400"></iconify-icon>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-gray-600 dark:text-gray-400">Total Pelanggan</p>
                    <p class="text-2xl font-bold text-gray-900 dark:text-white">{{ number_format($stats['total']) }}</p>
                </div>
            </div>
        </div>

        <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-sm border border-gray-200 dark:border-gray-700 p-6">
            <div class="flex items-center">
                <div class="p-2 bg-blue-100 dark:bg-blue-900/50 rounded-xl">
                    <iconify-icon icon="heroicons:user-20-solid"
                        class="w-6 h-6 text-blue-600 dark:text-blue-400"></iconify-icon>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-gray-600 dark:text-gray-400">Laki-laki</p>
                    <p class="text-2xl font-bold text-gray-900 dark:text-white">{{ number_format($stats['pria']) }}</p>
                </div>
            </div>
        </div>

        <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-sm border border-gray-200 dark:border-gray-700 p-6">
            <div class="flex items-center">
                <div class="p-2 bg-pink-100 dark:bg-pink-900/50 rounded-xl">
                    <iconify-icon icon="heroicons:user-20-solid"
                        class="w-6 h-6 text-pink-600 dark:text-pink-400"></iconify-icon>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-gray-600 dark:text-gray-400">Perempuan</p>
                    <p class="text-2xl font-bold text-gray-900 dark:text-white">{{ number_format($stats['wanita']) }}</p>
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
                    <p class="text-sm font-medium text-gray-600 dark:text-gray-400">Pelanggan Aktif</p>
                    <p class="text-2xl font-bold text-gray-900 dark:text-white">{{ number_format($stats['aktif']) }}</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Search and Filter Bar -->
    <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-sm border border-gray-100 dark:border-gray-700 p-6 mb-6">
        <form method="GET" action="{{ route('admin.pelanggan.index') }}" class="flex flex-col md:flex-row gap-4">
            <!-- Search -->
            <div class="flex-1">
                <div class="relative">
                    <input type="text" name="search" value="{{ request('search') }}"
                        placeholder="Cari berdasarkan nama, email, telepon, atau KTP..."
                        class="w-full px-4 py-2 pl-10 pr-4 text-sm bg-gray-50 dark:bg-gray-700 border border-gray-200 dark:border-gray-600 rounded-xl focus:ring-2 focus:ring-indigo-500 dark:focus:ring-indigo-400 focus:border-transparent">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <iconify-icon icon="heroicons:magnifying-glass-20-solid"
                            class="w-4 h-4 text-gray-400"></iconify-icon>
                    </div>
                </div>
            </div>

            <!-- Filters -->
            <div class="flex gap-3">
                <select name="jenis_kelamin"
                    class="px-3 py-2 text-sm bg-gray-50 dark:bg-gray-700 border border-gray-200 dark:border-gray-600 rounded-xl focus:ring-2 focus:ring-indigo-500">
                    <option value="">Semua Jenis Kelamin</option>
                    <option value="laki-laki" {{ request('jenis_kelamin') == 'laki-laki' ? 'selected' : '' }}>Laki-laki
                    </option>
                    <option value="perempuan" {{ request('jenis_kelamin') == 'perempuan' ? 'selected' : '' }}>Perempuan
                    </option>
                </select>

                <button type="submit"
                    class="px-4 py-2 bg-indigo-600 hover:bg-indigo-700 text-white text-sm font-medium rounded-xl transition-colors duration-200">
                    Filter
                </button>

                @if (request()->hasAny(['search', 'jenis_kelamin']))
                    <a href="{{ route('admin.pelanggan.index') }}"
                        class="px-4 py-2 bg-gray-500 hover:bg-gray-600 text-white text-sm font-medium rounded-xl transition-colors duration-200">
                        Reset
                    </a>
                @endif
            </div>
        </form>
    </div>

    <!-- Action Bar -->
    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4 mb-6">
        <div class="flex items-center gap-3">
            <div class="flex items-center gap-2">
                <iconify-icon icon="heroicons:user-group-20-solid"
                    class="w-5 h-5 text-gray-600 dark:text-gray-400"></iconify-icon>
                <span class="text-sm text-gray-600 dark:text-gray-400">
                    {{ $pelanggan->total() }} pelanggan ditemukan
                </span>
            </div>
        </div>

        <a href="{{ route('admin.pelanggan.create') }}"
            class="inline-flex items-center px-4 py-2 bg-gradient-to-r from-indigo-500 to-purple-600 hover:from-indigo-600 hover:to-purple-700 text-white text-sm font-medium rounded-xl transition-all duration-200 shadow-lg hover:shadow-xl">
            <iconify-icon icon="heroicons:plus-20-solid" class="w-4 h-4 mr-2"></iconify-icon>
            Tambah Pelanggan
        </a>
    </div>

    <!-- Pelanggan Table -->
    <div
        class="bg-white dark:bg-gray-800 rounded-2xl shadow-sm border border-gray-100 dark:border-gray-700 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead class="bg-gray-50 dark:bg-gray-700 border-b border-gray-200 dark:border-gray-600">
                    <tr>
                        <th
                            class="px-6 py-4 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">
                            Pelanggan
                        </th>
                        <th
                            class="px-6 py-4 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">
                            Kontak
                        </th>
                        <th
                            class="px-6 py-4 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">
                            Identitas
                        </th>
                        <th
                            class="px-6 py-4 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">
                            Info Personal
                        </th>
                        <th
                            class="px-6 py-4 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">
                            Terdaftar
                        </th>
                        <th
                            class="px-6 py-4 text-right text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">
                            Aksi
                        </th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200 dark:divide-gray-700">
                    @forelse ($pelanggan as $customer)
                        <tr class="hover:bg-gray-50 dark:hover:bg-gray-700/50 transition-colors duration-150">
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="flex items-center">
                                    <div class="flex-shrink-0 h-10 w-10">
                                        <div
                                            class="h-10 w-10 rounded-full bg-gradient-to-r from-green-500 to-blue-600 flex items-center justify-center">
                                            <span class="text-sm font-medium text-white">
                                                {{ substr($customer->nama, 0, 2) }}
                                            </span>
                                        </div>
                                    </div>
                                    <div class="ml-4">
                                        <div class="text-sm font-medium text-gray-900 dark:text-white">
                                            {{ $customer->nama }}
                                        </div>
                                        <div class="text-sm text-gray-500 dark:text-gray-400">
                                            {{ $customer->email }}
                                        </div>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm text-gray-900 dark:text-white">{{ $customer->telepon }}</div>
                                <div class="text-sm text-gray-500 dark:text-gray-400 truncate max-w-xs">
                                    {{ $customer->alamat }}</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm text-gray-900 dark:text-white">KTP: {{ $customer->no_ktp }}</div>
                                <div class="text-sm text-gray-500 dark:text-gray-400">SIM: {{ $customer->no_sim ?? '-' }}
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm text-gray-900 dark:text-white">
                                    {{ $customer->jenis_kelamin ? ucfirst($customer->jenis_kelamin) : '-' }}
                                </div>
                                <div class="text-sm text-gray-500 dark:text-gray-400">
                                    {{ $customer->tanggal_lahir ? \Carbon\Carbon::parse($customer->tanggal_lahir)->format('d M Y') : '-' }}
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400">
                                {{ $customer->created_at->format('d M Y') }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                <div class="flex items-center justify-end gap-2">
                                    <a href="{{ route('admin.pelanggan.show', $customer) }}"
                                        class="text-indigo-600 hover:text-indigo-900 dark:text-indigo-400 dark:hover:text-indigo-300">
                                        <iconify-icon icon="heroicons:eye-20-solid" class="w-4 h-4"></iconify-icon>
                                    </a>
                                    <a href="{{ route('admin.pelanggan.edit', $customer) }}"
                                        class="text-amber-600 hover:text-amber-900 dark:text-amber-400 dark:hover:text-amber-300">
                                        <iconify-icon icon="heroicons:pencil-20-solid" class="w-4 h-4"></iconify-icon>
                                    </a>
                                    <form method="POST" action="{{ route('admin.pelanggan.destroy', $customer) }}"
                                        onsubmit="return confirm('Yakin ingin menghapus pelanggan ini?')" class="inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit"
                                            class="text-red-600 hover:text-red-900 dark:text-red-400 dark:hover:text-red-300">
                                            <iconify-icon icon="heroicons:trash-20-solid" class="w-4 h-4"></iconify-icon>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-6 py-12 text-center">
                                <div class="flex flex-col items-center">
                                    <iconify-icon icon="heroicons:user-group-20-solid"
                                        class="w-12 h-12 text-gray-400 mb-4"></iconify-icon>
                                    <h3 class="text-sm font-medium text-gray-900 dark:text-white mb-1">Tidak ada pelanggan
                                    </h3>
                                    <p class="text-sm text-gray-500 dark:text-gray-400">Belum ada pelanggan yang terdaftar.
                                    </p>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if ($pelanggan->hasPages())
            <div class="border-t border-gray-200 dark:border-gray-700 px-6 py-3">
                {{ $pelanggan->links() }}
            </div>
        @endif
    </div>
@endsection
