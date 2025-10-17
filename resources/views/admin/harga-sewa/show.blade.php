@extends('layouts.admin')

@section('title', 'Pricing Details')
@section('page-title', 'Pricing Details')
@section('page-subtitle', 'View rental pricing information')

@section('content')
    <div class="max-w-6xl mx-auto">
        <!-- Header -->
        <div class="mb-6 flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
            <div>
                <a href="{{ route('admin.harga-sewa.index') }}"
                    class="inline-flex items-center text-sm text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-white mb-2">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                    </svg>
                    Back to Pricing List
                </a>
                <h1 class="text-2xl font-bold text-gray-900 dark:text-white">{{ $hargaSewa->mobil->merk }}
                    {{ $hargaSewa->mobil->model }}</h1>
                <p class="text-gray-600 dark:text-gray-400">{{ $hargaSewa->jenisSewa->nama_jenis }} - Pricing Details</p>
            </div>

            <div class="flex items-center space-x-3">
                <a href="{{ route('admin.harga-sewa.edit', $hargaSewa) }}"
                    class="inline-flex items-center px-4 py-2 bg-indigo-600 hover:bg-indigo-700 text-white text-sm font-medium rounded-xl transition-colors duration-200">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                    </svg>
                    Edit
                </a>

                <form action="{{ route('admin.harga-sewa.destroy', $hargaSewa) }}" method="POST"
                    onsubmit="return confirm('Are you sure you want to delete this pricing?')" class="inline">
                    @csrf
                    @method('DELETE')
                    <button type="submit"
                        class="inline-flex items-center px-4 py-2 bg-red-600 hover:bg-red-700 text-white text-sm font-medium rounded-xl transition-colors duration-200">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                        </svg>
                        Delete
                    </button>
                </form>
            </div>
        </div>

        <!-- Main Content -->
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            <!-- Vehicle Information -->
            <div class="lg:col-span-2">
                <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-sm border border-gray-100 dark:border-gray-700">
                    <div class="px-6 py-4 border-b border-gray-200 dark:border-gray-700">
                        <div class="flex items-center">
                            <div class="flex-shrink-0 mr-4">
                                <div
                                    class="w-12 h-12 bg-blue-100 dark:bg-blue-900 rounded-xl flex items-center justify-center">
                                    <iconify-icon icon="heroicons:truck-20-solid"
                                        class="w-6 h-6 text-blue-600 dark:text-blue-400"></iconify-icon>
                                </div>
                            </div>
                            <div>
                                <h3 class="text-lg font-semibold text-gray-900 dark:text-white">Vehicle Information</h3>
                                <p class="text-sm text-gray-600 dark:text-gray-400">Details about the rental vehicle</p>
                            </div>
                        </div>
                    </div>

                    <div class="p-6">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div class="space-y-4">
                                <div>
                                    <label class="text-sm font-medium text-gray-500 dark:text-gray-400">Brand &
                                        Model</label>
                                    <p class="text-lg font-semibold text-gray-900 dark:text-white">
                                        {{ $hargaSewa->mobil->merk }} {{ $hargaSewa->mobil->model }}</p>
                                </div>

                                <div>
                                    <label class="text-sm font-medium text-gray-500 dark:text-gray-400">License
                                        Plate</label>
                                    <p class="text-lg font-semibold text-gray-900 dark:text-white">
                                        {{ $hargaSewa->mobil->no_plat }}</p>
                                </div>

                                <div>
                                    <label class="text-sm font-medium text-gray-500 dark:text-gray-400">Year</label>
                                    <p class="text-lg font-semibold text-gray-900 dark:text-white">
                                        {{ $hargaSewa->mobil->tahun }}</p>
                                </div>
                            </div>

                            <div class="space-y-4">
                                <div>
                                    <label class="text-sm font-medium text-gray-500 dark:text-gray-400">Color</label>
                                    <p class="text-lg font-semibold text-gray-900 dark:text-white">
                                        {{ $hargaSewa->mobil->warna }}</p>
                                </div>

                                <div>
                                    <label class="text-sm font-medium text-gray-500 dark:text-gray-400">Transmission</label>
                                    <p class="text-lg font-semibold text-gray-900 dark:text-white">
                                        {{ ucfirst($hargaSewa->mobil->transmisi) }}</p>
                                </div>

                                <div>
                                    <label class="text-sm font-medium text-gray-500 dark:text-gray-400">Fuel Type</label>
                                    <p class="text-lg font-semibold text-gray-900 dark:text-white">
                                        {{ ucfirst($hargaSewa->mobil->bahan_bakar) }}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Pricing Details -->
            <div class="space-y-6">
                <!-- Price Card -->
                <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-sm border border-gray-100 dark:border-gray-700">
                    <div class="px-6 py-4 border-b border-gray-200 dark:border-gray-700">
                        <div class="flex items-center">
                            <div class="flex-shrink-0 mr-3">
                                @if ($hargaSewa->jenisSewa->slug === 'harian')
                                    <div
                                        class="w-10 h-10 bg-blue-100 dark:bg-blue-900 rounded-lg flex items-center justify-center">
                                        <iconify-icon icon="heroicons:clock-20-solid"
                                            class="w-5 h-5 text-blue-600 dark:text-blue-400"></iconify-icon>
                                    </div>
                                @elseif ($hargaSewa->jenisSewa->slug === 'luar-kota')
                                    <div
                                        class="w-10 h-10 bg-green-100 dark:bg-green-900 rounded-lg flex items-center justify-center">
                                        <iconify-icon icon="heroicons:map-pin-20-solid"
                                            class="w-5 h-5 text-green-600 dark:text-green-400"></iconify-icon>
                                    </div>
                                @elseif ($hargaSewa->jenisSewa->slug === 'dengan-sopir')
                                    <div
                                        class="w-10 h-10 bg-purple-100 dark:bg-purple-900 rounded-lg flex items-center justify-center">
                                        <iconify-icon icon="heroicons:user-20-solid"
                                            class="w-5 h-5 text-purple-600 dark:text-purple-400"></iconify-icon>
                                    </div>
                                @else
                                    <div
                                        class="w-10 h-10 bg-gray-100 dark:bg-gray-600 rounded-lg flex items-center justify-center">
                                        <iconify-icon icon="heroicons:calendar-20-solid"
                                            class="w-5 h-5 text-gray-600 dark:text-gray-400"></iconify-icon>
                                    </div>
                                @endif
                            </div>
                            <div>
                                <h3 class="text-lg font-semibold text-gray-900 dark:text-white">
                                    {{ $hargaSewa->jenisSewa->nama_jenis }}</h3>
                                <p class="text-sm text-gray-600 dark:text-gray-400">Rental Type</p>
                            </div>
                        </div>
                    </div>

                    <div class="p-6">
                        <div class="text-center">
                            <p class="text-3xl font-bold text-indigo-600 dark:text-indigo-400">
                                Rp {{ number_format($hargaSewa->harga_per_hari, 0, ',', '.') }}
                            </p>
                            <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">per day</p>
                        </div>
                    </div>
                </div>

                <!-- Status Card -->
                <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-sm border border-gray-100 dark:border-gray-700">
                    <div class="px-6 py-4 border-b border-gray-200 dark:border-gray-700">
                        <h3 class="text-lg font-semibold text-gray-900 dark:text-white">Status Information</h3>
                    </div>

                    <div class="p-6 space-y-4">
                        <!-- Active Status -->
                        <div class="flex items-center justify-between">
                            <span class="text-sm font-medium text-gray-700 dark:text-gray-300">Status</span>
                            @if ($hargaSewa->aktif)
                                <span
                                    class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200">
                                    <svg class="w-2 h-2 mr-1" fill="currentColor" viewBox="0 0 8 8">
                                        <circle cx="4" cy="4" r="3" />
                                    </svg>
                                    Active
                                </span>
                            @else
                                <span
                                    class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-200">
                                    <svg class="w-2 h-2 mr-1" fill="currentColor" viewBox="0 0 8 8">
                                        <circle cx="4" cy="4" r="3" />
                                    </svg>
                                    Inactive
                                </span>
                            @endif
                        </div>

                        <!-- Valid From -->
                        <div class="flex items-center justify-between">
                            <span class="text-sm font-medium text-gray-700 dark:text-gray-300">Valid From</span>
                            <span class="text-sm text-gray-900 dark:text-white">
                                {{ $hargaSewa->berlaku_dari ? $hargaSewa->berlaku_dari->format('d M Y') : '-' }}
                            </span>
                        </div>

                        <!-- Valid Until -->
                        <div class="flex items-center justify-between">
                            <span class="text-sm font-medium text-gray-700 dark:text-gray-300">Valid Until</span>
                            <span class="text-sm text-gray-900 dark:text-white">
                                {{ $hargaSewa->berlaku_sampai ? $hargaSewa->berlaku_sampai->format('d M Y') : 'No expiry' }}
                            </span>
                        </div>

                        <!-- Created Date -->
                        <div class="flex items-center justify-between">
                            <span class="text-sm font-medium text-gray-700 dark:text-gray-300">Created</span>
                            <span class="text-sm text-gray-900 dark:text-white">
                                {{ $hargaSewa->created_at->format('d M Y, H:i') }}
                            </span>
                        </div>

                        <!-- Updated Date -->
                        <div class="flex items-center justify-between">
                            <span class="text-sm font-medium text-gray-700 dark:text-gray-300">Last Updated</span>
                            <span class="text-sm text-gray-900 dark:text-white">
                                {{ $hargaSewa->updated_at->format('d M Y, H:i') }}
                            </span>
                        </div>
                    </div>
                </div>

                @if ($hargaSewa->keterangan)
                    <!-- Notes Card -->
                    <div
                        class="bg-white dark:bg-gray-800 rounded-2xl shadow-sm border border-gray-100 dark:border-gray-700">
                        <div class="px-6 py-4 border-b border-gray-200 dark:border-gray-700">
                            <h3 class="text-lg font-semibold text-gray-900 dark:text-white">Notes</h3>
                        </div>

                        <div class="p-6">
                            <p class="text-gray-700 dark:text-gray-300">{{ $hargaSewa->keterangan }}</p>
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>
@endsection
class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium
                                {{ $isActive ? 'bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200' : 'bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-200' }}">
{{ $isActive ? 'Aktif' : 'Tidak Aktif' }}
</span>
</div>
</div>

<div class="p-8">
    <!-- Price Display -->
    <div class="text-center mb-8">
        <div class="text-4xl font-bold text-gray-900 dark:text-white mb-2">
            Rp {{ number_format($hargaSewa->harga_per_hari, 0, ',', '.') }}
        </div>
        <div class="text-lg text-gray-600 dark:text-gray-400">per hari</div>
    </div>

    <!-- Details Grid -->
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        <!-- Jenis Sewa Details -->
        <div class="space-y-4">
            <h3 class="text-sm font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wide">
                Informasi Jenis Sewa
            </h3>
            <div class="space-y-3">
                <div>
                    <dt class="text-sm font-medium text-gray-900 dark:text-white">Nama Jenis</dt>
                    <dd class="text-sm text-gray-600 dark:text-gray-400">
                        {{ $hargaSewa->jenisSewa->nama_jenis }}</dd>
                </div>
                @if ($hargaSewa->jenisSewa->keterangan)
                    <div>
                        <dt class="text-sm font-medium text-gray-900 dark:text-white">Keterangan Jenis
                        </dt>
                        <dd class="text-sm text-gray-600 dark:text-gray-400">
                            {{ $hargaSewa->jenisSewa->keterangan }}</dd>
                    </div>
                @endif
            </div>
        </div>

        <!-- Validity Period -->
        <div class="space-y-4">
            <h3 class="text-sm font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wide">
                Periode Berlaku
            </h3>
            <div class="space-y-3">
                <div>
                    <dt class="text-sm font-medium text-gray-900 dark:text-white">Berlaku Dari</dt>
                    <dd class="text-sm text-gray-600 dark:text-gray-400">
                        {{ \Carbon\Carbon::parse($hargaSewa->berlaku_dari)->format('d F Y') }}
                    </dd>
                </div>
                <div>
                    <dt class="text-sm font-medium text-gray-900 dark:text-white">Berlaku Sampai</dt>
                    <dd class="text-sm text-gray-600 dark:text-gray-400">
                        @if ($hargaSewa->berlaku_sampai)
                            {{ \Carbon\Carbon::parse($hargaSewa->berlaku_sampai)->format('d F Y') }}
                        @else
                            <span class="text-green-600 dark:text-green-400 font-medium">Tidak
                                terbatas</span>
                        @endif
                    </dd>
                </div>
                <div>
                    <dt class="text-sm font-medium text-gray-900 dark:text-white">Durasi</dt>
                    <dd class="text-sm text-gray-600 dark:text-gray-400">
                        @if ($hargaSewa->berlaku_sampai)
                            {{ $start->diffInDays(\Carbon\Carbon::parse($hargaSewa->berlaku_sampai)) + 1 }}
                            hari
                        @else
                            Tidak terbatas
                        @endif
                    </dd>
                </div>
            </div>
        </div>
    </div>

    @if ($hargaSewa->keterangan)
        <!-- Additional Notes -->
        <div class="mt-8 pt-6 border-t border-gray-200 dark:border-gray-700">
            <h3 class="text-sm font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wide mb-3">
                Keterangan Tambahan
            </h3>
            <div class="bg-gray-50 dark:bg-gray-700 rounded-xl p-4">
                <p class="text-sm text-gray-900 dark:text-white leading-relaxed">
                    {{ $hargaSewa->keterangan }}
                </p>
            </div>
        </div>
    @endif

    <!-- Metadata -->
    <div class="mt-8 pt-6 border-t border-gray-200 dark:border-gray-700">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div>
                <dt class="text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wide">
                    Dibuat</dt>
                <dd class="mt-1 text-sm text-gray-900 dark:text-white">
                    {{ $hargaSewa->created_at->format('d F Y, H:i') }}
                </dd>
            </div>
            <div>
                <dt class="text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wide">
                    Terakhir Diperbarui</dt>
                <dd class="mt-1 text-sm text-gray-900 dark:text-white">
                    {{ $hargaSewa->updated_at->format('d F Y, H:i') }}
                </dd>
            </div>
        </div>
    </div>
</div>
</div>
</div>

<!-- Action Sidebar -->
<div class="space-y-6">
    <!-- Quick Actions -->
    <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-sm border border-gray-100 dark:border-gray-700">
        <div class="px-6 py-4 border-b border-gray-200 dark:border-gray-700">
            <h3 class="text-lg font-semibold text-gray-900 dark:text-white">Aksi</h3>
        </div>
        <div class="p-6 space-y-3">
            <a href="{{ route('admin.harga-sewa.edit', $hargaSewa) }}"
                class="w-full inline-flex items-center justify-center px-4 py-3 bg-gradient-to-r from-amber-500 to-orange-600 hover:from-amber-600 hover:to-orange-700 text-white font-medium rounded-xl transition-all duration-200 shadow-lg hover:shadow-xl">
                <iconify-icon icon="heroicons:pencil-20-solid" class="w-4 h-4 mr-2"></iconify-icon>
                Edit Harga Sewa
            </a>

            <form method="POST" action="{{ route('admin.harga-sewa.destroy', $hargaSewa) }}"
                onsubmit="return confirm('Yakin ingin menghapus harga sewa ini? Tindakan ini tidak dapat dibatalkan.')">
                @csrf
                @method('DELETE')
                <button type="submit"
                    class="w-full inline-flex items-center justify-center px-4 py-3 bg-gradient-to-r from-red-500 to-pink-600 hover:from-red-600 hover:to-pink-700 text-white font-medium rounded-xl transition-all duration-200 shadow-lg hover:shadow-xl">
                    <iconify-icon icon="heroicons:trash-20-solid" class="w-4 h-4 mr-2"></iconify-icon>
                    Hapus Harga Sewa
                </button>
            </form>
        </div>
    </div>

    <!-- Status Info -->
    <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-sm border border-gray-100 dark:border-gray-700">
        <div class="px-6 py-4 border-b border-gray-200 dark:border-gray-700">
            <h3 class="text-lg font-semibold text-gray-900 dark:text-white">Status Informasi</h3>
        </div>
        <div class="p-6">
            <div class="space-y-4">
                <!-- Current Status -->
                <div
                    class="flex items-center gap-3 p-3 rounded-xl {{ $isActive ? 'bg-green-50 dark:bg-green-900/20' : 'bg-red-50 dark:bg-red-900/20' }}">
                    <div class="flex-shrink-0">
                        <iconify-icon
                            icon="{{ $isActive ? 'heroicons:check-circle-20-solid' : 'heroicons:x-circle-20-solid' }}"
                            class="w-5 h-5 {{ $isActive ? 'text-green-600 dark:text-green-400' : 'text-red-600 dark:text-red-400' }}">
                        </iconify-icon>
                    </div>
                    <div>
                        <div
                            class="text-sm font-medium {{ $isActive ? 'text-green-900 dark:text-green-200' : 'text-red-900 dark:text-red-200' }}">
                            {{ $isActive ? 'Tarif Aktif' : 'Tarif Tidak Aktif' }}
                        </div>
                        <div
                            class="text-xs {{ $isActive ? 'text-green-700 dark:text-green-300' : 'text-red-700 dark:text-red-300' }}">
                            @if ($isActive)
                                Tarif saat ini berlaku
                            @else
                                Tarif tidak berlaku saat ini
                            @endif
                        </div>
                    </div>
                </div>

                <!-- Time until expiry -->
                @if ($isActive && $end)
                    <div class="flex items-center gap-3 p-3 bg-amber-50 dark:bg-amber-900/20 rounded-xl">
                        <div class="flex-shrink-0">
                            <iconify-icon icon="heroicons:clock-20-solid"
                                class="w-5 h-5 text-amber-600 dark:text-amber-400"></iconify-icon>
                        </div>
                        <div>
                            <div class="text-sm font-medium text-amber-900 dark:text-amber-200">
                                Berakhir dalam {{ $now->diffInDays($end) }} hari
                            </div>
                            <div class="text-xs text-amber-700 dark:text-amber-300">
                                {{ $end->format('d F Y') }}
                            </div>
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
</div>
</div>
@endsection
