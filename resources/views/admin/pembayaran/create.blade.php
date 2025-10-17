@extends('layouts.admin')

@section('title', 'Tambah Pembayaran')
@section('page-title', 'Tambah Pembayaran')
@section('page-subtitle', 'Tambahkan pembayaran baru untuk transaksi')

@section('content')
    <div class="max-w-4xl mx-auto">
        <form action="{{ route('admin.pembayaran.store') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
            @csrf

            <!-- Pilih Transaksi (Jika tidak ada transaksi_id) -->
            @if (!$transaksi)
                <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-sm border border-gray-100 dark:border-gray-700 p-6">
                    <div class="flex items-center mb-6">
                        <div class="flex-shrink-0">
                            <div
                                class="w-10 h-10 bg-gradient-to-r from-blue-500 to-purple-600 rounded-lg flex items-center justify-center">
                                <iconify-icon icon="heroicons:document-text-20-solid"
                                    class="w-5 h-5 text-white"></iconify-icon>
                            </div>
                        </div>
                        <div class="ml-4">
                            <h3 class="text-lg font-semibold text-gray-900 dark:text-white">Pilih Transaksi</h3>
                            <p class="text-sm text-gray-600 dark:text-gray-400">Pilih transaksi yang akan dibayar</p>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 gap-6">
                        <div>
                            <label for="transaksi_search"
                                class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                Cari Transaksi
                            </label>
                            <input type="text" id="transaksi_search"
                                placeholder="Ketik nomor transaksi atau nama pelanggan..."
                                class="w-full px-4 py-2 border border-gray-200 dark:border-gray-600 rounded-xl focus:ring-2 focus:ring-indigo-500 dark:focus:ring-indigo-400 bg-white dark:bg-gray-700 text-gray-900 dark:text-white">
                            <p class="mt-1 text-xs text-gray-500 dark:text-gray-400">
                                Hanya transaksi dengan status 'dibayar', 'berjalan', atau 'telat' yang dapat ditambahkan
                                pembayaran
                            </p>
                        </div>

                        <!-- Hasil pencarian akan ditampilkan di sini dengan AJAX -->
                        <div id="transaksi_results" class="hidden">
                            <!-- Dynamic content -->
                        </div>

                        <input type="hidden" name="transaksi_id" id="selected_transaksi_id" required>
                    </div>
                </div>
            @else
                <!-- Info Transaksi -->
                <div
                    class="bg-white dark:bg-gray-800 rounded-2xl shadow-sm border border-gray-100 dark:border-gray-700 p-6">
                    <div class="flex items-center mb-6">
                        <div class="flex-shrink-0">
                            <div
                                class="w-10 h-10 bg-gradient-to-r from-blue-500 to-purple-600 rounded-lg flex items-center justify-center">
                                <iconify-icon icon="heroicons:document-text-20-solid"
                                    class="w-5 h-5 text-white"></iconify-icon>
                            </div>
                        </div>
                        <div class="ml-4">
                            <h3 class="text-lg font-semibold text-gray-900 dark:text-white">Info Transaksi</h3>
                            <p class="text-sm text-gray-600 dark:text-gray-400">Detail transaksi yang akan dibayar</p>
                        </div>
                    </div>

                    <input type="hidden" name="transaksi_id" value="{{ $transaksi->id }}">

                    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                        <!-- Info Transaksi -->
                        <div class="space-y-4">
                            <div
                                class="p-4 bg-gray-50 dark:bg-gray-700 rounded-xl border border-gray-200 dark:border-gray-600">
                                <h4 class="font-medium text-gray-900 dark:text-white mb-3">Detail Transaksi</h4>
                                <div class="space-y-2 text-sm">
                                    <div class="flex justify-between">
                                        <span class="text-gray-600 dark:text-gray-400">No. Transaksi:</span>
                                        <span
                                            class="font-medium text-gray-900 dark:text-white">{{ $transaksi->no_transaksi }}</span>
                                    </div>
                                    <div class="flex justify-between">
                                        <span class="text-gray-600 dark:text-gray-400">Pelanggan:</span>
                                        <span
                                            class="font-medium text-gray-900 dark:text-white">{{ $transaksi->pelanggan->nama }}</span>
                                    </div>
                                    <div class="flex justify-between">
                                        <span class="text-gray-600 dark:text-gray-400">Mobil:</span>
                                        <span
                                            class="font-medium text-gray-900 dark:text-white">{{ $transaksi->mobil->merk }}
                                            {{ $transaksi->mobil->model }}</span>
                                    </div>
                                    <div class="flex justify-between">
                                        <span class="text-gray-600 dark:text-gray-400">Periode:</span>
                                        <span class="font-medium text-gray-900 dark:text-white">
                                            {{ $transaksi->tanggal_sewa->format('d M Y') }} -
                                            {{ $transaksi->tanggal_kembali->format('d M Y') }}
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Info Pembayaran -->
                        <div class="space-y-4">
                            <div
                                class="p-4 bg-blue-50 dark:bg-blue-900/20 rounded-xl border border-blue-200 dark:border-blue-800">
                                <h4 class="font-medium text-gray-900 dark:text-white mb-3">Status Pembayaran</h4>
                                <div class="space-y-2 text-sm">
                                    <div class="flex justify-between">
                                        <span class="text-gray-600 dark:text-gray-400">Total Tagihan:</span>
                                        <span class="font-bold text-gray-900 dark:text-white">Rp
                                            {{ number_format($transaksi->total, 0, ',', '.') }}</span>
                                    </div>
                                    <div class="flex justify-between">
                                        <span class="text-gray-600 dark:text-gray-400">Sudah Dibayar:</span>
                                        <span class="font-medium text-green-600 dark:text-green-400">Rp
                                            {{ number_format($transaksi->total_pembayaran, 0, ',', '.') }}</span>
                                    </div>
                                    <div class="flex justify-between border-t border-blue-200 dark:border-blue-700 pt-2">
                                        <span class="text-gray-600 dark:text-gray-400">Sisa Tagihan:</span>
                                        <span class="font-bold text-red-600 dark:text-red-400">Rp
                                            {{ number_format($transaksi->sisa_pembayaran, 0, ',', '.') }}</span>
                                    </div>
                                </div>
                            </div>

                            @if ($transaksi->pembayaran->count() > 0)
                                <div
                                    class="p-4 bg-gray-50 dark:bg-gray-700 rounded-xl border border-gray-200 dark:border-gray-600">
                                    <h4 class="font-medium text-gray-900 dark:text-white mb-3">Riwayat Pembayaran</h4>
                                    <div class="space-y-2 text-sm max-h-32 overflow-y-auto">
                                        @foreach ($transaksi->pembayaran as $payment)
                                            <div class="flex justify-between">
                                                <span class="text-gray-600 dark:text-gray-400">
                                                    {{ $payment->created_at->format('d/m/Y') }} -
                                                    {{ ucfirst($payment->metode) }}
                                                </span>
                                                <span
                                                    class="font-medium
                                                    @if ($payment->status === 'terkonfirmasi') text-green-600 dark:text-green-400
                                                    @elseif($payment->status === 'pending') text-yellow-600 dark:text-yellow-400
                                                    @else text-red-600 dark:text-red-400 @endif">
                                                    Rp {{ number_format($payment->jumlah, 0, ',', '.') }}
                                                </span>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            @endif

            <!-- Form Pembayaran -->
            <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-sm border border-gray-100 dark:border-gray-700 p-6">
                <div class="flex items-center mb-6">
                    <div class="flex-shrink-0">
                        <div
                            class="w-10 h-10 bg-gradient-to-r from-green-500 to-blue-600 rounded-lg flex items-center justify-center">
                            <iconify-icon icon="heroicons:credit-card-20-solid" class="w-5 h-5 text-white"></iconify-icon>
                        </div>
                    </div>
                    <div class="ml-4">
                        <h3 class="text-lg font-semibold text-gray-900 dark:text-white">Detail Pembayaran</h3>
                        <p class="text-sm text-gray-600 dark:text-gray-400">Masukkan detail pembayaran yang akan dicatat</p>
                    </div>
                </div>

                <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                    <!-- Jumlah Pembayaran -->
                    <div>
                        <label for="jumlah" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                            Jumlah Pembayaran *
                        </label>
                        <input type="number" name="jumlah" id="jumlah" value="{{ old('jumlah') }}"
                            @if ($transaksi) max="{{ $transaksi->sisa_pembayaran }}" @endif min="1"
                            step="1000" required
                            class="w-full px-4 py-2 border border-gray-200 dark:border-gray-600 rounded-xl focus:ring-2 focus:ring-indigo-500 dark:focus:ring-indigo-400 bg-white dark:bg-gray-700 text-gray-900 dark:text-white">
                        @error('jumlah')
                            <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                        @enderror
                        @if ($transaksi)
                            <p class="mt-1 text-xs text-gray-500 dark:text-gray-400">
                                Maksimal: Rp {{ number_format($transaksi->sisa_pembayaran, 0, ',', '.') }}
                            </p>
                        @endif
                    </div>

                    <!-- Metode Pembayaran -->
                    <div>
                        <label for="metode" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                            Metode Pembayaran *
                        </label>
                        <select name="metode" id="metode" required
                            class="w-full px-4 py-2 border border-gray-200 dark:border-gray-600 rounded-xl focus:ring-2 focus:ring-indigo-500 dark:focus:ring-indigo-400 bg-white dark:bg-gray-700 text-gray-900 dark:text-white">
                            <option value="">Pilih metode pembayaran</option>
                            <option value="tunai" {{ old('metode') === 'tunai' ? 'selected' : '' }}>Tunai</option>
                            <option value="transfer" {{ old('metode') === 'transfer' ? 'selected' : '' }}>Transfer Bank
                            </option>
                            <option value="qris" {{ old('metode') === 'qris' ? 'selected' : '' }}>QRIS</option>
                            <option value="kartu" {{ old('metode') === 'kartu' ? 'selected' : '' }}>Kartu Debit/Kredit
                            </option>
                            <option value="ewallet" {{ old('metode') === 'ewallet' ? 'selected' : '' }}>E-Wallet</option>
                        </select>
                        @error('metode')
                            <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Tanggal Pembayaran -->
                    <div>
                        <label for="tanggal_bayar"
                            class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                            Tanggal Pembayaran *
                        </label>
                        <input type="datetime-local" name="tanggal_bayar" id="tanggal_bayar"
                            value="{{ old('tanggal_bayar', now()->format('Y-m-d\TH:i')) }}" required
                            class="w-full px-4 py-2 border border-gray-200 dark:border-gray-600 rounded-xl focus:ring-2 focus:ring-indigo-500 dark:focus:ring-indigo-400 bg-white dark:bg-gray-700 text-gray-900 dark:text-white">
                        @error('tanggal_bayar')
                            <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Bukti Pembayaran -->
                    <div>
                        <label for="bukti_bayar" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                            Bukti Pembayaran
                        </label>
                        <input type="file" name="bukti_bayar" id="bukti_bayar" accept="image/*"
                            class="w-full px-4 py-2 border border-gray-200 dark:border-gray-600 rounded-xl focus:ring-2 focus:ring-indigo-500 dark:focus:ring-indigo-400 bg-white dark:bg-gray-700 text-gray-900 dark:text-white">
                        @error('bukti_bayar')
                            <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                        @enderror
                        <p class="mt-1 text-xs text-gray-500 dark:text-gray-400">
                            Upload gambar bukti pembayaran (JPG, PNG, maksimal 2MB)
                        </p>
                    </div>

                    <!-- Catatan -->
                    <div class="lg:col-span-2">
                        <label for="catatan" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                            Catatan
                        </label>
                        <textarea name="catatan" id="catatan" rows="3" placeholder="Catatan tambahan tentang pembayaran ini..."
                            class="w-full px-4 py-2 border border-gray-200 dark:border-gray-600 rounded-xl focus:ring-2 focus:ring-indigo-500 dark:focus:ring-indigo-400 bg-white dark:bg-gray-700 text-gray-900 dark:text-white">{{ old('catatan') }}</textarea>
                        @error('catatan')
                            <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
            </div>

            <!-- Action Buttons -->
            <div class="flex flex-col sm:flex-row gap-4 justify-end">
                <a href="{{ route('admin.pembayaran.index') }}"
                    class="px-6 py-2 border border-gray-300 dark:border-gray-600 text-gray-700 dark:text-gray-300 bg-white dark:bg-gray-800 rounded-xl hover:bg-gray-50 dark:hover:bg-gray-700 font-medium transition-colors duration-200 text-center">
                    Batal
                </a>
                <button type="submit"
                    class="px-6 py-2 bg-indigo-600 hover:bg-indigo-700 text-white font-medium rounded-xl transition-colors duration-200">
                    <iconify-icon icon="heroicons:plus-20-solid" class="w-4 h-4 mr-2 inline"></iconify-icon>
                    Simpan Pembayaran
                </button>
            </div>
        </form>
    </div>

    @push('scripts')
        <script>
            // Auto format currency input
            document.getElementById('jumlah').addEventListener('input', function(e) {
                let value = e.target.value.replace(/[^\d]/g, '');
                if (value) {
                    // Update the placeholder or helper text to show formatted value
                    const formatted = 'Rp ' + parseInt(value).toLocaleString('id-ID');
                    console.log('Formatted:', formatted);
                }
            });

            // Set default date to now
            document.addEventListener('DOMContentLoaded', function() {
                const now = new Date();
                const year = now.getFullYear();
                const month = (now.getMonth() + 1).toString().padStart(2, '0');
                const date = now.getDate().toString().padStart(2, '0');
                const hours = now.getHours().toString().padStart(2, '0');
                const minutes = now.getMinutes().toString().padStart(2, '0');

                const dateTimeString = `${year}-${month}-${date}T${hours}:${minutes}`;
                document.getElementById('tanggal_bayar').value = dateTimeString;
            });
        </script>
    @endpush
@endsection
