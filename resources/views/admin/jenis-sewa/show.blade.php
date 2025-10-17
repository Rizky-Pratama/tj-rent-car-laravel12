@extends('layouts.admin')

@section('title', 'Detail Jenis Sewa')

@section('content')
    <div class="max-w-5xl mx-auto">
        <!-- Header -->
        <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-sm border border-gray-200 dark:border-gray-700 p-6 mb-6">
            <div class="flex items-center justify-between">
                <div>
                    <h1 class="text-2xl font-bold text-gray-900 dark:text-white">{{ $jenisSewa->nama_jenis }}</h1>
                    <p class="text-sm text-gray-600 dark:text-gray-400">Detail informasi jenis sewa</p>
                </div>
                <div class="flex items-center space-x-3">
                    <a href="{{ route('admin.jenis-sewa.edit', $jenisSewa) }}"
                        class="inline-flex items-center px-4 py-2 bg-indigo-600 hover:bg-indigo-700 text-white text-sm font-medium rounded-xl transition-colors duration-200">
                        <iconify-icon icon="heroicons:pencil-20-solid" class="w-4 h-4 mr-2"></iconify-icon>
                        Edit
                    </a>
                    <a href="{{ route('admin.jenis-sewa.index') }}"
                        class="inline-flex items-center px-4 py-2 bg-gray-500 hover:bg-gray-600 text-white text-sm font-medium rounded-xl transition-colors duration-200">
                        <iconify-icon icon="heroicons:arrow-left-20-solid" class="w-4 h-4 mr-2"></iconify-icon>
                        Kembali
                    </a>
                </div>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            <!-- Basic Information -->
            <div class="lg:col-span-2 space-y-6">
                <!-- Details Card -->
                <div
                    class="bg-white dark:bg-gray-800 rounded-2xl shadow-sm border border-gray-200 dark:border-gray-700 p-6">
                    <h2 class="text-lg font-semibold text-gray-900 dark:text-white mb-4 flex items-center">
                        <iconify-icon icon="heroicons:document-text-20-solid"
                            class="w-5 h-5 mr-2 text-indigo-600"></iconify-icon>
                        Informasi Detail
                    </h2>

                    <div class="space-y-4">
                        <!-- Nama Jenis -->
                        <div class="flex justify-between items-start py-3 border-b border-gray-100 dark:border-gray-700">
                            <div class="flex-1">
                                <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Nama Jenis</dt>
                                <dd class="mt-1 text-sm text-gray-900 dark:text-white font-semibold">
                                    {{ $jenisSewa->nama_jenis }}</dd>
                            </div>
                        </div>

                        <!-- Slug -->
                        <div class="flex justify-between items-start py-3 border-b border-gray-100 dark:border-gray-700">
                            <div class="flex-1">
                                <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Slug</dt>
                                <dd
                                    class="mt-1 text-sm font-mono bg-gray-100 dark:bg-gray-700 px-2 py-1 rounded text-gray-900 dark:text-white">
                                    {{ $jenisSewa->slug }}</dd>
                            </div>
                        </div>

                        <!-- Deskripsi -->
                        <div class="flex justify-between items-start py-3 border-b border-gray-100 dark:border-gray-700">
                            <div class="flex-1">
                                <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Deskripsi</dt>
                                <dd class="mt-1 text-sm text-gray-900 dark:text-white">
                                    {{ $jenisSewa->deskripsi ?: 'Tidak ada deskripsi' }}
                                </dd>
                            </div>
                        </div>

                        <!-- Tarif Denda -->
                        <div class="flex justify-between items-start py-3 border-b border-gray-100 dark:border-gray-700">
                            <div class="flex-1">
                                <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Tarif Denda per Hari</dt>
                                <dd class="mt-1">
                                    @if ($jenisSewa->tarif_denda_per_hari)
                                        <div class="flex items-center">
                                            <span class="text-lg font-bold text-orange-600">Rp
                                                {{ number_format($jenisSewa->tarif_denda_per_hari, 0, ',', '.') }}</span>
                                            <span class="ml-2 text-sm text-gray-500">/hari</span>
                                        </div>
                                    @else
                                        <span
                                            class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-green-100 dark:bg-green-900/30 text-green-800 dark:text-green-300">
                                            <iconify-icon icon="heroicons:shield-check-20-solid"
                                                class="w-3 h-3 mr-1"></iconify-icon>
                                            Tanpa Denda
                                        </span>
                                    @endif
                                </dd>
                            </div>
                        </div>

                        <!-- Timestamps -->
                        <div class="flex justify-between items-start py-3">
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 w-full">
                                <div>
                                    <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Dibuat</dt>
                                    <dd class="mt-1 text-sm text-gray-900 dark:text-white">
                                        {{ $jenisSewa->created_at->format('d M Y H:i') }}
                                        <span
                                            class="text-xs text-gray-500">({{ $jenisSewa->created_at->diffForHumans() }})</span>
                                    </dd>
                                </div>
                                <div>
                                    <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Terakhir Diperbarui
                                    </dt>
                                    <dd class="mt-1 text-sm text-gray-900 dark:text-white">
                                        {{ $jenisSewa->updated_at->format('d M Y H:i') }}
                                        <span
                                            class="text-xs text-gray-500">({{ $jenisSewa->updated_at->diffForHumans() }})</span>
                                    </dd>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Mobil dengan Jenis Sewa Ini -->
                <div
                    class="bg-white dark:bg-gray-800 rounded-2xl shadow-sm border border-gray-200 dark:border-gray-700 p-6">
                    <div class="flex items-center justify-between mb-4">
                        <h2 class="text-lg font-semibold text-gray-900 dark:text-white flex items-center">
                            <iconify-icon icon="heroicons:truck-20-solid"
                                class="w-5 h-5 mr-2 text-indigo-600"></iconify-icon>
                            Mobil dengan Jenis Sewa Ini
                        </h2>
                        <span class="text-sm text-gray-500 dark:text-gray-400">
                            {{ $jenisSewa->hargaSewa->count() }} mobil terdaftar
                        </span>
                    </div>

                    @if ($jenisSewa->hargaSewa->count() > 0)
                        <div class="overflow-hidden">
                            <div class="overflow-x-auto">
                                <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                                    <thead class="bg-gray-50 dark:bg-gray-700/50">
                                        <tr>
                                            <th scope="col"
                                                class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">
                                                Mobil
                                            </th>
                                            <th scope="col"
                                                class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">
                                                Harga
                                            </th>
                                            <th scope="col"
                                                class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">
                                                Status
                                            </th>
                                            <th scope="col"
                                                class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">
                                                Aksi
                                            </th>
                                        </tr>
                                    </thead>
                                    <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                                        @foreach ($jenisSewa->hargaSewa as $harga)
                                            <tr class="hover:bg-gray-50 dark:hover:bg-gray-700/50">
                                                <td class="px-6 py-4 whitespace-nowrap">
                                                    <div class="flex items-center">
                                                        <div class="flex-shrink-0 h-10 w-10">
                                                            @if ($harga->mobil->foto)
                                                                <img class="h-10 w-10 rounded-lg object-cover"
                                                                    src="{{ Storage::url($harga->mobil->foto) }}"
                                                                    alt="{{ $harga->mobil->nama_mobil }}">
                                                            @else
                                                                <div
                                                                    class="h-10 w-10 rounded-lg bg-gray-300 dark:bg-gray-600 flex items-center justify-center">
                                                                    <iconify-icon icon="heroicons:truck-20-solid"
                                                                        class="w-5 h-5 text-gray-500 dark:text-gray-400"></iconify-icon>
                                                                </div>
                                                            @endif
                                                        </div>
                                                        <div class="ml-4">
                                                            <div class="text-sm font-medium text-gray-900 dark:text-white">
                                                                {{ $harga->mobil->nama_mobil }}
                                                            </div>
                                                            <div class="text-sm text-gray-500 dark:text-gray-400">
                                                                {{ $harga->mobil->plat_nomor }}
                                                            </div>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td class="px-6 py-4 whitespace-nowrap">
                                                    <div class="text-sm font-semibold text-gray-900 dark:text-white">
                                                        Rp {{ number_format($harga->harga, 0, ',', '.') }}
                                                    </div>
                                                </td>
                                                <td class="px-6 py-4 whitespace-nowrap">
                                                    @if ($harga->aktif)
                                                        <span
                                                            class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 dark:bg-green-900/30 text-green-800 dark:text-green-300">
                                                            <div class="w-1.5 h-1.5 bg-green-400 rounded-full mr-1.5"></div>
                                                            Aktif
                                                        </span>
                                                    @else
                                                        <span
                                                            class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-gray-100 dark:bg-gray-700 text-gray-800 dark:text-gray-300">
                                                            <div class="w-1.5 h-1.5 bg-gray-400 rounded-full mr-1.5"></div>
                                                            Nonaktif
                                                        </span>
                                                    @endif
                                                </td>
                                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                                    <a href="{{ route('admin.mobil.show', $harga->mobil) }}"
                                                        class="text-indigo-600 hover:text-indigo-900 dark:text-indigo-400 dark:hover:text-indigo-300">
                                                        Lihat Detail
                                                    </a>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    @else
                        <div class="text-center py-12">
                            <iconify-icon icon="heroicons:truck-20-solid"
                                class="mx-auto h-12 w-12 text-gray-400"></iconify-icon>
                            <h3 class="mt-2 text-sm font-medium text-gray-900 dark:text-white">Belum ada mobil</h3>
                            <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">Jenis sewa ini belum digunakan pada
                                mobil manapun.</p>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Sidebar Stats -->
            <div class="space-y-6">
                <!-- Quick Stats -->
                <div
                    class="bg-white dark:bg-gray-800 rounded-2xl shadow-sm border border-gray-200 dark:border-gray-700 p-6">
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4 flex items-center">
                        <iconify-icon icon="heroicons:chart-bar-20-solid"
                            class="w-5 h-5 mr-2 text-indigo-600"></iconify-icon>
                        Statistik
                    </h3>

                    <div class="space-y-4">
                        <!-- Total Mobil -->
                        <div class="flex items-center justify-between p-3 bg-indigo-50 dark:bg-indigo-900/20 rounded-xl">
                            <div class="flex items-center">
                                <div class="p-2 bg-indigo-100 dark:bg-indigo-800 rounded-lg">
                                    <iconify-icon icon="heroicons:truck-20-solid"
                                        class="w-4 h-4 text-indigo-600 dark:text-indigo-400"></iconify-icon>
                                </div>
                                <div class="ml-3">
                                    <p class="text-sm font-medium text-indigo-900 dark:text-indigo-300">Total Mobil</p>
                                    <p class="text-xs text-indigo-600 dark:text-indigo-400">Terdaftar</p>
                                </div>
                            </div>
                            <div class="text-2xl font-bold text-indigo-600 dark:text-indigo-400">
                                {{ $jenisSewa->hargaSewa->count() }}
                            </div>
                        </div>

                        <!-- Harga Aktif -->
                        <div class="flex items-center justify-between p-3 bg-green-50 dark:bg-green-900/20 rounded-xl">
                            <div class="flex items-center">
                                <div class="p-2 bg-green-100 dark:bg-green-800 rounded-lg">
                                    <iconify-icon icon="heroicons:check-circle-20-solid"
                                        class="w-4 h-4 text-green-600 dark:text-green-400"></iconify-icon>
                                </div>
                                <div class="ml-3">
                                    <p class="text-sm font-medium text-green-900 dark:text-green-300">Harga Aktif</p>
                                    <p class="text-xs text-green-600 dark:text-green-400">Tersedia</p>
                                </div>
                            </div>
                            <div class="text-2xl font-bold text-green-600 dark:text-green-400">
                                {{ $jenisSewa->hargaSewa->where('aktif', true)->count() }}
                            </div>
                        </div>

                        <!-- Harga Nonaktif -->
                        <div class="flex items-center justify-between p-3 bg-gray-50 dark:bg-gray-700/50 rounded-xl">
                            <div class="flex items-center">
                                <div class="p-2 bg-gray-100 dark:bg-gray-600 rounded-lg">
                                    <iconify-icon icon="heroicons:x-circle-20-solid"
                                        class="w-4 h-4 text-gray-600 dark:text-gray-400"></iconify-icon>
                                </div>
                                <div class="ml-3">
                                    <p class="text-sm font-medium text-gray-900 dark:text-gray-300">Harga Nonaktif</p>
                                    <p class="text-xs text-gray-600 dark:text-gray-400">Tidak Tersedia</p>
                                </div>
                            </div>
                            <div class="text-2xl font-bold text-gray-600 dark:text-gray-400">
                                {{ $jenisSewa->hargaSewa->where('aktif', false)->count() }}
                            </div>
                        </div>

                        @if ($jenisSewa->tarif_denda_per_hari)
                            <!-- Tarif Denda -->
                            <div
                                class="flex items-center justify-between p-3 bg-orange-50 dark:bg-orange-900/20 rounded-xl">
                                <div class="flex items-center">
                                    <div class="p-2 bg-orange-100 dark:bg-orange-800 rounded-lg">
                                        <iconify-icon icon="heroicons:exclamation-triangle-20-solid"
                                            class="w-4 h-4 text-orange-600 dark:text-orange-400"></iconify-icon>
                                    </div>
                                    <div class="ml-3">
                                        <p class="text-sm font-medium text-orange-900 dark:text-orange-300">Denda</p>
                                        <p class="text-xs text-orange-600 dark:text-orange-400">Per Hari</p>
                                    </div>
                                </div>
                                <div class="text-right">
                                    <div class="text-lg font-bold text-orange-600 dark:text-orange-400">
                                        Rp {{ number_format($jenisSewa->tarif_denda_per_hari / 1000, 0) }}K
                                    </div>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>

                <!-- Actions -->
                <div
                    class="bg-white dark:bg-gray-800 rounded-2xl shadow-sm border border-gray-200 dark:border-gray-700 p-6">
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4 flex items-center">
                        <iconify-icon icon="heroicons:cog-6-tooth-20-solid"
                            class="w-5 h-5 mr-2 text-indigo-600"></iconify-icon>
                        Aksi
                    </h3>

                    <div class="space-y-3">
                        <a href="{{ route('admin.jenis-sewa.edit', $jenisSewa) }}"
                            class="w-full inline-flex items-center justify-center px-4 py-2 bg-indigo-600 hover:bg-indigo-700 text-white text-sm font-medium rounded-xl transition-colors duration-200">
                            <iconify-icon icon="heroicons:pencil-20-solid" class="w-4 h-4 mr-2"></iconify-icon>
                            Edit Jenis Sewa
                        </a>

                        @if ($jenisSewa->hargaSewa->where('aktif', true)->count() == 0)
                            <form method="POST" action="{{ route('admin.jenis-sewa.destroy', $jenisSewa) }}"
                                onsubmit="return confirm('Apakah Anda yakin ingin menghapus jenis sewa ini?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit"
                                    class="w-full inline-flex items-center justify-center px-4 py-2 bg-red-600 hover:bg-red-700 text-white text-sm font-medium rounded-xl transition-colors duration-200">
                                    <iconify-icon icon="heroicons:trash-20-solid" class="w-4 h-4 mr-2"></iconify-icon>
                                    Hapus Jenis Sewa
                                </button>
                            </form>
                        @else
                            <div
                                class="p-3 bg-yellow-50 dark:bg-yellow-900/20 border border-yellow-200 dark:border-yellow-800 rounded-xl">
                                <div class="flex items-start">
                                    <iconify-icon icon="heroicons:exclamation-triangle-20-solid"
                                        class="w-5 h-5 text-yellow-600 dark:text-yellow-400 mt-0.5 mr-3"></iconify-icon>
                                    <div class="text-sm text-yellow-700 dark:text-yellow-300">
                                        <p class="font-medium">Tidak dapat dihapus</p>
                                        <p>Jenis sewa ini masih memiliki harga aktif pada
                                            {{ $jenisSewa->hargaSewa->where('aktif', true)->count() }} mobil.</p>
                                    </div>
                                </div>
                            </div>
                        @endif

                        <a href="{{ route('admin.jenis-sewa.index') }}"
                            class="w-full inline-flex items-center justify-center px-4 py-2 bg-gray-500 hover:bg-gray-600 text-white text-sm font-medium rounded-xl transition-colors duration-200">
                            <iconify-icon icon="heroicons:arrow-left-20-solid" class="w-4 h-4 mr-2"></iconify-icon>
                            Kembali ke Daftar
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
