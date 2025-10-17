@extends('layouts.admin')

@section('title', 'Manajemen Sopir')
@section('page-title', 'Manajemen Sopir')
@section('page-subtitle', 'Kelola data sopir rental mobil')

@section('content')
    <!-- Stats Cards -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
        <!-- Total Sopir -->
        <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-sm border border-gray-100 dark:border-gray-700 p-6">
            <div class="flex items-center">
                <div class="flex-shrink-0">
                    <div class="w-10 h-10 bg-blue-100 dark:bg-blue-900 rounded-lg flex items-center justify-center">
                        <iconify-icon icon="heroicons:user-20-solid"
                            class="w-5 h-5 text-blue-600 dark:text-blue-400"></iconify-icon>
                    </div>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-gray-600 dark:text-gray-400">Total Sopir</p>
                    <p class="text-2xl font-semibold text-gray-900 dark:text-white">{{ $stats['total'] }}</p>
                </div>
            </div>
        </div>

        <!-- Sopir Tersedia -->
        <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-sm border border-gray-100 dark:border-gray-700 p-6">
            <div class="flex items-center">
                <div class="flex-shrink-0">
                    <div class="w-10 h-10 bg-green-100 dark:bg-green-900 rounded-lg flex items-center justify-center">
                        <iconify-icon icon="heroicons:check-circle-20-solid"
                            class="w-5 h-5 text-green-600 dark:text-green-400"></iconify-icon>
                    </div>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-gray-600 dark:text-gray-400">Tersedia</p>
                    <p class="text-2xl font-semibold text-gray-900 dark:text-white">{{ $stats['available'] }}</p>
                </div>
            </div>
        </div>

        <!-- Sopir Ditugaskan -->
        <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-sm border border-gray-100 dark:border-gray-700 p-6">
            <div class="flex items-center">
                <div class="flex-shrink-0">
                    <div class="w-10 h-10 bg-orange-100 dark:bg-orange-900 rounded-lg flex items-center justify-center">
                        <iconify-icon icon="heroicons:briefcase-20-solid"
                            class="w-5 h-5 text-orange-600 dark:text-orange-400"></iconify-icon>
                    </div>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-gray-600 dark:text-gray-400">Ditugaskan</p>
                    <p class="text-2xl font-semibold text-gray-900 dark:text-white">{{ $stats['assigned'] }}</p>
                </div>
            </div>
        </div>

        <!-- Sopir Libur -->
        <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-sm border border-gray-100 dark:border-gray-700 p-6">
            <div class="flex items-center">
                <div class="flex-shrink-0">
                    <div class="w-10 h-10 bg-gray-100 dark:bg-gray-700 rounded-lg flex items-center justify-center">
                        <iconify-icon icon="heroicons:calendar-days-20-solid"
                            class="w-5 h-5 text-gray-600 dark:text-gray-400"></iconify-icon>
                    </div>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-gray-600 dark:text-gray-400">Libur</p>
                    <p class="text-2xl font-semibold text-gray-900 dark:text-white">{{ $stats['on_leave'] }}</p>
                </div>
            </div>
        </div>
    </div>
    <!-- Search and Filter Bar -->
    <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-sm border border-gray-100 dark:border-gray-700 p-6 mb-6">
        <form method="GET" action="{{ route('admin.sopir.index') }}" class="flex flex-col md:flex-row gap-4">
            <!-- Search -->
            <div class="flex-1">
                <div class="relative">
                    <input type="text" name="search" value="{{ request('search') }}"
                        placeholder="Cari sopir berdasarkan nama, telepon, atau nomor SIM..."
                        class="w-full px-4 py-2 pl-10 pr-4 text-sm bg-gray-50 dark:bg-gray-700 border border-gray-200 dark:border-gray-600 rounded-xl focus:ring-2 focus:ring-indigo-500 dark:focus:ring-indigo-400 focus:border-transparent">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <iconify-icon icon="heroicons:magnifying-glass-20-solid"
                            class="w-4 h-4 text-gray-400"></iconify-icon>
                    </div>
                </div>
            </div>

            <!-- Filters -->
            <div class="flex gap-3">
                <select name="status"
                    class="px-3 py-2 text-sm bg-gray-50 dark:bg-gray-700 border border-gray-200 dark:border-gray-600 rounded-xl focus:ring-2 focus:ring-indigo-500">
                    <option value="">Semua Status</option>
                    <option value="tersedia" {{ request('status') == 'tersedia' ? 'selected' : '' }}>Tersedia</option>
                    <option value="ditugaskan" {{ request('status') == 'ditugaskan' ? 'selected' : '' }}>Ditugaskan</option>
                    <option value="libur" {{ request('status') == 'libur' ? 'selected' : '' }}>Libur</option>
                </select>

                <button type="submit"
                    class="px-4 py-2 bg-indigo-600 hover:bg-indigo-700 text-white text-sm font-medium rounded-xl transition-colors duration-200">
                    Filter
                </button>

                @if (request()->hasAny(['search', 'status']))
                    <a href="{{ route('admin.sopir.index') }}"
                        class="px-4 py-2 bg-gray-500 hover:bg-gray-600 text-white text-sm font-medium rounded-xl transition-colors duration-200">
                        Reset
                    </a>
                @endif
            </div>
        </form>
    </div>
    <!-- Sopir Table -->
    <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-sm border border-gray-100 dark:border-gray-700">
        <!-- Header -->
        <div class="px-6 py-4 border-b border-gray-200 dark:border-gray-700">
            <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
                <div>
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-white">Tim Sopir</h3>
                    <p class="text-sm text-gray-600 dark:text-gray-400">Kelola data sopir rental mobil</p>
                </div>
                <a href="{{ route('admin.sopir.create') }}"
                    class="inline-flex items-center px-4 py-2 bg-indigo-600 hover:bg-indigo-700 text-white text-sm font-medium rounded-xl transition-colors duration-200">
                    <iconify-icon icon="heroicons:plus-20-solid" class="w-4 h-4 mr-2"></iconify-icon>
                    Tambah Sopir
                </a>
            </div>
        </div>

        <!-- Table -->
        <div class="overflow-x-auto">
            <table class="w-full divide-y divide-gray-200 dark:divide-gray-700">
                <thead class="bg-gray-50 dark:bg-gray-700">
                    <tr>
                        <th
                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                            Info Sopir</th>
                        <th
                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                            Kontak</th>
                        <th
                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                            No. SIM</th>
                        <th
                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                            Status</th>
                        <th
                            class="px-6 py-3 text-right text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                            Aksi</th>
                    </tr>
                </thead>
                <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                    @forelse ($sopirs as $sopir)
                        <tr class="hover:bg-gray-50 dark:hover:bg-gray-700">
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="flex items-center">
                                    <div class="flex-shrink-0 h-12 w-12">
                                        <div
                                            class="h-12 w-12 bg-gradient-to-r from-indigo-500 to-purple-600 rounded-full flex items-center justify-center border border-gray-200 dark:border-gray-600">
                                            <span
                                                class="text-white font-medium text-lg">{{ substr($sopir->nama, 0, 1) }}</span>
                                        </div>
                                    </div>
                                    <div class="ml-4">
                                        <div class="text-sm font-medium text-gray-900 dark:text-white">
                                            {{ $sopir->nama }}
                                        </div>
                                        <div class="text-sm text-gray-500 dark:text-gray-400">
                                            Bergabung {{ $sopir->created_at->format('M Y') }}
                                        </div>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm text-gray-900 dark:text-white">
                                    <div class="flex items-center">
                                        <iconify-icon icon="heroicons:phone-20-solid"
                                            class="w-4 h-4 mr-2 text-gray-400"></iconify-icon>
                                        {{ $sopir->telepon }}
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div
                                    class="text-sm font-mono font-medium text-gray-900 dark:text-white bg-gray-100 dark:bg-gray-700 px-2 py-1 rounded">
                                    {{ $sopir->no_sim }}
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                @if ($sopir->status === 'tersedia')
                                    <span
                                        class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200">
                                        <iconify-icon icon="heroicons:check-circle-20-solid"
                                            class="w-4 h-4 mr-1"></iconify-icon>
                                        Tersedia
                                    </span>
                                @elseif ($sopir->status === 'ditugaskan')
                                    <span
                                        class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-orange-100 text-orange-800 dark:bg-orange-900 dark:text-orange-200">
                                        <iconify-icon icon="heroicons:briefcase-20-solid"
                                            class="w-4 h-4 mr-1"></iconify-icon>
                                        Ditugaskan
                                    </span>
                                @else
                                    <span
                                        class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-gray-100 text-gray-800 dark:bg-gray-700 dark:text-gray-200">
                                        <iconify-icon icon="heroicons:calendar-days-20-solid"
                                            class="w-4 h-4 mr-1"></iconify-icon>
                                        Libur
                                    </span>
                                @endif
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                <div class="flex items-center justify-end space-x-2">
                                    <a href="{{ route('admin.sopir.show', $sopir) }}"
                                        class="text-gray-400 hover:text-gray-600 dark:hover:text-gray-300"
                                        title="Lihat Detail">
                                        <iconify-icon icon="heroicons:eye-20-solid" class="w-4 h-4"></iconify-icon>
                                    </a>
                                    <a href="{{ route('admin.sopir.edit', $sopir) }}"
                                        class="text-indigo-600 hover:text-indigo-900 dark:text-indigo-400 dark:hover:text-indigo-300"
                                        title="Edit">
                                        <iconify-icon icon="heroicons:pencil-20-solid" class="w-4 h-4"></iconify-icon>
                                    </a>
                                    <form method="POST" action="{{ route('admin.sopir.destroy', $sopir) }}"
                                        onsubmit="return confirm('Apakah Anda yakin ingin menghapus sopir ini?')"
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
                                    <iconify-icon icon="heroicons:user-20-solid"
                                        class="w-12 h-12 text-gray-400 mb-4"></iconify-icon>
                                    <h3 class="text-sm font-medium text-gray-900 dark:text-white mb-1">Belum ada sopir</h3>
                                    <p class="text-sm text-gray-500 dark:text-gray-400 mb-4">Mulai dengan menambahkan sopir
                                        baru ke tim Anda</p>
                                    <a href="{{ route('admin.sopir.create') }}"
                                        class="inline-flex items-center px-4 py-2 bg-indigo-600 hover:bg-indigo-700 text-white text-sm font-medium rounded-xl transition-colors duration-200">
                                        <iconify-icon icon="heroicons:plus-20-solid" class="w-4 h-4 mr-2"></iconify-icon>
                                        Tambah Sopir
                                    </a>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if ($sopirs->hasPages())
            <div class="px-6 py-4 border-t border-gray-200 dark:border-gray-700">
                {{ $sopirs->appends(request()->query())->links() }}
            </div>
        @endif
    </div>
@endsection
