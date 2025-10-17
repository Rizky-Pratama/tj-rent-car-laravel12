@extends('layouts.admin')

@section('title', 'Detail Pembayaran')
@section('page-title', 'Detail Pembayaran')
@section('page-subtitle', 'Detail informasi pembayaran transaksi')

@section('content')
    <div class="max-w-4xl mx-auto space-y-6">

        <!-- Header Actions -->
        <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
            <div class="flex items-center space-x-3">
                <a href="{{ route('admin.pembayaran.index') }}"
                    class="inline-flex items-center px-3 py-2 border border-gray-300 dark:border-gray-600 text-gray-700 dark:text-gray-300 bg-white dark:bg-gray-800 rounded-xl hover:bg-gray-50 dark:hover:bg-gray-700 font-medium transition-colors duration-200">
                    <iconify-icon icon="heroicons:arrow-left-20-solid" class="w-4 h-4 mr-2"></iconify-icon>
                    Kembali
                </a>
            </div>

            <div class="flex items-center space-x-3">
                @if ($pembayaran->status === 'pending')
                    <a href="{{ route('admin.pembayaran.edit', $pembayaran->id) }}"
                        class="inline-flex items-center px-4 py-2 bg-indigo-600 hover:bg-indigo-700 text-white font-medium rounded-xl transition-colors duration-200">
                        <iconify-icon icon="heroicons:pencil-20-solid" class="w-4 h-4 mr-2"></iconify-icon>
                        Edit
                    </a>
                @endif

                <!-- Status Actions -->
                @if ($pembayaran->status === 'pending')
                    <form action="{{ route('admin.pembayaran.updateStatus', $pembayaran->id) }}" method="POST"
                        class="inline">
                        @csrf
                        @method('PATCH')
                        <input type="hidden" name="status" value="terkonfirmasi">
                        <button type="submit" onclick="return confirm('Konfirmasi pembayaran ini?')"
                            class="inline-flex items-center px-4 py-2 bg-green-600 hover:bg-green-700 text-white font-medium rounded-xl transition-colors duration-200">
                            <iconify-icon icon="heroicons:check-circle-20-solid" class="w-4 h-4 mr-2"></iconify-icon>
                            Konfirmasi
                        </button>
                    </form>
                @endif
            </div>
        </div>

        <!-- Status Badge -->
        <div class="flex items-center justify-center">
            @if ($pembayaran->status === 'pending')
                <span
                    class="inline-flex items-center px-4 py-2 rounded-full text-sm font-medium bg-yellow-100 text-yellow-800 dark:bg-yellow-900 dark:text-yellow-200">
                    <iconify-icon icon="heroicons:clock-20-solid" class="w-5 h-5 mr-2"></iconify-icon>
                    Pembayaran Pending
                </span>
            @elseif ($pembayaran->status === 'terkonfirmasi')
                <span
                    class="inline-flex items-center px-4 py-2 rounded-full text-sm font-medium bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200">
                    <iconify-icon icon="heroicons:check-circle-20-solid" class="w-5 h-5 mr-2"></iconify-icon>
                    Pembayaran Terkonfirmasi
                </span>
            @elseif ($pembayaran->status === 'gagal')
                <span
                    class="inline-flex items-center px-4 py-2 rounded-full text-sm font-medium bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-200">
                    <iconify-icon icon="heroicons:x-circle-20-solid" class="w-5 h-5 mr-2"></iconify-icon>
                    Pembayaran Gagal
                </span>
            @else
                <span
                    class="inline-flex items-center px-4 py-2 rounded-full text-sm font-medium bg-purple-100 text-purple-800 dark:bg-purple-900 dark:text-purple-200">
                    <iconify-icon icon="heroicons:arrow-uturn-left-20-solid" class="w-5 h-5 mr-2"></iconify-icon>
                    Refund
                </span>
            @endif
        </div>

        <!-- Main Info Card -->
        <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-sm border border-gray-100 dark:border-gray-700 p-6">
            <div class="flex items-center mb-6">
                <div class="flex-shrink-0">
                    <div
                        class="w-12 h-12 bg-gradient-to-r from-blue-500 to-purple-600 rounded-xl flex items-center justify-center">
                        <iconify-icon icon="heroicons:credit-card-20-solid" class="w-6 h-6 text-white"></iconify-icon>
                    </div>
                </div>
                <div class="ml-4">
                    <h3 class="text-xl font-semibold text-gray-900 dark:text-white">Detail Pembayaran</h3>
                    <p class="text-sm text-gray-600 dark:text-gray-400">ID Pembayaran: #{{ $pembayaran->id }}</p>
                </div>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                <!-- Informasi Pembayaran -->
                <div class="space-y-4">
                    <h4
                        class="font-semibold text-gray-900 dark:text-white border-b border-gray-200 dark:border-gray-600 pb-2">
                        Informasi Pembayaran
                    </h4>

                    <div class="space-y-3">
                        <div class="flex justify-between">
                            <span class="text-gray-600 dark:text-gray-400">Jumlah:</span>
                            <span class="font-bold text-xl text-indigo-600 dark:text-indigo-400">
                                Rp {{ number_format($pembayaran->jumlah, 0, ',', '.') }}
                            </span>
                        </div>

                        <div class="flex justify-between">
                            <span class="text-gray-600 dark:text-gray-400">Metode:</span>
                            <span class="font-medium text-gray-900 dark:text-white capitalize">
                                {{ ucfirst($pembayaran->metode) }}
                            </span>
                        </div>

                        <div class="flex justify-between">
                            <span class="text-gray-600 dark:text-gray-400">Tanggal Pembayaran:</span>
                            <span class="font-medium text-gray-900 dark:text-white">
                                {{ $pembayaran->tanggal_bayar ? $pembayaran->tanggal_bayar->format('d M Y, H:i') : '-' }}
                            </span>
                        </div>

                        <div class="flex justify-between">
                            <span class="text-gray-600 dark:text-gray-400">Dicatat Pada:</span>
                            <span class="font-medium text-gray-900 dark:text-white">
                                {{ $pembayaran->created_at->format('d M Y, H:i') }}
                            </span>
                        </div>

                        <div class="flex justify-between">
                            <span class="text-gray-600 dark:text-gray-400">Dicatat Oleh:</span>
                            <span class="font-medium text-gray-900 dark:text-white">
                                {{ $pembayaran->dibuatOleh->name ?? '-' }}
                            </span>
                        </div>
                    </div>
                </div>

                <!-- Bukti Pembayaran -->
                <div class="space-y-4">
                    <h4
                        class="font-semibold text-gray-900 dark:text-white border-b border-gray-200 dark:border-gray-600 pb-2">
                        Bukti Pembayaran
                    </h4>

                    @if ($pembayaran->bukti_bayar)
                        <div class="text-center">
                            <img src="{{ asset('storage/' . $pembayaran->bukti_bayar) }}" alt="Bukti Pembayaran"
                                class="max-w-full h-auto rounded-xl shadow-md cursor-pointer hover:shadow-lg transition-shadow duration-200"
                                onclick="openImageModal(this.src)">
                            <p class="text-xs text-gray-500 dark:text-gray-400 mt-2">
                                Klik gambar untuk memperbesar
                            </p>
                        </div>
                    @else
                        <div class="text-center py-8">
                            <iconify-icon icon="heroicons:photo-20-solid"
                                class="w-12 h-12 text-gray-400 mx-auto mb-2"></iconify-icon>
                            <p class="text-gray-500 dark:text-gray-400">Tidak ada bukti pembayaran</p>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Catatan -->
            @if ($pembayaran->catatan)
                <div class="mt-6 pt-6 border-t border-gray-200 dark:border-gray-600">
                    <h4 class="font-semibold text-gray-900 dark:text-white mb-3">Catatan</h4>
                    <div class="p-4 bg-gray-50 dark:bg-gray-700 rounded-xl">
                        <p class="text-gray-700 dark:text-gray-300">{{ $pembayaran->catatan }}</p>
                    </div>
                </div>
            @endif
        </div>

        <!-- Informasi Transaksi -->
        <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-sm border border-gray-100 dark:border-gray-700 p-6">
            <div class="flex items-center justify-between mb-6">
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        <div
                            class="w-10 h-10 bg-gradient-to-r from-green-500 to-blue-600 rounded-lg flex items-center justify-center">
                            <iconify-icon icon="heroicons:document-text-20-solid" class="w-5 h-5 text-white"></iconify-icon>
                        </div>
                    </div>
                    <div class="ml-4">
                        <h3 class="text-lg font-semibold text-gray-900 dark:text-white">Informasi Transaksi</h3>
                        <p class="text-sm text-gray-600 dark:text-gray-400">Detail transaksi terkait pembayaran ini</p>
                    </div>
                </div>
                <a href="{{ route('admin.transaksi.show', $pembayaran->transaksi->id) }}"
                    class="inline-flex items-center px-3 py-1.5 text-sm bg-gray-100 dark:bg-gray-700 text-gray-700 dark:text-gray-300 rounded-lg hover:bg-gray-200 dark:hover:bg-gray-600 transition-colors duration-200">
                    <iconify-icon icon="heroicons:eye-20-solid" class="w-4 h-4 mr-1"></iconify-icon>
                    Lihat Detail
                </a>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                <!-- Info Transaksi -->
                <div class="space-y-3">
                    <div class="flex justify-between">
                        <span class="text-gray-600 dark:text-gray-400">No. Transaksi:</span>
                        <span
                            class="font-medium text-gray-900 dark:text-white">{{ $pembayaran->transaksi->no_transaksi }}</span>
                    </div>

                    <div class="flex justify-between">
                        <span class="text-gray-600 dark:text-gray-400">Pelanggan:</span>
                        <span
                            class="font-medium text-gray-900 dark:text-white">{{ $pembayaran->transaksi->pelanggan->nama }}</span>
                    </div>

                    <div class="flex justify-between">
                        <span class="text-gray-600 dark:text-gray-400">Telepon:</span>
                        <span
                            class="font-medium text-gray-900 dark:text-white">{{ $pembayaran->transaksi->pelanggan->telepon }}</span>
                    </div>

                    <div class="flex justify-between">
                        <span class="text-gray-600 dark:text-gray-400">Mobil:</span>
                        <span class="font-medium text-gray-900 dark:text-white">
                            {{ $pembayaran->transaksi->mobil->merk }} {{ $pembayaran->transaksi->mobil->model }}
                        </span>
                    </div>

                    <div class="flex justify-between">
                        <span class="text-gray-600 dark:text-gray-400">Plat Nomor:</span>
                        <span
                            class="font-medium text-gray-900 dark:text-white">{{ $pembayaran->transaksi->mobil->plat_nomor }}</span>
                    </div>
                </div>

                <!-- Status Pembayaran Transaksi -->
                <div class="space-y-3">
                    <div class="flex justify-between">
                        <span class="text-gray-600 dark:text-gray-400">Status Transaksi:</span>
                        <span
                            class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium
                            @if ($pembayaran->transaksi->status === 'pending') bg-yellow-100 text-yellow-800 dark:bg-yellow-900 dark:text-yellow-200
                            @elseif($pembayaran->transaksi->status === 'dibayar') bg-blue-100 text-blue-800 dark:bg-blue-900 dark:text-blue-200
                            @elseif($pembayaran->transaksi->status === 'berjalan') bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200
                            @elseif($pembayaran->transaksi->status === 'selesai') bg-gray-100 text-gray-800 dark:bg-gray-700 dark:text-gray-200
                            @else bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-200 @endif">
                            {{ ucfirst($pembayaran->transaksi->status) }}
                        </span>
                    </div>

                    <div class="flex justify-between">
                        <span class="text-gray-600 dark:text-gray-400">Total Tagihan:</span>
                        <span class="font-bold text-gray-900 dark:text-white">
                            Rp {{ number_format($pembayaran->transaksi->total, 0, ',', '.') }}
                        </span>
                    </div>

                    <div class="flex justify-between">
                        <span class="text-gray-600 dark:text-gray-400">Sudah Dibayar:</span>
                        <span class="font-medium text-green-600 dark:text-green-400">
                            Rp {{ number_format($pembayaran->transaksi->total_pembayaran, 0, ',', '.') }}
                        </span>
                    </div>

                    <div class="flex justify-between">
                        <span class="text-gray-600 dark:text-gray-400">Sisa Tagihan:</span>
                        <span
                            class="font-bold {{ $pembayaran->transaksi->sisa_pembayaran > 0 ? 'text-red-600 dark:text-red-400' : 'text-green-600 dark:text-green-400' }}">
                            Rp {{ number_format($pembayaran->transaksi->sisa_pembayaran, 0, ',', '.') }}
                        </span>
                    </div>

                    <div class="flex justify-between">
                        <span class="text-gray-600 dark:text-gray-400">Status Pembayaran:</span>
                        <span
                            class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium
                            @if ($pembayaran->transaksi->status_pembayaran === 'belum_bayar') bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-200
                            @elseif($pembayaran->transaksi->status_pembayaran === 'sebagian') bg-yellow-100 text-yellow-800 dark:bg-yellow-900 dark:text-yellow-200
                            @else bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200 @endif">
                            @if ($pembayaran->transaksi->status_pembayaran === 'belum_bayar')
                                Belum Bayar
                            @elseif($pembayaran->transaksi->status_pembayaran === 'sebagian')
                                Sebagian
                            @else
                                Lunas
                            @endif
                        </span>
                    </div>
                </div>
            </div>

            <!-- Periode Sewa -->
            <div class="mt-6 pt-6 border-t border-gray-200 dark:border-gray-600">
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4 text-center">
                    <div class="p-3 bg-blue-50 dark:bg-blue-900/20 rounded-lg">
                        <p class="text-xs text-gray-600 dark:text-gray-400 mb-1">Tanggal Sewa</p>
                        <p class="font-medium text-gray-900 dark:text-white">
                            {{ $pembayaran->transaksi->tanggal_sewa->format('d M Y') }}
                        </p>
                    </div>
                    <div class="p-3 bg-green-50 dark:bg-green-900/20 rounded-lg">
                        <p class="text-xs text-gray-600 dark:text-gray-400 mb-1">Tanggal Kembali</p>
                        <p class="font-medium text-gray-900 dark:text-white">
                            {{ $pembayaran->transaksi->tanggal_kembali->format('d M Y') }}
                        </p>
                    </div>
                    <div class="p-3 bg-purple-50 dark:bg-purple-900/20 rounded-lg">
                        <p class="text-xs text-gray-600 dark:text-gray-400 mb-1">Durasi</p>
                        <p class="font-medium text-gray-900 dark:text-white">
                            {{ $pembayaran->transaksi->durasi_hari }} Hari
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal untuk memperbesar gambar -->
    <div id="imageModal" class="fixed inset-0 bg-black bg-opacity-75 hidden z-50 flex items-center justify-center p-4"
        onclick="closeImageModal()">
        <div class="relative max-w-4xl max-h-full">
            <img id="modalImage" src="" alt="Bukti Pembayaran"
                class="max-w-full max-h-full object-contain rounded-lg">
            <button onclick="closeImageModal()"
                class="absolute top-4 right-4 text-white bg-black bg-opacity-50 rounded-full p-2 hover:bg-opacity-75 transition-colors duration-200">
                <iconify-icon icon="heroicons:x-mark-20-solid" class="w-6 h-6"></iconify-icon>
            </button>
        </div>
    </div>

    @push('scripts')
        <script>
            function openImageModal(src) {
                document.getElementById('modalImage').src = src;
                document.getElementById('imageModal').classList.remove('hidden');
            }

            function closeImageModal() {
                document.getElementById('imageModal').classList.add('hidden');
                document.getElementById('modalImage').src = '';
            }

            // Close modal with Escape key
            document.addEventListener('keydown', function(e) {
                if (e.key === 'Escape') {
                    closeImageModal();
                }
            });
        </script>
    @endpush
@endsection
