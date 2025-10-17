@php
    use Illuminate\Support\Facades\Storage;
@endphp

@extends('layouts.admin')

@section('title', 'Manajemen Mobil')
@section('page-title', 'Manajemen Mobil')
@section('page-subtitle', 'Kelola armada mobil rental Anda')

@section('content')
    <!-- Stats Cards -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
        <!-- Total Cars -->
        <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-sm border border-gray-100 dark:border-gray-700 p-6">
            <div class="flex items-center">
                <div class="flex-shrink-0">
                    <div class="w-10 h-10 bg-blue-100 dark:bg-blue-900 rounded-lg flex items-center justify-center">
                        <iconify-icon icon="heroicons:truck-20-solid"
                            class="w-5 h-5 text-blue-600 dark:text-blue-400"></iconify-icon>
                    </div>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-gray-600 dark:text-gray-400">Total Cars</p>
                    <p class="text-2xl font-semibold text-gray-900 dark:text-white">{{ $stats['total'] }}</p>
                </div>
            </div>
        </div>

        <!-- Available Cars -->
        <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-sm border border-gray-100 dark:border-gray-700 p-6">
            <div class="flex items-center">
                <div class="flex-shrink-0">
                    <div class="w-10 h-10 bg-green-100 dark:bg-green-900 rounded-lg flex items-center justify-center">
                        <iconify-icon icon="heroicons:check-circle-20-solid"
                            class="w-5 h-5 text-green-600 dark:text-green-400"></iconify-icon>
                    </div>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-gray-600 dark:text-gray-400">Available</p>
                    <p class="text-2xl font-semibold text-gray-900 dark:text-white">{{ $stats['available'] }}</p>
                </div>
            </div>
        </div>

        <!-- Rented Cars -->
        <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-sm border border-gray-100 dark:border-gray-700 p-6">
            <div class="flex items-center">
                <div class="flex-shrink-0">
                    <div class="w-10 h-10 bg-orange-100 dark:bg-orange-900 rounded-lg flex items-center justify-center">
                        <iconify-icon icon="heroicons:key-20-solid"
                            class="w-5 h-5 text-orange-600 dark:text-orange-400"></iconify-icon>
                    </div>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-gray-600 dark:text-gray-400">Rented</p>
                    <p class="text-2xl font-semibold text-gray-900 dark:text-white">{{ $stats['rented'] }}</p>
                </div>
            </div>
        </div>

        <!-- Maintenance Cars -->
        <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-sm border border-gray-100 dark:border-gray-700 p-6">
            <div class="flex items-center">
                <div class="flex-shrink-0">
                    <div class="w-10 h-10 bg-red-100 dark:bg-red-900 rounded-lg flex items-center justify-center">
                        <iconify-icon icon="heroicons:wrench-screwdriver-20-solid"
                            class="w-5 h-5 text-red-600 dark:text-red-400"></iconify-icon>
                    </div>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-gray-600 dark:text-gray-400">Maintenance</p>
                    <p class="text-2xl font-semibold text-gray-900 dark:text-white">{{ $stats['maintenance'] }}</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Search and Filter Bar -->
    <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-sm border border-gray-100 dark:border-gray-700 p-6 mb-6">
        <form method="GET" action="{{ route('admin.mobil.index') }}" class="flex flex-col md:flex-row gap-4">
            <!-- Search -->
            <div class="flex-1">
                <div class="relative">
                    <input type="text" name="search" value="{{ request('search') }}"
                        placeholder="Cari mobil berdasarkan merk, model, atau plat nomor..."
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
                    <option value="disewa" {{ request('status') == 'disewa' ? 'selected' : '' }}>Disewa</option>
                    <option value="maintenance" {{ request('status') == 'maintenance' ? 'selected' : '' }}>Maintenance
                    </option>
                </select>

                <select name="brand"
                    class="px-3 py-2 text-sm bg-gray-50 dark:bg-gray-700 border border-gray-200 dark:border-gray-600 rounded-xl focus:ring-2 focus:ring-indigo-500">
                    <option value="">Semua Merk</option>
                    @foreach ($brands as $brand)
                        <option value="{{ $brand }}" {{ request('brand') == $brand ? 'selected' : '' }}>
                            {{ $brand }}
                        </option>
                    @endforeach
                </select>

                <select name="transmisi"
                    class="px-3 py-2 text-sm bg-gray-50 dark:bg-gray-700 border border-gray-200 dark:border-gray-600 rounded-xl focus:ring-2 focus:ring-indigo-500">
                    <option value="">Semua Transmisi</option>
                    <option value="manual" {{ request('transmisi') == 'manual' ? 'selected' : '' }}>Manual</option>
                    <option value="otomatis" {{ request('transmisi') == 'otomatis' ? 'selected' : '' }}>Otomatis</option>
                </select>

                <button type="submit"
                    class="px-4 py-2 bg-indigo-600 hover:bg-indigo-700 text-white text-sm font-medium rounded-xl transition-colors duration-200">
                    Filter
                </button>

                @if (request()->hasAny(['search', 'status', 'brand', 'transmisi']))
                    <a href="{{ route('admin.mobil.index') }}"
                        class="px-4 py-2 bg-gray-500 hover:bg-gray-600 text-white text-sm font-medium rounded-xl transition-colors duration-200">
                        Hapus
                    </a>
                @endif
            </div>
        </form>
    </div>

    <!-- Cars Table -->
    <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-sm border border-gray-100 dark:border-gray-700">
        <!-- Header -->
        <div class="px-6 py-4 border-b border-gray-200 dark:border-gray-700">
            <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
                <div>
                    <h1 class="text-2xl font-bold text-gray-900 dark:text-white">Manajemen Mobil</h1>
                    <p class="text-sm text-gray-600 dark:text-gray-400">Kelola kendaraan rental Anda</p>
                </div>
                <a href="{{ route('admin.mobil.create') }}"
                    class="inline-flex items-center px-4 py-2 bg-indigo-600 hover:bg-indigo-700 text-white text-sm font-medium rounded-xl transition-colors duration-200">
                    <iconify-icon icon="heroicons:plus-20-solid" class="w-4 h-4 mr-2"></iconify-icon>
                    Tambah Mobil Baru
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
                            Info Mobil</th>
                        <th
                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                            Detail</th>
                        <th
                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                            Plat Nomor</th>
                        <th
                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                            Status</th>
                        <th
                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                            Harga Sewa</th>
                        <th
                            class="px-6 py-3 text-right text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                            Aksi</th>
                    </tr>
                </thead>
                <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                    @forelse ($mobils as $mobil)
                        <tr class="hover:bg-gray-50 dark:hover:bg-gray-700">
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="flex items-center">
                                    <div class="flex-shrink-0 h-12 w-12">
                                        @if ($mobil->foto)
                                            <img class="h-12 w-12 rounded-lg object-cover border border-gray-200 dark:border-gray-600"
                                                src="{{ Storage::url($mobil->foto) }}"
                                                alt="{{ $mobil->merk }} {{ $mobil->model }}">
                                        @else
                                            <div
                                                class="h-12 w-12 bg-gray-100 dark:bg-gray-700 rounded-lg flex items-center justify-center border border-gray-200 dark:border-gray-600">
                                                <iconify-icon icon="heroicons:truck-20-solid"
                                                    class="w-6 h-6 text-gray-400"></iconify-icon>
                                            </div>
                                        @endif
                                    </div>
                                    <div class="ml-4">
                                        <div class="text-sm font-medium text-gray-900 dark:text-white">
                                            {{ $mobil->merk }} {{ $mobil->model }}
                                        </div>
                                        <div class="text-sm text-gray-500 dark:text-gray-400">
                                            {{ $mobil->tahun }} • {{ $mobil->warna }}
                                        </div>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm text-gray-900 dark:text-white">
                                    <div class="flex items-center space-x-4">
                                        <span class="flex items-center">
                                            <iconify-icon icon="heroicons:cog-8-tooth-20-solid"
                                                class="w-4 h-4 mr-1 text-gray-400"></iconify-icon>
                                            {{ ucfirst($mobil->transmisi) }}
                                        </span>
                                        <span class="flex items-center">
                                            <iconify-icon icon="heroicons:fire-20-solid"
                                                class="w-4 h-4 mr-1 text-gray-400"></iconify-icon>
                                            {{ ucfirst($mobil->jenis_bahan_bakar) }}
                                        </span>
                                    </div>
                                    <div class="text-xs text-gray-500 dark:text-gray-400 mt-1">
                                        {{ $mobil->kapasitas_penumpang }} penumpang
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div
                                    class="text-sm font-mono font-medium text-gray-900 dark:text-white bg-gray-100 dark:bg-gray-700 px-2 py-1 rounded">
                                    {{ $mobil->plat_nomor }}
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                @if ($mobil->status === 'tersedia')
                                    <span
                                        class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200">
                                        <iconify-icon icon="heroicons:check-circle-20-solid"
                                            class="w-4 h-4 mr-1"></iconify-icon>
                                        Tersedia
                                    </span>
                                @elseif ($mobil->status === 'disewa')
                                    <span
                                        class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-orange-100 text-orange-800 dark:bg-orange-900 dark:text-orange-200">
                                        <iconify-icon icon="heroicons:key-20-solid" class="w-4 h-4 mr-1"></iconify-icon>
                                        Disewa
                                    </span>
                                @else
                                    <span
                                        class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-200">
                                        <iconify-icon icon="heroicons:wrench-screwdriver-20-solid"
                                            class="w-4 h-4 mr-1"></iconify-icon>
                                        Perbaikan
                                    </span>
                                @endif
                            </td>
                            <td class="px-6 py-4">
                                <div class="text-sm text-gray-900 dark:text-white">
                                    @if ($mobil->hargaSewa->where('aktif', true)->count() > 0)
                                        @foreach ($mobil->hargaSewa->where('aktif', true)->take(2) as $harga)
                                            <div class="flex items-center justify-between mb-1">
                                                <span
                                                    class="text-xs text-gray-500 dark:text-gray-400">{{ $harga->jenisSewa->nama_jenis }}:</span>
                                                <span class="text-xs font-medium">Rp
                                                    {{ number_format($harga->harga_per_hari, 0, ',', '.') }}</span>
                                            </div>
                                        @endforeach
                                        @if ($mobil->hargaSewa->where('aktif', true)->count() > 2)
                                            <div class="text-xs text-gray-400">
                                                +{{ $mobil->hargaSewa->where('aktif', true)->count() - 2 }} lainnya</div>
                                        @endif
                                    @else
                                        <span class="text-xs text-gray-400">Belum ada harga</span>
                                    @endif
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                <div class="flex items-center justify-end space-x-2">
                                    <a href="{{ route('admin.mobil.show', $mobil) }}"
                                        class="text-gray-400 hover:text-gray-600 dark:hover:text-gray-300"
                                        title="Lihat Detail">
                                        <iconify-icon icon="heroicons:eye-20-solid" class="w-4 h-4"></iconify-icon>
                                    </a>
                                    <a href="{{ route('admin.mobil.edit', $mobil) }}"
                                        class="text-indigo-600 hover:text-indigo-900 dark:text-indigo-400 dark:hover:text-indigo-300"
                                        title="Edit">
                                        <iconify-icon icon="heroicons:pencil-20-solid" class="w-4 h-4"></iconify-icon>
                                    </a>
                                    <a href="{{ route('admin.mobil.pricing', $mobil) }}"
                                        class="text-green-600 hover:text-green-900 dark:text-green-400 dark:hover:text-green-300"
                                        title="Atur Harga">
                                        <iconify-icon icon="heroicons:currency-dollar-20-solid"
                                            class="w-4 h-4"></iconify-icon>
                                    </a>
                                    <form method="POST" action="{{ route('admin.mobil.destroy', $mobil) }}"
                                        onsubmit="return confirm('Apakah Anda yakin ingin menghapus mobil ini?')"
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
                            <td colspan="6" class="px-6 py-12 text-center">
                                <div class="flex flex-col items-center">
                                    <iconify-icon icon="heroicons:truck-20-solid"
                                        class="w-12 h-12 text-gray-400 mb-4"></iconify-icon>
                                    <h3 class="text-sm font-medium text-gray-900 dark:text-white mb-1">Tidak ada mobil
                                        ditemukan</h3>
                                    <p class="text-sm text-gray-500 dark:text-gray-400 mb-4">Mulai dengan menambahkan mobil
                                        baru ke armada Anda</p>
                                    <a href="{{ route('admin.mobil.create') }}"
                                        class="inline-flex items-center px-4 py-2 bg-indigo-600 hover:bg-indigo-700 text-white text-sm font-medium rounded-xl transition-colors duration-200">
                                        <iconify-icon icon="heroicons:plus-20-solid" class="w-4 h-4 mr-2"></iconify-icon>
                                        Tambah Mobil Baru
                                    </a>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if ($mobils->hasPages())
            <div class="px-6 py-4 border-t border-gray-200 dark:border-gray-700">
                {{ $mobils->appends(request()->query())->links() }}
            </div>
        @endif
    </div>
@endsection
