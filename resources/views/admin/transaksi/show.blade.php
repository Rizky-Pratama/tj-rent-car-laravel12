@extends('layouts.admin')

@section('title', 'Detail Transaksi')
@section('page-title', 'Detail Transaksi')
@section('page-subtitle', 'Informasi lengkap transaksi rental mobil')

@push('styles')
    <style>
        [x-cloak] {
            display: none !important;
        }
    </style>
@endpush
@section('content')
    <div class="max-w-7xl mx-auto">
        <!-- Back Button -->
        <div class="mb-4">
            <a href="{{ route('admin.transaksi.index') }}"
                class="inline-flex items-center text-sm text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-white">
                <iconify-icon icon="heroicons:arrow-left-20-solid" class="w-4 h-4 mr-2"></iconify-icon>
                Kembali ke Daftar Transaksi
            </a>
        </div>

        <!-- Header Card -->
        <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 p-4 mb-4">
            <div class="flex items-center justify-between">
                <div>
                    <h1 class="text-xl font-bold text-gray-900 dark:text-white">{{ $transaksi->no_transaksi }}</h1>
                    <p class="text-sm text-gray-600 dark:text-gray-400">
                        {{ $transaksi->created_at->timezone('Asia/Jakarta')->format('d M Y, H:i') }}
                    </p>
                </div>
                <div class="flex items-center space-x-2">
                    <!-- Status Badge -->
                    @if ($transaksi->status === 'pending')
                        <span
                            class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800 dark:bg-yellow-900/20 dark:text-yellow-300">
                            <iconify-icon icon="heroicons:clock-20-solid" class="w-3 h-3 mr-1"></iconify-icon>
                            Menunggu Pembayaran
                        </span>
                    @elseif ($transaksi->status === 'dibayar')
                        <span
                            class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-blue-100 text-blue-800 dark:bg-blue-900/20 dark:text-blue-300">
                            <iconify-icon icon="heroicons:credit-card-20-solid" class="w-3 h-3 mr-1"></iconify-icon>
                            Dibayar
                        </span>
                    @elseif ($transaksi->status === 'berjalan')
                        <span
                            class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-green-100 text-green-800 dark:bg-green-900/20 dark:text-green-300">
                            <iconify-icon icon="heroicons:truck-20-solid" class="w-3 h-3 mr-1"></iconify-icon>
                            Sedang Disewa
                        </span>
                    @elseif ($transaksi->status === 'telat')
                        <span
                            class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-red-100 text-red-800 dark:bg-red-900/20 dark:text-red-300">
                            <iconify-icon icon="heroicons:exclamation-triangle-20-solid"
                                class="w-3 h-3 mr-1"></iconify-icon>
                            Terlambat
                        </span>
                    @elseif ($transaksi->status === 'selesai')
                        <span
                            class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-gray-100 text-gray-800 dark:bg-gray-900/20 dark:text-gray-300">
                            <iconify-icon icon="heroicons:check-circle-20-solid" class="w-3 h-3 mr-1"></iconify-icon>
                            Selesai
                        </span>
                    @else
                        <span
                            class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-red-100 text-red-800 dark:bg-red-900/20 dark:text-red-300">
                            <iconify-icon icon="heroicons:x-circle-20-solid" class="w-3 h-3 mr-1"></iconify-icon>
                            Dibatalkan
                        </span>
                    @endif

                    <!-- Export PDF Button -->
                    <a href="{{ route('admin.transaksi.export-pdf', $transaksi->id) }}"
                        class="inline-flex items-center px-3 py-2 bg-green-600 hover:bg-green-700 text-white text-sm font-medium rounded-lg transition-colors duration-200"
                        target="_blank">
                        <iconify-icon icon="heroicons:document-arrow-down-20-solid" class="w-4 h-4 mr-1"></iconify-icon>
                        Cetak Invoice
                    </a>

                    @if ($transaksi->status == 'pending')
                        <a href="{{ route('admin.transaksi.edit', $transaksi->id) }}"
                            class="inline-flex items-center px-3 py-2 bg-indigo-600 hover:bg-indigo-700 text-white text-sm font-medium rounded-lg transition-colors duration-200">
                            <iconify-icon icon="heroicons:pencil-20-solid" class="w-4 h-4 mr-1"></iconify-icon>
                            Edit
                        </a>
                    @endif
                </div>
            </div>
        </div>

        <!-- Compact Grid Layout -->
        <div class="grid grid-cols-1 lg:grid-cols-4 gap-4">
            <!-- Main Content -->
            <div class="lg:col-span-3 space-y-4">
                <!-- Info Cards Row -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <!-- Data Pelanggan -->
                    <div
                        class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 p-4">
                        <div class="flex items-center mb-3">
                            <div
                                class="w-8 h-8 bg-blue-100 dark:bg-blue-900/30 rounded-lg flex items-center justify-center mr-3">
                                <iconify-icon icon="heroicons:user-20-solid"
                                    class="w-4 h-4 text-blue-600 dark:text-blue-400"></iconify-icon>
                            </div>
                            <h3 class="text-sm font-semibold text-gray-900 dark:text-white">Data Pelanggan</h3>
                        </div>
                        <div class="space-y-2 text-sm">
                            <div class="flex justify-between">
                                <span class="text-gray-600 dark:text-gray-400">Nama:</span>
                                <span
                                    class="font-medium text-gray-900 dark:text-white">{{ $transaksi->pelanggan->nama }}</span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-gray-600 dark:text-gray-400">Telepon:</span>
                                <span
                                    class="font-medium text-gray-900 dark:text-white">{{ $transaksi->pelanggan->telepon }}</span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-gray-600 dark:text-gray-400">Email:</span>
                                <span
                                    class="font-medium text-gray-900 dark:text-white">{{ $transaksi->pelanggan->email }}</span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-gray-600 dark:text-gray-400">KTP:</span>
                                <span
                                    class="font-medium text-gray-900 dark:text-white">{{ $transaksi->pelanggan->no_ktp }}</span>
                            </div>
                        </div>
                    </div>

                    <!-- Data Mobil -->
                    <div
                        class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 p-4">
                        <div class="flex items-center mb-3">
                            <div
                                class="w-8 h-8 bg-green-100 dark:bg-green-900/30 rounded-lg flex items-center justify-center mr-3">
                                <iconify-icon icon="heroicons:truck-20-solid"
                                    class="w-4 h-4 text-green-600 dark:text-green-400"></iconify-icon>
                            </div>
                            <h3 class="text-sm font-semibold text-gray-900 dark:text-white">Data Mobil</h3>
                        </div>
                        <div class="space-y-2 text-sm">
                            <div class="flex justify-between">
                                <span class="text-gray-600 dark:text-gray-400">Mobil:</span>
                                <span class="font-medium text-gray-900 dark:text-white">{{ $transaksi->mobil->merk }}
                                    {{ $transaksi->mobil->model }}</span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-gray-600 dark:text-gray-400">Plat:</span>
                                <span
                                    class="font-medium text-gray-900 dark:text-white">{{ $transaksi->mobil->plat_nomor }}</span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-gray-600 dark:text-gray-400">Tahun:</span>
                                <span
                                    class="font-medium text-gray-900 dark:text-white">{{ $transaksi->mobil->tahun }}</span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-gray-600 dark:text-gray-400">Warna:</span>
                                <span
                                    class="font-medium text-gray-900 dark:text-white">{{ $transaksi->mobil->warna }}</span>
                            </div>
                        </div>
                    </div>

                    <!-- Data Sopir (jika ada) -->
                    @if ($transaksi->sopir)
                        <div
                            class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 p-4">
                            <div class="flex items-center mb-3">
                                <div
                                    class="w-8 h-8 bg-purple-100 dark:bg-purple-900/30 rounded-lg flex items-center justify-center mr-3">
                                    <iconify-icon icon="heroicons:user-circle-20-solid"
                                        class="w-4 h-4 text-purple-600 dark:text-purple-400"></iconify-icon>
                                </div>
                                <h3 class="text-sm font-semibold text-gray-900 dark:text-white">Data Sopir</h3>
                            </div>
                            <div class="space-y-2 text-sm">
                                <div class="flex justify-between">
                                    <span class="text-gray-600 dark:text-gray-400">Nama:</span>
                                    <span
                                        class="font-medium text-gray-900 dark:text-white">{{ $transaksi->sopir->nama }}</span>
                                </div>
                                <div class="flex justify-between">
                                    <span class="text-gray-600 dark:text-gray-400">Telepon:</span>
                                    <span
                                        class="font-medium text-gray-900 dark:text-white">{{ $transaksi->sopir->telepon }}</span>
                                </div>
                                <div class="flex justify-between">
                                    <span class="text-gray-600 dark:text-gray-400">SIM:</span>
                                    <span
                                        class="font-medium text-gray-900 dark:text-white">{{ $transaksi->sopir->no_sim }}</span>
                                </div>
                                <div class="flex justify-between">
                                    <span class="text-gray-600 dark:text-gray-400">Pengalaman:</span>
                                    <span
                                        class="font-medium text-gray-900 dark:text-white">{{ $transaksi->sopir->pengalaman_tahun }}
                                        tahun</span>
                                </div>
                            </div>
                        </div>
                    @endif

                    <!-- Periode Sewa -->
                    <div
                        class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 p-4">
                        <div class="flex items-center mb-3">
                            <div
                                class="w-8 h-8 bg-orange-100 dark:bg-orange-900/30 rounded-lg flex items-center justify-center mr-3">
                                <iconify-icon icon="heroicons:calendar-days-20-solid"
                                    class="w-4 h-4 text-orange-600 dark:text-orange-400"></iconify-icon>
                            </div>
                            <h3 class="text-sm font-semibold text-gray-900 dark:text-white">Periode Sewa</h3>
                        </div>
                        <div class="space-y-2 text-sm">
                            <div class="flex justify-between">
                                <span class="text-gray-600 dark:text-gray-400">Mulai:</span>
                                <span
                                    class="font-medium text-gray-900 dark:text-white">{{ $transaksi->tanggal_sewa->format('d/m/Y') }}</span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-gray-600 dark:text-gray-400">Kembali:</span>
                                <span
                                    class="font-medium text-gray-900 dark:text-white">{{ $transaksi->tanggal_kembali->format('d/m/Y') }}</span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-gray-600 dark:text-gray-400">Durasi:</span>
                                <span class="font-medium text-gray-900 dark:text-white">{{ $transaksi->durasi_hari }}
                                    hari</span>
                            </div>
                            @if ($transaksi->tanggal_dikembalikan)
                                <div class="flex justify-between">
                                    <span class="text-gray-600 dark:text-gray-400">Dikembalikan:</span>
                                    <span
                                        class="font-medium text-gray-900 dark:text-white">{{ $transaksi->tanggal_dikembalikan->format('d/m/Y') }}</span>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>

                <!-- Catatan -->
                @if ($transaksi->catatan)
                    <div
                        class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 p-4">
                        <div class="flex items-center mb-3">
                            <div
                                class="w-8 h-8 bg-gray-100 dark:bg-gray-700 rounded-lg flex items-center justify-center mr-3">
                                <iconify-icon icon="heroicons:document-text-20-solid"
                                    class="w-4 h-4 text-gray-600 dark:text-gray-400"></iconify-icon>
                            </div>
                            <h3 class="text-sm font-semibold text-gray-900 dark:text-white">Catatan</h3>
                        </div>
                        <p class="text-sm text-gray-600 dark:text-gray-400 whitespace-pre-line">{{ $transaksi->catatan }}
                        </p>
                    </div>
                @endif

                <!-- Data Sopir Legacy (jika ada) -->
                @if (false)
                    <div class="bg-white shadow-lg rounded-lg p-6">
                        <h2 class="text-xl font-semibold text-gray-800 mb-4">Data Sopir</h2>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Nama</label>
                                <p class="mt-1 text-sm text-gray-900">{{ $transaksi->sopir->nama }}</p>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700">No. Telepon</label>
                                <p class="mt-1 text-sm text-gray-900">{{ $transaksi->sopir->telepon }}</p>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700">No. SIM</label>
                                <p class="mt-1 text-sm text-gray-900">{{ $transaksi->sopir->no_sim }}</p>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Pengalaman</label>
                                <p class="mt-1 text-sm text-gray-900">{{ $transaksi->sopir->pengalaman_tahun }} tahun</p>
                            </div>
                        </div>
                    </div>
                @endif

                <!-- Riwayat Pembayaran -->
                @if ($transaksi->pembayaran->count() > 0)
                    <div
                        class="bg-white dark:bg-gray-800 rounded-2xl shadow-sm border border-gray-100 dark:border-gray-700 p-6">
                        <div class="flex items-center justify-between mb-6">
                            <div class="flex items-center">
                                <div
                                    class="w-10 h-10 bg-gradient-to-r from-blue-500 to-purple-600 rounded-lg flex items-center justify-center mr-4">
                                    <iconify-icon icon="heroicons:credit-card-20-solid"
                                        class="w-5 h-5 text-white"></iconify-icon>
                                </div>
                                <div>
                                    <h2 class="text-lg font-semibold text-gray-900 dark:text-white">Riwayat Pembayaran</h2>
                                    <p class="text-sm text-gray-600 dark:text-gray-400">
                                        {{ $transaksi->pembayaran->count() }} pembayaran tercatat</p>
                                </div>
                            </div>
                            <a href="{{ route('admin.pembayaran.index', ['search' => $transaksi->no_transaksi]) }}"
                                class="inline-flex items-center px-3 py-1.5 text-sm bg-gray-100 dark:bg-gray-700 text-gray-700 dark:text-gray-300 rounded-lg hover:bg-gray-200 dark:hover:bg-gray-600 transition-colors duration-200">
                                <iconify-icon icon="heroicons:eye-20-solid" class="w-4 h-4 mr-1"></iconify-icon>
                                Lihat Semua
                            </a>
                        </div>
                        <div class="overflow-x-auto">
                            <table class="w-full divide-y divide-gray-200 dark:divide-gray-700">
                                <thead class="bg-gray-50 dark:bg-gray-700">
                                    <tr>
                                        <th
                                            class="px-4 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                            Tanggal</th>
                                        <th
                                            class="px-4 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                            Jumlah</th>
                                        <th
                                            class="px-4 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                            Metode</th>
                                        <th
                                            class="px-4 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                            Status</th>
                                        <th
                                            class="px-4 py-3 text-right text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                            Aksi</th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                                    @foreach ($transaksi->pembayaran as $bayar)
                                        <tr class="hover:bg-gray-50 dark:hover:bg-gray-700">
                                            <td class="px-4 py-3 text-sm text-gray-900 dark:text-white">
                                                {{ $bayar->created_at->timezone('Asia/Jakarta')->format('d M Y, H:i') }}
                                            </td>
                                            <td class="px-4 py-3 text-sm font-medium text-gray-900 dark:text-white">
                                                Rp {{ number_format($bayar->jumlah, 0, ',', '.') }}
                                            </td>
                                            <td class="px-4 py-3 text-sm text-gray-900 dark:text-white capitalize">
                                                {{ ucfirst($bayar->metode) }}
                                            </td>
                                            <td class="px-4 py-3 text-sm">
                                                @if ($bayar->status == 'terkonfirmasi')
                                                    <span
                                                        class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200">
                                                        <iconify-icon icon="heroicons:check-circle-20-solid"
                                                            class="w-3 h-3 mr-1"></iconify-icon>
                                                        Terkonfirmasi
                                                    </span>
                                                @elseif($bayar->status == 'pending')
                                                    <span
                                                        class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800 dark:bg-yellow-900 dark:text-yellow-200">
                                                        <iconify-icon icon="heroicons:clock-20-solid"
                                                            class="w-3 h-3 mr-1"></iconify-icon>
                                                        Pending
                                                    </span>
                                                @elseif($bayar->status == 'gagal')
                                                    <span
                                                        class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-200">
                                                        <iconify-icon icon="heroicons:x-circle-20-solid"
                                                            class="w-3 h-3 mr-1"></iconify-icon>
                                                        Gagal
                                                    </span>
                                                @else
                                                    <span
                                                        class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-purple-100 text-purple-800 dark:bg-purple-900 dark:text-purple-200">
                                                        <iconify-icon icon="heroicons:arrow-uturn-left-20-solid"
                                                            class="w-3 h-3 mr-1"></iconify-icon>
                                                        Refund
                                                    </span>
                                                @endif
                                            </td>
                                            <td class="px-4 py-3 text-sm font-medium text-right">
                                                <a href="{{ route('admin.pembayaran.show', $bayar->id) }}"
                                                    class="text-indigo-600 hover:text-indigo-900 dark:text-indigo-400 dark:hover:text-indigo-300"
                                                    title="Lihat Detail">
                                                    <iconify-icon icon="heroicons:eye-20-solid"
                                                        class="w-4 h-4"></iconify-icon>
                                                </a>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                @else
                    <div
                        class="bg-white dark:bg-gray-800 rounded-2xl shadow-sm border border-gray-100 dark:border-gray-700 p-6 text-center">
                        <div
                            class="w-16 h-16 bg-gray-100 dark:bg-gray-700 rounded-full flex items-center justify-center mx-auto mb-4">
                            <iconify-icon icon="heroicons:credit-card-20-solid"
                                class="w-8 h-8 text-gray-400"></iconify-icon>
                        </div>
                        <h3 class="text-lg font-medium text-gray-900 dark:text-white mb-2">Belum Ada Pembayaran</h3>
                        <p class="text-gray-600 dark:text-gray-400 mb-4">Transaksi ini belum memiliki riwayat pembayaran.
                        </p>
                        @if ($transaksi->sisa_pembayaran > 0)
                            <a href="{{ route('admin.pembayaran.create', ['transaksi_id' => $transaksi->id]) }}"
                                class="inline-flex items-center px-4 py-2 bg-indigo-600 hover:bg-indigo-700 text-white text-sm font-medium rounded-lg transition-colors duration-200">
                                <iconify-icon icon="heroicons:plus-20-solid" class="w-4 h-4 mr-2"></iconify-icon>
                                Tambah Pembayaran Pertama
                            </a>
                        @endif
                    </div>
                @endif
            </div>

            <!-- Sidebar -->
            <div class="space-y-4">
                <!-- Ringkasan Biaya -->
                <div
                    class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 p-4">
                    <h3 class="text-sm font-semibold text-gray-900 dark:text-white mb-3 flex items-center">
                        <iconify-icon icon="heroicons:currency-dollar-20-solid" class="w-4 h-4 mr-2"></iconify-icon>
                        Ringkasan Biaya
                    </h3>
                    <div class="space-y-2 text-xs">
                        <!-- Detail Biaya Sewa -->
                        <div class="pb-2 border-b border-gray-200 dark:border-gray-700">
                            <div class="flex justify-between mb-1">
                                <span class="text-gray-600 dark:text-gray-400">Jenis Sewa:</span>
                                <span
                                    class="font-medium text-gray-900 dark:text-white">{{ $transaksi->hargaSewa->jenisSewa->nama_jenis }}</span>
                            </div>
                            <div class="flex justify-between mb-1">
                                <span class="text-gray-600 dark:text-gray-400">Harga/Hari:</span>
                                <span class="font-medium text-gray-900 dark:text-white">Rp
                                    {{ number_format($transaksi->hargaSewa->harga_per_hari, 0, ',', '.') }}</span>
                            </div>
                            <div class="flex justify-between mb-1">
                                <span class="text-gray-600 dark:text-gray-400">Durasi:</span>
                                <span class="font-medium text-gray-900 dark:text-white">{{ $transaksi->durasi_hari }}
                                    hari</span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-gray-700 dark:text-gray-300 font-medium">Subtotal:</span>
                                <span class="font-semibold text-gray-900 dark:text-white">Rp
                                    {{ number_format($transaksi->subtotal, 0, ',', '.') }}</span>
                            </div>
                        </div>

                        <!-- Biaya Tambahan -->
                        @if ($transaksi->biaya_tambahan > 0)
                            <div class="flex justify-between">
                                <span class="text-gray-600 dark:text-gray-400">Biaya Tambahan:</span>
                                <span class="font-medium text-orange-600 dark:text-orange-400">+Rp
                                    {{ number_format($transaksi->biaya_tambahan, 0, ',', '.') }}</span>
                            </div>
                        @endif

                        <!-- Denda Otomatis -->
                        @if ($transaksi->denda > 0)
                            <div class="bg-red-50 dark:bg-red-900/10 rounded-lg p-2 mb-2">
                                <div class="flex justify-between mb-1">
                                    <span class="text-red-700 dark:text-red-400 font-medium text-xs">Denda
                                        Keterlambatan:</span>
                                    <span class="font-semibold text-red-700 dark:text-red-400">+Rp
                                        {{ number_format($transaksi->denda, 0, ',', '.') }}</span>
                                </div>
                                <div class="flex justify-between text-xs">
                                    <span class="text-red-600 dark:text-red-500">Terlambat:</span>
                                    <span class="text-red-600 dark:text-red-500 font-medium">{{ $transaksi->hari_telat }}
                                        hari</span>
                                </div>
                                <div class="flex justify-between text-xs">
                                    <span class="text-red-600 dark:text-red-500">Denda/Hari:</span>
                                    <span class="text-red-600 dark:text-red-500 font-medium">Rp
                                        {{ number_format($transaksi->denda_per_hari, 0, ',', '.') }}</span>
                                </div>
                            </div>
                        @endif

                        <!-- Denda Manual -->
                        @if ($transaksi->denda_manual > 0)
                            <div class="flex justify-between">
                                <span class="text-gray-600 dark:text-gray-400">Denda Manual:</span>
                                <span class="font-medium text-red-600 dark:text-red-400">+Rp
                                    {{ number_format($transaksi->denda_manual, 0, ',', '.') }}</span>
                            </div>
                        @endif

                        <!-- Total & Status Pembayaran -->
                        <hr class="border-gray-200 dark:border-gray-700">
                        <div class="flex justify-between pt-1">
                            <span class="text-gray-700 dark:text-gray-300 font-semibold">Total Tagihan:</span>
                            <span class="font-bold text-gray-900 dark:text-white text-sm">Rp
                                {{ number_format($transaksi->total, 0, ',', '.') }}</span>
                        </div>
                        <div class="flex justify-between text-green-600 dark:text-green-400">
                            <span>Terbayar:</span>
                            <span class="font-medium">Rp
                                {{ number_format($transaksi->total_pembayaran, 0, ',', '.') }}</span>
                        </div>
                        <hr class="border-gray-200 dark:border-gray-700">
                        <div
                            class="flex justify-between {{ $transaksi->sisa_pembayaran > 0 ? 'text-red-600 dark:text-red-400' : 'text-green-600 dark:text-green-400' }} font-semibold pt-1">
                            <span>{{ $transaksi->sisa_pembayaran > 0 ? 'Sisa:' : 'Status:' }}</span>
                            <span
                                class="text-sm">{{ $transaksi->sisa_pembayaran > 0 ? 'Rp ' . number_format($transaksi->sisa_pembayaran, 0, ',', '.') : 'LUNAS' }}</span>
                        </div>

                        <!-- Status Pembayaran Badge -->
                        <div class="pt-2">
                            @if ($transaksi->status_pembayaran === 'lunas')
                                <span
                                    class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-green-100 text-green-800 dark:bg-green-900/20 dark:text-green-300 w-full justify-center">
                                    <iconify-icon icon="heroicons:check-circle-20-solid"
                                        class="w-3 h-3 mr-1"></iconify-icon>
                                    Lunas
                                </span>
                            @elseif ($transaksi->status_pembayaran === 'sebagian')
                                <span
                                    class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800 dark:bg-yellow-900/20 dark:text-yellow-300 w-full justify-center">
                                    <iconify-icon icon="heroicons:clock-20-solid" class="w-3 h-3 mr-1"></iconify-icon>
                                    Sebagian
                                </span>
                            @elseif ($transaksi->status_pembayaran === 'refund')
                                <span
                                    class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-purple-100 text-purple-800 dark:bg-purple-900/20 dark:text-purple-300 w-full justify-center">
                                    <iconify-icon icon="heroicons:arrow-uturn-left-20-solid"
                                        class="w-3 h-3 mr-1"></iconify-icon>
                                    Refund
                                </span>
                            @else
                                <span
                                    class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-red-100 text-red-800 dark:bg-red-900/20 dark:text-red-300 w-full justify-center">
                                    <iconify-icon icon="heroicons:exclamation-circle-20-solid"
                                        class="w-3 h-3 mr-1"></iconify-icon>
                                    Belum Bayar
                                </span>
                            @endif
                        </div>
                    </div>
                </div>

                <!-- Aksi Cepat -->
                <div
                    class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 p-4">
                    <h3 class="text-sm font-semibold text-gray-900 dark:text-white mb-3 flex items-center">
                        <iconify-icon icon="heroicons:bolt-20-solid" class="w-4 h-4 mr-2"></iconify-icon>
                        Aksi Cepat
                    </h3>
                    <div class="space-y-2">
                        @if (!in_array($transaksi->status, ['selesai', 'batal']))
                            <a href="{{ route('admin.transaksi.payment', $transaksi->id) }}"
                                class="w-full bg-indigo-600 hover:bg-indigo-700 text-white py-2 px-4 rounded-lg inline-flex items-center justify-center">
                                <iconify-icon icon="heroicons:plus-20-solid" class="w-4 h-4 mr-2"></iconify-icon>
                                Tambah Pembayaran
                            </a>
                        @endif
                        @if ($transaksi->status == 'pending')
                            <form action="{{ route('admin.transaksi.update-status', $transaksi->id) }}" method="POST">
                                @csrf
                                @method('PATCH')
                                <input type="hidden" name="status" value="dibayar">
                                <button type="submit"
                                    class="w-full bg-green-500 hover:bg-green-600 text-white py-2 px-4 rounded-lg"
                                    onclick="return confirm('Konfirmasi bahwa pembayaran telah diterima?')">
                                    Konfirmasi Pembayaran
                                </button>
                            </form>

                            <form action="{{ route('admin.transaksi.update-status', $transaksi->id) }}" method="POST">
                                @csrf
                                @method('PATCH')
                                <input type="hidden" name="status" value="dibatalkan">
                                <button type="submit"
                                    class="w-full bg-red-500 hover:bg-red-600 text-white py-2 px-4 rounded-lg"
                                    onclick="return confirm('Yakin ingin membatalkan transaksi ini?')">
                                    Batalkan Transaksi
                                </button>
                            </form>
                        @elseif($transaksi->status == 'dibayar')
                            <form action="{{ route('admin.transaksi.update-status', $transaksi->id) }}" method="POST">
                                @csrf
                                @method('PATCH')
                                <input type="hidden" name="status" value="berjalan">
                                <button type="submit"
                                    class="w-full bg-blue-500 hover:bg-blue-600 text-white py-2 px-4 rounded-lg"
                                    onclick="return confirm('Mulai periode sewa?')">
                                    Mulai Periode Sewa
                                </button>
                            </form>
                        @elseif(in_array($transaksi->status, ['berjalan', 'telat']))
                            <form action="{{ route('admin.transaksi.update-status', $transaksi->id) }}" method="POST">
                                @csrf
                                @method('PATCH')
                                <input type="hidden" name="status" value="selesai">
                                <button type="submit"
                                    class="w-full bg-gray-500 hover:bg-gray-600 text-white py-2 px-4 rounded-lg"
                                    onclick="return confirm('Konfirmasi mobil telah dikembalikan?')">
                                    Selesai Sewa
                                </button>
                            </form>
                        @endif

                        @if (in_array($transaksi->status, ['berjalan', 'telat']))
                            <button @click="$dispatch('open-cost-modal')"
                                class="w-full bg-orange-500 hover:bg-orange-600 text-white py-2 px-3 rounded-lg text-sm">
                                💰 Tambah Biaya
                            </button>
                            <button @click="$dispatch('open-fine-modal')"
                                class="w-full bg-red-500 hover:bg-red-600 text-white py-2 px-3 rounded-lg text-sm">
                                ⚠️ Tambah Denda
                            </button>
                        @endif

                        <a href="{{ route('admin.pembayaran.create', ['transaksi_id' => $transaksi->id]) }}"
                            class="w-full bg-indigo-600 hover:bg-indigo-700 text-white py-2 px-3 rounded-lg text-sm inline-flex items-center justify-center">
                            💳 Kelola Pembayaran
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <!-- Modal Tambah Biaya -->
        <div x-data="{ open: false }" @open-cost-modal.window="open = true" x-show="open" x-cloak
            class="fixed inset-0 bg-gray-600/50 overflow-y-auto h-full w-full z-50"
            x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0"
            x-transition:enter-end="opacity-100" x-transition:leave="transition ease-in duration-200"
            x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0">
            <div class="relative top-20 mx-auto p-5 w-96 shadow-lg rounded-md bg-white dark:bg-gray-800"
                @click.away="open = false" x-transition:enter="transition ease-out duration-300"
                x-transition:enter-start="opacity-0 transform scale-90"
                x-transition:enter-end="opacity-100 transform scale-100"
                x-transition:leave="transition ease-in duration-200"
                x-transition:leave-start="opacity-100 transform scale-100"
                x-transition:leave-end="opacity-0 transform scale-90">
                <div class="mt-3">
                    <h3 class="text-lg font-medium text-gray-900 dark:text-white mb-4">Tambah Biaya Tambahan</h3>
                    <form action="{{ route('admin.transaksi.add-biaya', $transaksi->id) }}" method="POST">
                        @csrf
                        <div class="mb-4">
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Jumlah
                                Biaya</label>
                            <input type="number" name="biaya_tambahan" required
                                class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md focus:outline-none focus:ring-1 focus:ring-blue-500 bg-white dark:bg-gray-700 text-gray-900 dark:text-white">
                        </div>
                        <div class="mb-4">
                            <label
                                class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Keterangan</label>
                            <textarea name="keterangan_biaya" required rows="3"
                                class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md focus:outline-none focus:ring-1 focus:ring-blue-500 bg-white dark:bg-gray-700 text-gray-900 dark:text-white"></textarea>
                        </div>
                        <div class="flex justify-end space-x-3">
                            <button type="button" @click="open = false"
                                class="px-4 py-2 bg-gray-300 dark:bg-gray-600 text-gray-700 dark:text-gray-200 rounded-md hover:bg-gray-400 dark:hover:bg-gray-500">
                                Batal
                            </button>
                            <button type="submit"
                                class="px-4 py-2 bg-orange-500 text-white rounded-md hover:bg-orange-600">
                                Tambah
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- Modal Tambah Denda -->
        <div x-data="{ open: false }" @open-fine-modal.window="open = true" x-show="open" x-cloak
            class="fixed inset-0 bg-gray-600/50 overflow-y-auto h-full w-full z-50"
            x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0"
            x-transition:enter-end="opacity-100" x-transition:leave="transition ease-in duration-200"
            x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0">
            <div class="relative top-20 mx-auto p-5 w-96 shadow-lg rounded-md bg-white dark:bg-gray-800"
                @click.away="open = false" x-transition:enter="transition ease-out duration-300"
                x-transition:enter-start="opacity-0 transform scale-90"
                x-transition:enter-end="opacity-100 transform scale-100"
                x-transition:leave="transition ease-in duration-200"
                x-transition:leave-start="opacity-100 transform scale-100"
                x-transition:leave-end="opacity-0 transform scale-90">
                <div class="mt-3">
                    <h3 class="text-lg font-medium text-gray-900 dark:text-white mb-4">Tambah Denda Manual</h3>
                    <form action="{{ route('admin.transaksi.add-denda', $transaksi->id) }}" method="POST">
                        @csrf
                        <div class="mb-4">
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Jumlah
                                Denda</label>
                            <input type="number" name="denda_manual" required
                                class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md focus:outline-none focus:ring-1 focus:ring-blue-500 bg-white dark:bg-gray-700 text-gray-900 dark:text-white">
                        </div>
                        <div class="mb-4">
                            <label
                                class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Keterangan</label>
                            <textarea name="keterangan_denda" required rows="3"
                                class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md focus:outline-none focus:ring-1 focus:ring-blue-500 bg-white dark:bg-gray-700 text-gray-900 dark:text-white"></textarea>
                        </div>
                        <div class="flex justify-end space-x-3">
                            <button type="button" @click="open = false"
                                class="px-4 py-2 bg-gray-300 dark:bg-gray-600 text-gray-700 dark:text-gray-200 rounded-md hover:bg-gray-400 dark:hover:bg-gray-500">
                                Batal
                            </button>
                            <button type="submit" class="px-4 py-2 bg-red-500 text-white rounded-md hover:bg-red-600">
                                Tambah
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    @endsection
