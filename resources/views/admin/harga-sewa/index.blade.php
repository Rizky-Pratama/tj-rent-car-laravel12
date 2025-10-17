@extends('layouts.admin')

@section('title', 'Harga Sewa Management')
@section('page-title', 'Harga Sewa')
@section('page-subtitle', 'Kelola tarif sewa kendaraan')

@section('content')
    <div class="space-y-6">
        <!-- Header Actions -->
        <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
            <div class="flex items-center space-x-4">
                <!-- Search -->
                <form method="GET" action="{{ route('admin.harga-sewa.index') }}" class="flex items-center space-x-2">
                    <div class="relative">
                        <input type="text" name="search" value="{{ request('search') }}"
                            placeholder="Cari mobil atau jenis sewa..."
                            class="pl-10 pr-4 py-2 w-64 text-sm border border-gray-300 dark:border-gray-600 rounded-xl bg-white dark:bg-gray-700 text-gray-900 dark:text-white placeholder-gray-500 dark:placeholder-gray-400 focus:ring-2 focus:ring-indigo-500 focus:border-transparent">
                        <iconify-icon icon="heroicons:magnifying-glass-20-solid"
                            class="absolute left-3 top-2.5 w-4 h-4 text-gray-400"></iconify-icon>
                    </div>

                    <!-- Jenis Sewa Filter -->
                    <select name="jenis_sewa_id"
                        class="px-3 py-2 text-sm border border-gray-300 dark:border-gray-600 rounded-xl bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-indigo-500 focus:border-transparent">
                        <option value="">Semua Jenis</option>
                        @foreach ($jenisSewa as $jenis)
                            <option value="{{ $jenis->id }}"
                                {{ request('jenis_sewa_id') == $jenis->id ? 'selected' : '' }}>
                                {{ $jenis->nama_jenis }}
                            </option>
                        @endforeach
                    </select>

                    <!-- Mobil Filter -->
                    <select name="mobil_id"
                        class="px-3 py-2 text-sm border border-gray-300 dark:border-gray-600 rounded-xl bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-indigo-500 focus:border-transparent">
                        <option value="">Semua Mobil</option>
                        @foreach ($mobils as $mobil)
                            <option value="{{ $mobil->id }}" {{ request('mobil_id') == $mobil->id ? 'selected' : '' }}>
                                {{ $mobil->merk }} {{ $mobil->model }} - {{ $mobil->no_plat }}
                            </option>
                        @endforeach
                    </select>

                    <!-- Status Filter -->
                    <select name="status"
                        class="px-3 py-2 text-sm border border-gray-300 dark:border-gray-600 rounded-xl bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-indigo-500 focus:border-transparent">
                        <option value="">Semua Status</option>
                        <option value="active" {{ request('status') === 'active' ? 'selected' : '' }}>Aktif</option>
                        <option value="inactive" {{ request('status') === 'inactive' ? 'selected' : '' }}>Tidak Aktif
                        </option>
                    </select>

                    <button type="submit"
                        class="px-4 py-2 bg-gray-100 dark:bg-gray-700 hover:bg-gray-200 dark:hover:bg-gray-600 text-gray-700 dark:text-gray-300 text-sm font-medium rounded-xl transition-colors duration-200">
                        Filter
                    </button>

                    @if (request()->hasAny(['search', 'jenis_sewa_id', 'mobil_id', 'status']))
                        <a href="{{ route('admin.harga-sewa.index') }}"
                            class="px-4 py-2 bg-gray-500 hover:bg-gray-600 text-white text-sm font-medium rounded-xl transition-colors duration-200">
                            Reset
                        </a>
                    @endif
                </form>
            </div>

            <div class="flex items-center space-x-3">
                <a href="{{ route('admin.harga-sewa.create') }}"
                    class="inline-flex items-center px-4 py-2 bg-indigo-600 hover:bg-indigo-700 text-white text-sm font-medium rounded-xl transition-colors duration-200">
                    <iconify-icon icon="heroicons:plus-20-solid" class="w-4 h-4 mr-2"></iconify-icon>
                    Tambah Harga Sewa
                </a>
            </div>
        </div>

        <!-- Stats Cards -->
        <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
            <div class="bg-white dark:bg-gray-800 rounded-2xl p-6 border border-gray-100 dark:border-gray-700">
                <div class="flex items-center">
                    <div class="p-2 bg-blue-100 dark:bg-blue-900 rounded-lg">
                        <iconify-icon icon="heroicons:currency-dollar-20-solid"
                            class="w-6 h-6 text-blue-600 dark:text-blue-400"></iconify-icon>
                    </div>
                    <div class="ml-4">
                        <p class="text-sm font-medium text-gray-600 dark:text-gray-400">Total Tarif</p>
                        <p class="text-2xl font-semibold text-gray-900 dark:text-white">{{ $hargaSewa->total() }}</p>
                    </div>
                </div>
            </div>
            <div class="bg-white dark:bg-gray-800 rounded-2xl p-6 border border-gray-100 dark:border-gray-700">
                <div class="flex items-center">
                    <div class="p-2 bg-green-100 dark:bg-green-900 rounded-lg">
                        <iconify-icon icon="heroicons:check-circle-20-solid"
                            class="w-6 h-6 text-green-600 dark:text-green-400"></iconify-icon>
                    </div>
                    <div class="ml-4">
                        <p class="text-sm font-medium text-gray-600 dark:text-gray-400">Tarif Aktif</p>
                        <p class="text-2xl font-semibold text-gray-900 dark:text-white">
                            {{ $hargaSewa->where('aktif', true)->count() }}</p>
                    </div>
                </div>
            </div>
            <div class="bg-white dark:bg-gray-800 rounded-2xl p-6 border border-gray-100 dark:border-gray-700">
                <div class="flex items-center">
                    <div class="p-2 bg-yellow-100 dark:bg-yellow-900 rounded-lg">
                        <iconify-icon icon="heroicons:clock-20-solid"
                            class="w-6 h-6 text-yellow-600 dark:text-yellow-400"></iconify-icon>
                    </div>
                    <div class="ml-4">
                        <p class="text-sm font-medium text-gray-600 dark:text-gray-400">Harian</p>
                        <p class="text-2xl font-semibold text-gray-900 dark:text-white">
                            {{ $hargaSewa->whereHas('jenisSewa', fn($q) => $q->where('slug', 'harian'))->count() }}</p>
                    </div>
                </div>
            </div>
            <div class="bg-white dark:bg-gray-800 rounded-2xl p-6 border border-gray-100 dark:border-gray-700">
                <div class="flex items-center">
                    <div class="p-2 bg-purple-100 dark:bg-purple-900 rounded-lg">
                        <iconify-icon icon="heroicons:user-20-solid"
                            class="w-6 h-6 text-purple-600 dark:text-purple-400"></iconify-icon>
                    </div>
                    <div class="ml-4">
                        <p class="text-sm font-medium text-gray-600 dark:text-gray-400">Dengan Sopir</p>
                        <p class="text-2xl font-semibold text-gray-900 dark:text-white">
                            {{ $hargaSewa->whereHas('jenisSewa', fn($q) => $q->where('slug', 'dengan-sopir'))->count() }}
                        </p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Cars Table -->
        <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-sm border border-gray-100 dark:border-gray-700">
            <div class="px-6 py-4 border-b border-gray-200 dark:border-gray-700">
                <h3 class="text-lg font-semibold text-gray-900 dark:text-white">Daftar Harga Sewa</h3>
                <p class="text-sm text-gray-600 dark:text-gray-400">Kelola tarif sewa untuk setiap mobil dan jenis sewa</p>
            </div>

            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead class="bg-gray-50 dark:bg-gray-700 border-b border-gray-200 dark:border-gray-600">
                        <tr>
                            <th
                                class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">
                                Mobil
                            </th>
                            <th
                                class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">
                                Jenis Sewa
                            </th>
                            <th
                                class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">
                                Harga/Hari
                            </th>
                            <th
                                class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">
                                Periode
                            </th>
                            <th
                                class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">
                                Status
                            </th>
                            <th
                                class="px-6 py-3 text-right text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">
                                Actions
                            </th>
                        </tr>
                    </thead>
                    <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                        @forelse ($hargaSewa as $price)
                            <tr class="hover:bg-gray-50 dark:hover:bg-gray-700 transition-colors duration-200">
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="flex items-center">
                                        <div class="flex-shrink-0 h-10 w-10">
                                            <div
                                                class="h-10 w-10 rounded-full bg-gradient-to-r from-blue-500 to-indigo-600 flex items-center justify-center">
                                                <iconify-icon icon="heroicons:truck-20-solid"
                                                    class="w-5 h-5 text-white"></iconify-icon>
                                            </div>
                                        </div>
                                        <div class="ml-4">
                                            <div class="text-sm font-medium text-gray-900 dark:text-white">
                                                {{ $price->mobil->merk }} {{ $price->mobil->model }}
                                            </div>
                                            <div class="text-sm text-gray-500 dark:text-gray-400">
                                                {{ $price->mobil->no_plat }} • {{ $price->mobil->tahun }}
                                            </div>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm font-medium text-gray-900 dark:text-white">
                                        {{ $price->jenisSewa->nama_jenis }}
                                    </div>
                                    <div class="text-sm text-gray-500 dark:text-gray-400">
                                        {{ $price->jenisSewa->deskripsi }}
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-lg font-bold text-gray-900 dark:text-white">
                                        Rp {{ number_format($price->harga_per_hari, 0, ',', '.') }}
                                    </div>
                                    <div class="text-sm text-gray-500 dark:text-gray-400">per hari</div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm text-gray-900 dark:text-white">
                                        {{ $price->berlaku_dari ? \Carbon\Carbon::parse($price->berlaku_dari)->format('d/m/Y') : '-' }}
                                    </div>
                                    <div class="text-sm text-gray-500 dark:text-gray-400">
                                        s/d
                                        {{ $price->berlaku_sampai ? \Carbon\Carbon::parse($price->berlaku_sampai)->format('d/m/Y') : 'Tidak terbatas' }}
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    @if ($price->aktif)
                                        <span
                                            class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200">
                                            <iconify-icon icon="heroicons:check-circle-20-solid"
                                                class="w-4 h-4 mr-1"></iconify-icon>
                                            Aktif
                                        </span>
                                    @else
                                        <span
                                            class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-200">
                                            <iconify-icon icon="heroicons:x-circle-20-solid"
                                                class="w-4 h-4 mr-1"></iconify-icon>
                                            Tidak Aktif
                                        </span>
                                    @endif
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                    <div class="flex items-center justify-end space-x-2">
                                        <a href="{{ route('admin.harga-sewa.show', $price) }}"
                                            class="text-gray-400 hover:text-gray-600 dark:hover:text-gray-300"
                                            title="View Details">
                                            <iconify-icon icon="heroicons:eye-20-solid" class="w-4 h-4"></iconify-icon>
                                        </a>
                                        <a href="{{ route('admin.harga-sewa.edit', $price) }}"
                                            class="text-indigo-600 hover:text-indigo-900 dark:text-indigo-400 dark:hover:text-indigo-300"
                                            title="Edit">
                                            <iconify-icon icon="heroicons:pencil-20-solid" class="w-4 h-4"></iconify-icon>
                                        </a>
                                        <form method="POST" action="{{ route('admin.harga-sewa.destroy', $price) }}"
                                            onsubmit="return confirm('Are you sure you want to delete this pricing?')"
                                            class="inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit"
                                                class="text-red-600 hover:text-red-900 dark:text-red-400 dark:hover:text-red-300"
                                                title="Delete">
                                                <iconify-icon icon="heroicons:trash-20-solid"
                                                    class="w-4 h-4"></iconify-icon>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="px-6 py-12 text-center">
                                    <div class="flex flex-col items-center">
                                        <iconify-icon icon="heroicons:currency-dollar-20-solid"
                                            class="w-12 h-12 text-gray-400 mb-4"></iconify-icon>
                                        <h3 class="text-sm font-medium text-gray-900 dark:text-white mb-1">Belum ada harga
                                            sewa</h3>
                                        <p class="text-sm text-gray-500 dark:text-gray-400 mb-4">Mulai dengan menambahkan
                                            tarif sewa untuk mobil</p>
                                        <a href="{{ route('admin.harga-sewa.create') }}"
                                            class="inline-flex items-center px-4 py-2 bg-indigo-600 hover:bg-indigo-700 text-white text-sm font-medium rounded-xl transition-colors duration-200">
                                            <iconify-icon icon="heroicons:plus-20-solid"
                                                class="w-4 h-4 mr-2"></iconify-icon>
                                            Tambah Harga Sewa
                                        </a>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            @if ($hargaSewa->hasPages())
                <div class="px-6 py-4 border-t border-gray-200 dark:border-gray-700">
                    {{ $hargaSewa->appends(request()->query())->links() }}
                </div>
            @endif
        </div>
    </div>
@endsection
