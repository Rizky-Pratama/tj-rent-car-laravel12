@extends('layouts.admin')

@section('title', 'Detail Sopir')

@section('content')
    <div class="max-w-4xl mx-auto">
        <!-- Header -->
        <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-sm border border-gray-200 dark:border-gray-700 p-6 mb-6">
            <div class="flex items-center justify-between">
                <div>
                    <h1 class="text-2xl font-bold text-gray-900 dark:text-white">Detail Sopir</h1>
                    <p class="text-sm text-gray-600 dark:text-gray-400">Informasi lengkap sopir {{ $sopir->nama }}</p>
                </div>
                <div class="flex items-center space-x-3">
                    <a href="{{ route('admin.sopir.edit', $sopir) }}"
                        class="inline-flex items-center px-4 py-2 bg-indigo-600 hover:bg-indigo-700 text-white text-sm font-medium rounded-xl transition-colors duration-200">
                        <iconify-icon icon="heroicons:pencil-20-solid" class="w-4 h-4 mr-2"></iconify-icon>
                        Edit
                    </a>
                    <a href="{{ route('admin.sopir.index') }}"
                        class="inline-flex items-center px-4 py-2 bg-gray-500 hover:bg-gray-600 text-white text-sm font-medium rounded-xl transition-colors duration-200">
                        <iconify-icon icon="heroicons:arrow-left-20-solid" class="w-4 h-4 mr-2"></iconify-icon>
                        Kembali
                    </a>
                </div>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            <!-- Left Column - Photo & Quick Info -->
            <div class="lg:col-span-1">
                <!-- Photo Card -->
                <div
                    class="bg-white dark:bg-gray-800 rounded-2xl shadow-sm border border-gray-200 dark:border-gray-700 p-6 mb-6">
                    <div class="text-center">
                        <div
                            class="w-32 h-32 mx-auto mb-4 rounded-full overflow-hidden bg-gray-100 dark:bg-gray-700 border-4 border-white dark:border-gray-800 shadow-lg">
                            @if ($sopir->foto)
                                <img src="{{ Storage::url($sopir->foto) }}" alt="Foto {{ $sopir->nama }}"
                                    class="w-full h-full object-cover">
                            @else
                                <div
                                    class="w-full h-full flex items-center justify-center bg-gradient-to-br from-indigo-500 to-purple-600">
                                    <span class="text-3xl font-bold text-white">
                                        {{ strtoupper(substr($sopir->nama, 0, 2)) }}
                                    </span>
                                </div>
                            @endif
                        </div>
                        <h3 class="text-lg font-semibold text-gray-900 dark:text-white">{{ $sopir->nama }}</h3>
                        <div class="mt-2">
                            @if ($sopir->status === 'tersedia')
                                <span
                                    class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200">
                                    <iconify-icon icon="heroicons:check-circle-20-solid"
                                        class="w-4 h-4 mr-1"></iconify-icon>
                                    Tersedia
                                </span>
                            @elseif ($sopir->status === 'ditugaskan')
                                <span
                                    class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-orange-100 text-orange-800 dark:bg-orange-900 dark:text-orange-200">
                                    <iconify-icon icon="heroicons:briefcase-20-solid" class="w-4 h-4 mr-1"></iconify-icon>
                                    Ditugaskan
                                </span>
                            @else
                                <span
                                    class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-gray-100 text-gray-800 dark:bg-gray-700 dark:text-gray-200">
                                    <iconify-icon icon="heroicons:moon-20-solid" class="w-4 h-4 mr-1"></iconify-icon>
                                    Libur
                                </span>
                            @endif
                        </div>
                    </div>
                </div>

                <!-- Quick Actions Card -->
                <div
                    class="bg-white dark:bg-gray-800 rounded-2xl shadow-sm border border-gray-200 dark:border-gray-700 p-6">
                    <h4 class="text-sm font-semibold text-gray-900 dark:text-white mb-4">Aksi Cepat</h4>
                    <div class="space-y-3">
                        <a href="tel:{{ $sopir->no_telepon }}"
                            class="flex items-center w-full px-4 py-3 text-left bg-green-50 dark:bg-green-900/20 hover:bg-green-100 dark:hover:bg-green-900/30 rounded-xl transition-colors duration-200">
                            <iconify-icon icon="heroicons:phone-20-solid"
                                class="w-5 h-5 text-green-600 dark:text-green-400 mr-3"></iconify-icon>
                            <span class="text-sm font-medium text-green-700 dark:text-green-300">Hubungi Sopir</span>
                        </a>

                        @if ($sopir->status === 'tersedia')
                            <button type="button"
                                class="flex items-center w-full px-4 py-3 text-left bg-indigo-50 dark:bg-indigo-900/20 hover:bg-indigo-100 dark:hover:bg-indigo-900/30 rounded-xl transition-colors duration-200">
                                <iconify-icon icon="heroicons:calendar-20-solid"
                                    class="w-5 h-5 text-indigo-600 dark:text-indigo-400 mr-3"></iconify-icon>
                                <span class="text-sm font-medium text-indigo-700 dark:text-indigo-300">Jadwalkan
                                    Tugas</span>
                            </button>
                        @endif

                        <form method="POST" action="{{ route('admin.sopir.destroy', $sopir) }}"
                            onsubmit="return confirm('Apakah Anda yakin ingin menghapus sopir ini?')" class="w-full">
                            @csrf
                            @method('DELETE')
                            <button type="submit"
                                class="flex items-center w-full px-4 py-3 text-left bg-red-50 dark:bg-red-900/20 hover:bg-red-100 dark:hover:bg-red-900/30 rounded-xl transition-colors duration-200">
                                <iconify-icon icon="heroicons:trash-20-solid"
                                    class="w-5 h-5 text-red-600 dark:text-red-400 mr-3"></iconify-icon>
                                <span class="text-sm font-medium text-red-700 dark:text-red-300">Hapus Sopir</span>
                            </button>
                        </form>
                    </div>
                </div>
            </div>

            <!-- Right Column - Detailed Information -->
            <div class="lg:col-span-2">
                <div class="space-y-6">
                    <!-- Personal Information -->
                    <div
                        class="bg-white dark:bg-gray-800 rounded-2xl shadow-sm border border-gray-200 dark:border-gray-700 p-6">
                        <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-6 flex items-center">
                            <iconify-icon icon="heroicons:user-20-solid"
                                class="w-5 h-5 mr-2 text-indigo-600"></iconify-icon>
                            Informasi Personal
                        </h3>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label class="block text-sm font-medium text-gray-500 dark:text-gray-400 mb-2">Nama
                                    Lengkap</label>
                                <div class="px-4 py-3 bg-gray-50 dark:bg-gray-700/50 rounded-xl">
                                    <span
                                        class="text-sm font-medium text-gray-900 dark:text-white">{{ $sopir->nama }}</span>
                                </div>
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-500 dark:text-gray-400 mb-2">Nomor
                                    KTP</label>
                                <div class="px-4 py-3 bg-gray-50 dark:bg-gray-700/50 rounded-xl font-mono">
                                    <span
                                        class="text-sm font-medium text-gray-900 dark:text-white">{{ $sopir->no_ktp }}</span>
                                </div>
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-500 dark:text-gray-400 mb-2">Nomor
                                    Telepon</label>
                                <div class="px-4 py-3 bg-gray-50 dark:bg-gray-700/50 rounded-xl">
                                    <a href="tel:{{ $sopir->no_telepon }}"
                                        class="text-sm font-medium text-indigo-600 dark:text-indigo-400 hover:underline">
                                        {{ $sopir->no_telepon }}
                                    </a>
                                </div>
                            </div>

                            <div>
                                <label
                                    class="block text-sm font-medium text-gray-500 dark:text-gray-400 mb-2">Status</label>
                                <div class="px-4 py-3 bg-gray-50 dark:bg-gray-700/50 rounded-xl">
                                    @if ($sopir->status === 'tersedia')
                                        <span
                                            class="inline-flex items-center text-sm font-medium text-green-700 dark:text-green-300">
                                            <iconify-icon icon="heroicons:check-circle-20-solid"
                                                class="w-4 h-4 mr-2"></iconify-icon>
                                            Tersedia
                                        </span>
                                    @elseif ($sopir->status === 'ditugaskan')
                                        <span
                                            class="inline-flex items-center text-sm font-medium text-orange-700 dark:text-orange-300">
                                            <iconify-icon icon="heroicons:briefcase-20-solid"
                                                class="w-4 h-4 mr-2"></iconify-icon>
                                            Ditugaskan
                                        </span>
                                    @else
                                        <span
                                            class="inline-flex items-center text-sm font-medium text-gray-700 dark:text-gray-300">
                                            <iconify-icon icon="heroicons:moon-20-solid"
                                                class="w-4 h-4 mr-2"></iconify-icon>
                                            Libur
                                        </span>
                                    @endif
                                </div>
                            </div>
                        </div>

                        <div class="mt-6">
                            <label class="block text-sm font-medium text-gray-500 dark:text-gray-400 mb-2">Alamat</label>
                            <div class="px-4 py-3 bg-gray-50 dark:bg-gray-700/50 rounded-xl">
                                <span
                                    class="text-sm text-gray-900 dark:text-white whitespace-pre-line">{{ $sopir->alamat }}</span>
                            </div>
                        </div>
                    </div>

                    <!-- License Information -->
                    <div
                        class="bg-white dark:bg-gray-800 rounded-2xl shadow-sm border border-gray-200 dark:border-gray-700 p-6">
                        <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-6 flex items-center">
                            <iconify-icon icon="heroicons:identification-20-solid"
                                class="w-5 h-5 mr-2 text-indigo-600"></iconify-icon>
                            Informasi SIM
                        </h3>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label class="block text-sm font-medium text-gray-500 dark:text-gray-400 mb-2">Nomor
                                    SIM</label>
                                <div class="px-4 py-3 bg-gray-50 dark:bg-gray-700/50 rounded-xl font-mono">
                                    <span
                                        class="text-sm font-medium text-gray-900 dark:text-white">{{ $sopir->no_sim }}</span>
                                </div>
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-500 dark:text-gray-400 mb-2">Masa Berlaku
                                    SIM</label>
                                <div class="px-4 py-3 bg-gray-50 dark:bg-gray-700/50 rounded-xl">
                                    <div class="flex items-center">
                                        <span class="text-sm font-medium text-gray-900 dark:text-white mr-2">
                                            {{ $sopir->masa_berlaku_sim?->format('d F Y') ?? 'Tidak tersedia' }}
                                        </span>
                                        @if ($sopir->masa_berlaku_sim)
                                            @php
                                                $daysUntilExpiry = now()->diffInDays($sopir->masa_berlaku_sim, false);
                                            @endphp
                                            @if ($daysUntilExpiry < 0)
                                                <span
                                                    class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-200">
                                                    <iconify-icon icon="heroicons:exclamation-triangle-20-solid"
                                                        class="w-3 h-3 mr-1"></iconify-icon>
                                                    Expired
                                                </span>
                                            @elseif($daysUntilExpiry <= 30)
                                                <span
                                                    class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-orange-100 text-orange-800 dark:bg-orange-900 dark:text-orange-200">
                                                    <iconify-icon icon="heroicons:clock-20-solid"
                                                        class="w-3 h-3 mr-1"></iconify-icon>
                                                    {{ $daysUntilExpiry }} hari lagi
                                                </span>
                                            @else
                                                <span
                                                    class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200">
                                                    <iconify-icon icon="heroicons:check-circle-20-solid"
                                                        class="w-3 h-3 mr-1"></iconify-icon>
                                                    Valid
                                                </span>
                                            @endif
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- System Information -->
                    <div
                        class="bg-white dark:bg-gray-800 rounded-2xl shadow-sm border border-gray-200 dark:border-gray-700 p-6">
                        <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-6 flex items-center">
                            <iconify-icon icon="heroicons:cog-6-tooth-20-solid"
                                class="w-5 h-5 mr-2 text-indigo-600"></iconify-icon>
                            Informasi Sistem
                        </h3>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label class="block text-sm font-medium text-gray-500 dark:text-gray-400 mb-2">Tanggal
                                    Dibuat</label>
                                <div class="px-4 py-3 bg-gray-50 dark:bg-gray-700/50 rounded-xl">
                                    <span class="text-sm text-gray-900 dark:text-white">
                                        {{ $sopir->created_at->format('d F Y H:i') }}
                                    </span>
                                </div>
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-500 dark:text-gray-400 mb-2">Terakhir
                                    Diperbarui</label>
                                <div class="px-4 py-3 bg-gray-50 dark:bg-gray-700/50 rounded-xl">
                                    <span class="text-sm text-gray-900 dark:text-white">
                                        {{ $sopir->updated_at->format('d F Y H:i') }}
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Activity History (placeholder for future implementation) -->
                    <div
                        class="bg-white dark:bg-gray-800 rounded-2xl shadow-sm border border-gray-200 dark:border-gray-700 p-6">
                        <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-6 flex items-center">
                            <iconify-icon icon="heroicons:clock-20-solid"
                                class="w-5 h-5 mr-2 text-indigo-600"></iconify-icon>
                            Riwayat Aktivitas
                        </h3>

                        <div class="text-center py-8">
                            <iconify-icon icon="heroicons:document-text-20-solid"
                                class="w-12 h-12 text-gray-400 mx-auto mb-4"></iconify-icon>
                            <p class="text-sm text-gray-500 dark:text-gray-400">
                                Fitur riwayat aktivitas akan segera tersedia
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
