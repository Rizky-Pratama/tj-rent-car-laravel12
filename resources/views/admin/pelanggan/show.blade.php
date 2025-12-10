@extends('layouts.admin')

@section('title', 'Detail Pelanggan')

@section('content')
    <div class="max-w-6xl mx-auto">
        <!-- Header -->
        <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-sm border border-gray-200 dark:border-gray-700 p-6 mb-6">
            <div class="flex items-center justify-between">
                <div>
                    <h1 class="text-2xl font-bold text-gray-900 dark:text-white">Detail Pelanggan</h1>
                    <p class="text-sm text-gray-600 dark:text-gray-400">Informasi lengkap pelanggan {{ $pelanggan->nama }}
                    </p>
                </div>
                <div class="flex items-center space-x-3">
                    <a href="{{ route('admin.pelanggan.edit', $pelanggan) }}"
                        class="inline-flex items-center px-4 py-2 bg-indigo-600 hover:bg-indigo-700 text-white text-sm font-medium rounded-xl transition-colors duration-200">
                        <iconify-icon icon="heroicons:pencil-20-solid" class="w-4 h-4 mr-2"></iconify-icon>
                        Edit
                    </a>
                    <a href="{{ route('admin.pelanggan.index') }}"
                        class="inline-flex items-center px-4 py-2 bg-gray-500 hover:bg-gray-600 text-white text-sm font-medium rounded-xl transition-colors duration-200">
                        <iconify-icon icon="heroicons:arrow-left-20-solid" class="w-4 h-4 mr-2"></iconify-icon>
                        Kembali
                    </a>
                </div>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            <!-- Left Column - Profile & Quick Info -->
            <div class="lg:col-span-1">
                <!-- Profile Card -->
                <div
                    class="bg-white dark:bg-gray-800 rounded-2xl shadow-sm border border-gray-200 dark:border-gray-700 p-6 mb-6">
                    <div class="text-center">
                        <div
                            class="w-32 h-32 mx-auto mb-4 rounded-full overflow-hidden bg-gray-100 dark:bg-gray-700 border-4 border-white dark:border-gray-800 shadow-lg">
                            <div
                                class="w-full h-full flex items-center justify-center bg-gradient-to-br from-indigo-500 to-purple-600">
                                <span class="text-3xl font-bold text-white">
                                    {{ strtoupper(substr($pelanggan->nama, 0, 2)) }}
                                </span>
                            </div>
                        </div>
                        <h3 class="text-lg font-semibold text-gray-900 dark:text-white">{{ $pelanggan->nama }}</h3>
                        <p class="text-sm text-gray-500 dark:text-gray-400">{{ $pelanggan->email }}</p>
                        <div class="mt-2">
                            @if ($pelanggan->jenis_kelamin === 'laki-laki')
                                <span
                                    class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-blue-100 text-blue-800 dark:bg-blue-900 dark:text-blue-200">
                                    <iconify-icon icon="heroicons:user-20-solid" class="w-4 h-4 mr-1"></iconify-icon>
                                    Laki-laki
                                </span>
                            @else
                                <span
                                    class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-pink-100 text-pink-800 dark:bg-pink-900 dark:text-pink-200">
                                    <iconify-icon icon="heroicons:user-20-solid" class="w-4 h-4 mr-1"></iconify-icon>
                                    Perempuan
                                </span>
                            @endif
                        </div>
                        <div class="mt-2">
                            <p class="text-xs text-gray-500">
                                Bergabung {{ $pelanggan->created_at->diffForHumans() }}
                            </p>
                        </div>
                    </div>
                </div>

                <!-- Quick Stats -->
                <div
                    class="bg-white dark:bg-gray-800 rounded-2xl shadow-sm border border-gray-200 dark:border-gray-700 p-6 mb-6">
                    <h4 class="text-sm font-semibold text-gray-900 dark:text-white mb-4">Statistik Rental</h4>
                    <div class="space-y-4">
                        <div class="flex items-center justify-between">
                            <span class="text-sm text-gray-600 dark:text-gray-400">Total Transaksi</span>
                            <span
                                class="text-lg font-bold text-gray-900 dark:text-white">{{ $pelanggan->transaksi->count() }}</span>
                        </div>
                        <div class="flex items-center justify-between">
                            <span class="text-sm text-gray-600 dark:text-gray-400">Sedang Berlangsung</span>
                            <span class="text-lg font-bold text-orange-600">
                                {{ $pelanggan->transaksi->where('status', 'berlangsung')->count() }}
                            </span>
                        </div>
                        <div class="flex items-center justify-between">
                            <span class="text-sm text-gray-600 dark:text-gray-400">Selesai</span>
                            <span class="text-lg font-bold text-green-600">
                                {{ $pelanggan->transaksi->where('status', 'selesai')->count() }}
                            </span>
                        </div>
                    </div>
                </div>

                <!-- Quick Actions Card -->
                <div
                    class="bg-white dark:bg-gray-800 rounded-2xl shadow-sm border border-gray-200 dark:border-gray-700 p-6">
                    <h4 class="text-sm font-semibold text-gray-900 dark:text-white mb-4">Aksi Cepat</h4>
                    <div class="space-y-3">
                        <a href="mailto:{{ $pelanggan->email }}"
                            class="flex items-center w-full px-4 py-3 text-left bg-blue-50 dark:bg-blue-900/20 hover:bg-blue-100 dark:hover:bg-blue-900/30 rounded-xl transition-colors duration-200">
                            <iconify-icon icon="heroicons:envelope-20-solid"
                                class="w-5 h-5 text-blue-600 dark:text-blue-400 mr-3"></iconify-icon>
                            <span class="text-sm font-medium text-blue-700 dark:text-blue-300">Kirim Email</span>
                        </a>

                        <a href="tel:{{ $pelanggan->telepon }}"
                            class="flex items-center w-full px-4 py-3 text-left bg-green-50 dark:bg-green-900/20 hover:bg-green-100 dark:hover:bg-green-900/30 rounded-xl transition-colors duration-200">
                            <iconify-icon icon="heroicons:phone-20-solid"
                                class="w-5 h-5 text-green-600 dark:text-green-400 mr-3"></iconify-icon>
                            <span class="text-sm font-medium text-green-700 dark:text-green-300">Hubungi</span>
                        </a>

                        <button type="button"
                            class="flex items-center w-full px-4 py-3 text-left bg-indigo-50 dark:bg-indigo-900/20 hover:bg-indigo-100 dark:hover:bg-indigo-900/30 rounded-xl transition-colors duration-200">
                            <iconify-icon icon="heroicons:plus-circle-20-solid"
                                class="w-5 h-5 text-indigo-600 dark:text-indigo-400 mr-3"></iconify-icon>
                            <span class="text-sm font-medium text-indigo-700 dark:text-indigo-300">Buat Transaksi
                                Baru</span>
                        </button>

                        <form method="POST" action="{{ route('admin.pelanggan.destroy', $pelanggan) }}"
                            onsubmit="return confirm('Apakah Anda yakin ingin menghapus pelanggan ini?')" class="w-full">
                            @csrf
                            @method('DELETE')
                            <button type="submit"
                                class="flex items-center w-full px-4 py-3 text-left bg-red-50 dark:bg-red-900/20 hover:bg-red-100 dark:hover:bg-red-900/30 rounded-xl transition-colors duration-200">
                                <iconify-icon icon="heroicons:trash-20-solid"
                                    class="w-5 h-5 text-red-600 dark:text-red-400 mr-3"></iconify-icon>
                                <span class="text-sm font-medium text-red-700 dark:text-red-300">Hapus Pelanggan</span>
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
                                        class="text-sm font-medium text-gray-900 dark:text-white">{{ $pelanggan->nama }}</span>
                                </div>
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-500 dark:text-gray-400 mb-2">Email</label>
                                <div class="px-4 py-3 bg-gray-50 dark:bg-gray-700/50 rounded-xl">
                                    <a href="mailto:{{ $pelanggan->email }}"
                                        class="text-sm font-medium text-indigo-600 dark:text-indigo-400 hover:underline">
                                        {{ $pelanggan->email }}
                                    </a>
                                </div>
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-500 dark:text-gray-400 mb-2">Nomor
                                    Telepon</label>
                                <div class="px-4 py-3 bg-gray-50 dark:bg-gray-700/50 rounded-xl">
                                    <a href="tel:{{ $pelanggan->telepon }}"
                                        class="text-sm font-medium text-indigo-600 dark:text-indigo-400 hover:underline">
                                        {{ $pelanggan->telepon }}
                                    </a>
                                </div>
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-500 dark:text-gray-400 mb-2">Tanggal
                                    Lahir</label>
                                <div class="px-4 py-3 bg-gray-50 dark:bg-gray-700/50 rounded-xl">
                                    <span class="text-sm text-gray-900 dark:text-white">
                                        {{ $pelanggan->tanggal_lahir?->format('d F Y') ?? 'Tidak tersedia' }}
                                        @if ($pelanggan->tanggal_lahir)
                                            ({{ $pelanggan->tanggal_lahir->age }} tahun)
                                        @endif
                                    </span>
                                </div>
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-500 dark:text-gray-400 mb-2">Jenis
                                    Kelamin</label>
                                <div class="px-4 py-3 bg-gray-50 dark:bg-gray-700/50 rounded-xl">
                                    <span class="text-sm text-gray-900 dark:text-white">
                                        {{ $pelanggan->jenis_kelamin === 'laki-laki' ? 'Laki-laki' : 'Perempuan' }}
                                    </span>
                                </div>
                            </div>
                        </div>

                        <div class="mt-6">
                            <label class="block text-sm font-medium text-gray-500 dark:text-gray-400 mb-2">Alamat</label>
                            <div class="px-4 py-3 bg-gray-50 dark:bg-gray-700/50 rounded-xl">
                                <span
                                    class="text-sm text-gray-900 dark:text-white whitespace-pre-line">{{ $pelanggan->alamat }}</span>
                            </div>
                        </div>
                    </div>

                    <!-- Identity Information -->
                    <div
                        class="bg-white dark:bg-gray-800 rounded-2xl shadow-sm border border-gray-200 dark:border-gray-700 p-6">
                        <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-6 flex items-center">
                            <iconify-icon icon="heroicons:identification-20-solid"
                                class="w-5 h-5 mr-2 text-indigo-600"></iconify-icon>
                            Informasi Identitas
                        </h3>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label class="block text-sm font-medium text-gray-500 dark:text-gray-400 mb-2">Nomor
                                    KTP</label>
                                <div class="px-4 py-3 bg-gray-50 dark:bg-gray-700/50 rounded-xl font-mono">
                                    <span
                                        class="text-sm font-medium text-gray-900 dark:text-white">{{ $pelanggan->no_ktp }}</span>
                                </div>
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-500 dark:text-gray-400 mb-2">Nomor
                                    SIM</label>
                                <div class="px-4 py-3 bg-gray-50 dark:bg-gray-700/50 rounded-xl font-mono">
                                    <span
                                        class="text-sm font-medium text-gray-900 dark:text-white">{{ $pelanggan->no_sim }}</span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Transaction History -->
                    <div
                        class="bg-white dark:bg-gray-800 rounded-2xl shadow-sm border border-gray-200 dark:border-gray-700 p-6">
                        <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-6 flex items-center">
                            <iconify-icon icon="heroicons:clock-20-solid"
                                class="w-5 h-5 mr-2 text-indigo-600"></iconify-icon>
                            Riwayat Transaksi
                        </h3>

                        @if ($pelanggan->transaksi->count() > 0)
                            <div class="space-y-4">
                                @foreach ($pelanggan->transaksi->take(5) as $transaksi)
                                    <div class="border border-gray-200 dark:border-gray-600 rounded-xl p-4">
                                        <div class="flex items-start justify-between">
                                            <div class="flex items-center space-x-3">
                                                <div
                                                    class="w-12 h-12 bg-gray-100 dark:bg-gray-700 rounded-xl flex items-center justify-center">
                                                    <iconify-icon icon="heroicons:truck-20-solid"
                                                        class="w-6 h-6 text-gray-600 dark:text-gray-400"></iconify-icon>
                                                </div>
                                                <div>
                                                    <h4 class="text-sm font-semibold text-gray-900 dark:text-white">
                                                        {{ $transaksi->mobil->merk ?? 'Mobil' }}
                                                        {{ $transaksi->mobil->model ?? '' }}
                                                    </h4>
                                                    <p class="text-xs text-gray-500 dark:text-gray-400">
                                                        {{ $transaksi->tanggal_sewa?->format('d M Y') }} -
                                                        {{ $transaksi->tanggal_kembali?->format('d M Y') }}
                                                    </p>
                                                </div>
                                            </div>
                                            <div class="text-right">
                                                @if ($transaksi->status === 'berlangsung')
                                                    <span
                                                        class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-orange-100 text-orange-800 dark:bg-orange-900 dark:text-orange-200">
                                                        Berlangsung
                                                    </span>
                                                @elseif($transaksi->status === 'selesai')
                                                    <span
                                                        class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200">
                                                        Selesai
                                                    </span>
                                                @else
                                                    <span
                                                        class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-gray-100 text-gray-800 dark:bg-gray-700 dark:text-gray-200">
                                                        {{ ucfirst($transaksi->status) }}
                                                    </span>
                                                @endif
                                                <p class="text-sm font-semibold text-gray-900 dark:text-white mt-1">
                                                    Rp {{ number_format($transaksi->total, 0, ',', '.') }}
                                                </p>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach

                                @if ($pelanggan->transaksi->count() > 5)
                                    <div class="text-center pt-4">
                                        <button type="button"
                                            class="text-sm text-indigo-600 dark:text-indigo-400 hover:underline">
                                            Lihat Semua Transaksi ({{ $pelanggan->transaksi->count() }})
                                        </button>
                                    </div>
                                @endif
                            </div>
                        @else
                            <div class="text-center py-8">
                                <iconify-icon icon="heroicons:document-text-20-solid"
                                    class="w-12 h-12 text-gray-400 mx-auto mb-4"></iconify-icon>
                                <p class="text-sm text-gray-500 dark:text-gray-400">
                                    Pelanggan ini belum memiliki riwayat transaksi
                                </p>
                                <button type="button"
                                    class="mt-4 inline-flex items-center px-4 py-2 bg-indigo-600 hover:bg-indigo-700 text-white text-sm font-medium rounded-xl transition-colors duration-200">
                                    <iconify-icon icon="heroicons:plus-20-solid" class="w-4 h-4 mr-2"></iconify-icon>
                                    Buat Transaksi Pertama
                                </button>
                            </div>
                        @endif
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
                                    Bergabung</label>
                                <div class="px-4 py-3 bg-gray-50 dark:bg-gray-700/50 rounded-xl">
                                    <span class="text-sm text-gray-900 dark:text-white">
                                        {{ $pelanggan->created_at->format('d F Y H:i') }}
                                    </span>
                                </div>
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-500 dark:text-gray-400 mb-2">Terakhir
                                    Diperbarui</label>
                                <div class="px-4 py-3 bg-gray-50 dark:bg-gray-700/50 rounded-xl">
                                    <span class="text-sm text-gray-900 dark:text-white">
                                        {{ $pelanggan->updated_at->format('d F Y H:i') }}
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
