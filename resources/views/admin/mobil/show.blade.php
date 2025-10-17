@php
    use Illuminate\Support\Facades\Storage;
@endphp

@extends('layouts.admin')

@section('title', 'Detail Mobil')
@section('page-title', 'Detail Mobil')
@section('page-subtitle', 'Lihat informasi kendaraan')

@section('content')
    <div class="max-w-6xl mx-auto">
        <!-- Header -->
        <div class="mb-6 flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
            <div>
                <a href="{{ route('admin.mobil.index') }}"
                    class="inline-flex items-center text-sm text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-white mb-2">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                    </svg>
                    Kembali ke Daftar Mobil
                </a>
                <h1 class="text-2xl font-bold text-gray-900 dark:text-white">
                    {{ $mobil->nama_mobil ?? $mobil->merk . ' ' . $mobil->model }}</h1>
                <p class="text-gray-600 dark:text-gray-400">{{ $mobil->tahun }} • {{ $mobil->plat_nomor }} •
                    {{ $mobil->warna }}</p>
            </div>

            <div class="flex items-center space-x-3">
                <a href="{{ route('admin.mobil.edit', $mobil) }}"
                    class="inline-flex items-center px-4 py-2 bg-indigo-600 hover:bg-indigo-700 text-white text-sm font-medium rounded-xl transition-colors duration-200">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                    </svg>
                    Edit
                </a>

                <form action="{{ route('admin.mobil.destroy', $mobil) }}" method="POST"
                    onsubmit="return confirm('Apakah Anda yakin ingin menghapus mobil ini?')" class="inline">
                    @csrf
                    @method('DELETE')
                    <button type="submit"
                        class="inline-flex items-center px-4 py-2 bg-red-600 hover:bg-red-700 text-white text-sm font-medium rounded-xl transition-colors duration-200">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                        </svg>
                        Hapus
                    </button>
                </form>
            </div>
        </div>

        <!-- Main Content -->
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            <!-- Car Photo & Basic Info -->
            <div class="lg:col-span-2">
                <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-sm border border-gray-100 dark:border-gray-700">
                    <!-- Foto Mobil -->
                    @if ($mobil->foto)
                        <div class="p-6 border-b border-gray-200 dark:border-gray-700">
                            <img src="{{ asset('storage/' . $mobil->foto) }}"
                                alt="{{ $mobil->nama_mobil ?? $mobil->merk . ' ' . $mobil->model }}"
                                class="w-full h-64 object-cover rounded-xl">
                        </div>
                    @endif

                    <!-- Informasi Dasar -->
                    <div class="p-6">
                        <div class="flex items-center mb-6">
                            <div class="flex-shrink-0 mr-4">
                                <div
                                    class="w-12 h-12 bg-blue-100 dark:bg-blue-900 rounded-xl flex items-center justify-center">
                                    <iconify-icon icon="heroicons:truck-20-solid"
                                        class="w-6 h-6 text-blue-600 dark:text-blue-400"></iconify-icon>
                                </div>
                            </div>
                            <div>
                                <h3 class="text-lg font-semibold text-gray-900 dark:text-white">Informasi Kendaraan</h3>
                                <p class="text-sm text-gray-600 dark:text-gray-400">Detail dasar tentang mobil rental ini
                                </p>
                            </div>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div class="space-y-4">
                                <div>
                                    <label class="text-sm font-medium text-gray-500 dark:text-gray-400">Nama Mobil</label>
                                    <p class="text-lg font-semibold text-gray-900 dark:text-white">
                                        {{ $mobil->nama_mobil ?? $mobil->merk . ' ' . $mobil->model }}</p>
                                </div>

                                <div>
                                    <label class="text-sm font-medium text-gray-500 dark:text-gray-400">Merek &
                                        Model</label>
                                    <p class="text-lg font-semibold text-gray-900 dark:text-white">{{ $mobil->merk }}
                                        {{ $mobil->model }}</p>
                                </div>

                                <div>
                                    <label class="text-sm font-medium text-gray-500 dark:text-gray-400">Tahun</label>
                                    <p class="text-lg font-semibold text-gray-900 dark:text-white">{{ $mobil->tahun }}</p>
                                </div>

                                <div>
                                    <label class="text-sm font-medium text-gray-500 dark:text-gray-400">Plat Nomor</label>
                                    <p
                                        class="text-lg font-mono font-semibold text-gray-900 dark:text-white bg-gray-100 dark:bg-gray-700 px-3 py-1 rounded-lg inline-block">
                                        {{ $mobil->plat_nomor }}</p>
                                </div>

                                <div>
                                    <label class="text-sm font-medium text-gray-500 dark:text-gray-400">Warna</label>
                                    <p class="text-lg font-semibold text-gray-900 dark:text-white">{{ $mobil->warna }}</p>
                                </div>
                            </div>

                            <div class="space-y-4">
                                <div>
                                    <label class="text-sm font-medium text-gray-500 dark:text-gray-400">Transmisi</label>
                                    <div class="flex items-center">
                                        <iconify-icon icon="heroicons:cog-8-tooth-20-solid"
                                            class="w-5 h-5 mr-2 text-gray-400"></iconify-icon>
                                        <p class="text-lg font-semibold text-gray-900 dark:text-white">
                                            @if ($mobil->transmisi === 'automatic')
                                                Otomatis
                                            @elseif($mobil->transmisi === 'manual')
                                                Manual
                                            @elseif($mobil->transmisi === 'cvt')
                                                CVT
                                            @else
                                                {{ ucfirst($mobil->transmisi) }}
                                            @endif
                                        </p>
                                    </div>
                                </div>

                                <div>
                                    <label class="text-sm font-medium text-gray-500 dark:text-gray-400">Jenis Bahan
                                        Bakar</label>
                                    <div class="flex items-center">
                                        <iconify-icon icon="heroicons:fire-20-solid"
                                            class="w-5 h-5 mr-2 text-gray-400"></iconify-icon>
                                        <p class="text-lg font-semibold text-gray-900 dark:text-white">
                                            @if ($mobil->jenis_bahan_bakar === 'bensin')
                                                Bensin
                                            @elseif($mobil->jenis_bahan_bakar === 'diesel')
                                                Diesel
                                            @elseif($mobil->jenis_bahan_bakar === 'listrik')
                                                Listrik
                                            @elseif($mobil->jenis_bahan_bakar === 'hybrid')
                                                Hybrid
                                            @else
                                                {{ ucfirst($mobil->jenis_bahan_bakar) }}
                                            @endif
                                        </p>
                                    </div>
                                </div>

                                <div>
                                    <label class="text-sm font-medium text-gray-500 dark:text-gray-400">Kapasitas
                                        Penumpang</label>
                                    <div class="flex items-center">
                                        <iconify-icon icon="heroicons:user-group-20-solid"
                                            class="w-5 h-5 mr-2 text-gray-400"></iconify-icon>
                                        <p class="text-lg font-semibold text-gray-900 dark:text-white">
                                            {{ $mobil->kapasitas_penumpang }} penumpang</p>
                                    </div>
                                </div>

                                <div>
                                    <label class="text-sm font-medium text-gray-500 dark:text-gray-400">Status Saat
                                        Ini</label>
                                    <div class="mt-1">
                                        @if ($mobil->status === 'tersedia')
                                            <span
                                                class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200">
                                                <iconify-icon icon="heroicons:check-circle-20-solid"
                                                    class="w-4 h-4 mr-1"></iconify-icon>
                                                Tersedia
                                            </span>
                                        @elseif ($mobil->status === 'disewa')
                                            <span
                                                class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-orange-100 text-orange-800 dark:bg-orange-900 dark:text-orange-200">
                                                <iconify-icon icon="heroicons:key-20-solid"
                                                    class="w-4 h-4 mr-1"></iconify-icon>
                                                Disewa
                                            </span>
                                        @elseif ($mobil->status === 'perawatan')
                                            <span
                                                class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-200">
                                                <iconify-icon icon="heroicons:wrench-screwdriver-20-solid"
                                                    class="w-4 h-4 mr-1"></iconify-icon>
                                                Perawatan
                                            </span>
                                        @else
                                            <span
                                                class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-gray-100 text-gray-800 dark:bg-gray-900 dark:text-gray-200">
                                                <iconify-icon icon="heroicons:x-circle-20-solid"
                                                    class="w-4 h-4 mr-1"></iconify-icon>
                                                Non Aktif
                                            </span>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>

                        {{-- Catatan tidak ditampilkan karena field ini tidak ada di database --}}
                    </div>
                </div>
            </div>
            <div class="space-y-6">
                <!-- Informasi Harga -->
                @if ($mobil->hargaSewa && $mobil->hargaSewa->count() > 0)
                    <div
                        class="bg-white dark:bg-gray-800 rounded-2xl shadow-sm border border-gray-100 dark:border-gray-700">
                        <div class="px-6 py-4 border-b border-gray-200 dark:border-gray-700">
                            <div class="flex items-center">
                                <div class="flex-shrink-0 mr-3">
                                    <div
                                        class="w-10 h-10 bg-green-100 dark:bg-green-900 rounded-lg flex items-center justify-center">
                                        <iconify-icon icon="heroicons:currency-dollar-20-solid"
                                            class="w-5 h-5 text-green-600 dark:text-green-400"></iconify-icon>
                                    </div>
                                </div>
                                <div>
                                    <h3 class="text-lg font-semibold text-gray-900 dark:text-white">Harga Sewa</h3>
                                    <p class="text-sm text-gray-600 dark:text-gray-400">Tarif sewa yang tersedia</p>
                                </div>
                            </div>
                        </div>

                        <div class="p-6 space-y-3">
                            @foreach ($mobil->hargaSewa as $harga)
                                <div class="flex justify-between items-center p-3 bg-gray-50 dark:bg-gray-700 rounded-lg">
                                    <div>
                                        <p class="text-sm font-medium text-gray-900 dark:text-white">
                                            {{ $harga->jenisSewa->nama_jenis }}</p>
                                        @if ($harga->catatan)
                                            <p class="text-xs text-gray-500 dark:text-gray-400">{{ $harga->catatan }}</p>
                                        @endif
                                    </div>
                                    <div class="text-right">
                                        <p class="text-lg font-semibold text-indigo-600 dark:text-indigo-400">
                                            Rp {{ number_format($harga->harga_per_hari, 0, ',', '.') }}
                                        </p>
                                        <p class="text-xs text-gray-500 dark:text-gray-400">per hari</p>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endif

                <!-- Informasi Sistem -->
                <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-sm border border-gray-100 dark:border-gray-700">
                    <div class="px-6 py-4 border-b border-gray-200 dark:border-gray-700">
                        <h3 class="text-lg font-semibold text-gray-900 dark:text-white">Informasi Sistem</h3>
                    </div>

                    <div class="p-6 space-y-4">
                        <div class="flex items-center justify-between">
                            <span class="text-sm font-medium text-gray-700 dark:text-gray-300">Dibuat</span>
                            <span class="text-sm text-gray-900 dark:text-white">
                                {{ $mobil->created_at->format('d M Y, H:i') }}
                            </span>
                        </div>

                        <div class="flex items-center justify-between">
                            <span class="text-sm font-medium text-gray-700 dark:text-gray-300">Terakhir Diperbarui</span>
                            <span class="text-sm text-gray-900 dark:text-white">
                                {{ $mobil->updated_at->format('d M Y, H:i') }}
                            </span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
