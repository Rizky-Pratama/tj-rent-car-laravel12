@extends('layouts.admin')

@section('title', 'Kelola Pembayaran')
@section('page-title', 'Kelola Pembayaran')
@section('page-subtitle', 'Manajemen pembayaran transaksi rental')

@section('content')
    <div class="max-w-7xl mx-auto">
        <!-- Back Button -->
        <div class="mb-4">
            <a href="{{ route('admin.transaksi.show', $transaksi->id) }}"
                class="inline-flex items-center text-sm text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-gray-100 transition-colors">
                <iconify-icon icon="solar:arrow-left-bold" class="mr-2"></iconify-icon>
                Kembali ke Detail Transaksi
            </a>
        </div>

        @if ($errors->any())
            <div class="mt-4">
                <h3 class="text-sm font-medium text-red-800 dark:text-red-200 mb-2">Terjadi kesalahan pada form:</h3>
                <ul class="list-disc list-inside text-sm text-red-600 dark:text-red-400">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
        <!-- Header Card -->
        <div
            class="bg-gradient-to-r from-blue-600 to-purple-600 dark:from-blue-700 dark:to-purple-700 rounded-xl p-6 mb-8 text-white shadow-lg">
            <div class="flex flex-col md:flex-row md:items-center md:justify-between">
                <div>
                    <h1 class="text-2xl font-bold mb-2">Kelola Pembayaran</h1>
                    <div class="flex flex-wrap gap-4 text-sm">
                        <span
                            class="flex items-center gap-2 bg-white/20 dark:bg-white/30 px-3 py-1 rounded-full backdrop-blur-sm">
                            <iconify-icon icon="solar:document-text-bold"></iconify-icon>
                            {{ $transaksi->no_transaksi }}
                        </span>
                        <span
                            class="flex items-center gap-2 bg-white/20 dark:bg-white/30 px-3 py-1 rounded-full backdrop-blur-sm">
                            <iconify-icon icon="solar:user-bold"></iconify-icon>
                            {{ $transaksi->pelanggan->nama }}
                        </span>
                    </div>
                </div>
                @if ($transaksi->sisa_pembayaran <= 0)
                    <div class="mt-4 md:mt-0">
                        <div
                            class="inline-flex items-center gap-2 bg-green-500 dark:bg-green-600 px-4 py-2 rounded-full text-sm font-medium shadow-lg">
                            <iconify-icon icon="solar:check-circle-bold"></iconify-icon>
                            LUNAS
                        </div>
                    </div>
                @endif
            </div>
        </div>

        <!-- Payment Dashboard Layout -->
        <div class="grid lg:grid-cols-3 gap-8">
            <!-- Main Payment Forms -->
            <div class="lg:col-span-2 space-y-6">
                <!-- Add New Payment Card -->
                @if ($transaksi->sisa_pembayaran > 0)
                    <div
                        class="bg-white dark:bg-gray-800 rounded-xl border border-gray-200 dark:border-gray-700 shadow-sm p-6">
                        <div class="flex items-center gap-3 mb-6">
                            <div
                                class="w-10 h-10 bg-gradient-to-r from-emerald-500 to-teal-500 dark:from-emerald-600 dark:to-teal-600 rounded-xl flex items-center justify-center shadow-md">
                                <iconify-icon icon="solar:card-send-bold" class="text-white text-xl"></iconify-icon>
                            </div>
                            <div>
                                <h2 class="text-xl font-bold text-gray-900 dark:text-white">Tambah Pembayaran Baru</h2>
                                <p class="text-sm text-gray-500 dark:text-gray-400">Catat pembayaran dari pelanggan</p>
                            </div>
                        </div>

                        <form action="{{ route('admin.pembayaran.store') }}" method="POST" enctype="multipart/form-data"
                            class="space-y-6">
                            @csrf
                            <input type="hidden" name="transaksi_id" value="{{ $transaksi->id }}">

                            <!-- Payment Amount & Method -->
                            <div class="grid md:grid-cols-2 gap-6">
                                <div class="space-y-2">
                                    <label
                                        class="flex items-center text-sm font-medium text-gray-700 dark:text-gray-300 mb-3">
                                        <iconify-icon icon="solar:dollar-minimalistic-bold"
                                            class="mr-2 text-emerald-600 dark:text-emerald-400"></iconify-icon>
                                        Jumlah Pembayaran *
                                    </label>
                                    <input type="number" name="jumlah" required min="1"
                                        max="{{ $transaksi->sisa_pembayaran }}"
                                        class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-lg focus:outline-none focus:ring-2 focus:ring-emerald-500 dark:focus:ring-emerald-400 focus:border-transparent transition-all duration-200 bg-white dark:bg-gray-700 text-gray-900 dark:text-white dark:placeholder-gray-400"
                                        placeholder="Masukkan jumlah">
                                    <div class="flex justify-between text-xs">
                                        <span class="text-gray-500 dark:text-gray-400">Min: Rp 1</span>
                                        <span class="text-emerald-600 dark:text-emerald-400 font-medium">Maks: Rp
                                            {{ number_format($transaksi->sisa_pembayaran, 0, ',', '.') }}</span>
                                    </div>
                                </div>

                                <div class="space-y-2">
                                    <label
                                        class="flex items-center text-sm font-medium text-gray-700 dark:text-gray-300 mb-3">
                                        <iconify-icon icon="solar:wallet-bold"
                                            class="mr-2 text-blue-600 dark:text-blue-400"></iconify-icon>
                                        Metode Pembayaran *
                                    </label>
                                    <select name="metode" required
                                        class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 dark:focus:ring-blue-400 focus:border-transparent transition-all duration-200 bg-white dark:bg-gray-700 text-gray-900 dark:text-white">
                                        <option value="">-- Pilih Metode --</option>
                                        <option value="transfer">Transfer Bank</option>
                                        <option value="tunai">Cash / Tunai</option>
                                        <option value="qris">QRIS</option>
                                        <option value="kartu">Kartu Kredit</option>
                                        <option value="ewallet">E-Wallet</option>
                                    </select>
                                </div>
                            </div>

                            <!-- Date & Status -->
                            <div class="grid md:grid-cols-2 gap-6">
                                <div class="space-y-2">
                                    <label
                                        class="flex items-center text-sm font-medium text-gray-700 dark:text-gray-300 mb-3">
                                        <iconify-icon icon="solar:calendar-bold"
                                            class="mr-2 text-purple-600 dark:text-purple-400"></iconify-icon>
                                        Tanggal & Waktu *
                                    </label>
                                    <input type="datetime-local" name="tanggal_bayar" required
                                        value="{{ now()->format('Y-m-d\TH:i') }}"
                                        class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-lg focus:outline-none focus:ring-2 focus:ring-purple-500 dark:focus:ring-purple-400 focus:border-transparent transition-all duration-200 bg-white dark:bg-gray-700 text-gray-900 dark:text-white">
                                </div>

                                <div class="space-y-2">
                                    <label class="flex items-center text-sm font-medium text-gray-700 mb-3">
                                        <iconify-icon icon="solar:shield-check-bold"
                                            class="mr-2 text-orange-600 dark:text-orange-400"></iconify-icon>
                                        Status Pembayaran *
                                    </label>
                                    <select name="status" required
                                        class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-lg focus:outline-none focus:ring-2 focus:ring-orange-500 dark:focus:ring-orange-400 focus:border-transparent transition-all duration-200 bg-white dark:bg-gray-700 text-gray-900 dark:text-white">
                                        <option value="terkonfirmasi">Terkonfirmasi</option>
                                        <option value="pending">Pending Konfirmasi</option>
                                    </select>
                                </div>
                            </div>

                            <!-- Description -->
                            <div class="space-y-2">
                                <label class="flex items-center text-sm font-medium text-gray-700 dark:text-gray-300 mb-3">
                                    <iconify-icon icon="solar:notes-bold"
                                        class="mr-2 text-gray-600 dark:text-gray-400"></iconify-icon>
                                    Keterangan (Opsional)
                                </label>
                                <textarea name="keterangan" rows="3"
                                    class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-lg focus:outline-none focus:ring-2 focus:ring-gray-400 dark:focus:ring-gray-500 focus:border-transparent transition-all duration-200 resize-none bg-white dark:bg-gray-700 text-gray-900 dark:text-white dark:placeholder-gray-400"
                                    placeholder="Catatan tambahan untuk pembayaran ini..."></textarea>
                            </div>

                            <!-- Payment Proof -->
                            <div class="space-y-2">
                                <label class="flex items-center text-sm font-medium text-gray-700 dark:text-gray-300 mb-3">
                                    <iconify-icon icon="solar:gallery-bold"
                                        class="mr-2 text-indigo-600 dark:text-indigo-400"></iconify-icon>
                                    Bukti Pembayaran
                                </label>
                                <div
                                    class="border-2 border-dashed border-gray-300 dark:border-gray-600 rounded-lg p-6 hover:border-indigo-400 dark:hover:border-indigo-500 transition-colors bg-white dark:bg-gray-800">
                                    <input type="file" name="bukti_bayar" accept="image/*,.pdf"
                                        class="w-full text-sm text-gray-500 dark:text-gray-400 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-medium file:bg-indigo-50 dark:file:bg-indigo-900/30 file:text-indigo-700 dark:file:text-indigo-300 hover:file:bg-indigo-100 dark:hover:file:bg-indigo-900/50">
                                    <p class="text-xs text-gray-500 dark:text-gray-400 mt-2">📄 Format: JPG, PNG, PDF •
                                        Maksimal 2MB</p>
                                </div>
                            </div>
                            <!-- Quick Payment Actions -->
                            <div
                                class="bg-gradient-to-r from-gray-50 to-blue-50 dark:from-gray-800 dark:to-blue-900/30 rounded-lg p-4 border border-blue-100 dark:border-blue-800">
                                <div class="flex items-center gap-2 mb-3">
                                    <iconify-icon icon="solar:lightning-bold"
                                        class="text-blue-600 dark:text-blue-400"></iconify-icon>
                                    <span class="text-sm font-medium text-gray-700 dark:text-gray-300">Aksi Cepat</span>
                                </div>
                                <div class="flex flex-wrap gap-2">
                                    <button type="button" onclick="quickPayFull()"
                                        class="flex-1 min-w-0 bg-emerald-500 hover:bg-emerald-600 dark:bg-emerald-600 dark:hover:bg-emerald-700 text-white px-3 py-2 rounded-lg text-sm font-medium transition-colors shadow-md">
                                        Bayar Lunas
                                    </button>
                                    <button type="button" onclick="quickPayHalf()"
                                        class="flex-1 min-w-0 bg-blue-500 hover:bg-blue-600 dark:bg-blue-600 dark:hover:bg-blue-700 text-white px-3 py-2 rounded-lg text-sm font-medium transition-colors shadow-md">
                                        Bayar 50%
                                    </button>
                                </div>
                            </div>

                            <!-- Submit Button -->
                            <div
                                class="flex flex-col sm:flex-row gap-4 justify-end pt-4 border-t border-gray-200 dark:border-gray-700">
                                <button type="reset"
                                    class="inline-flex items-center justify-center px-6 py-3 border border-gray-300 dark:border-gray-600 rounded-lg text-gray-700 dark:text-gray-300 bg-white dark:bg-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600 transition-colors font-medium">
                                    <iconify-icon icon="solar:restart-bold" class="mr-2"></iconify-icon>
                                    Reset
                                </button>
                                <button type="submit"
                                    class="inline-flex items-center justify-center px-8 py-3 bg-gradient-to-r from-emerald-600 to-teal-600 dark:from-emerald-700 dark:to-teal-700 hover:from-emerald-700 hover:to-teal-700 dark:hover:from-emerald-800 dark:hover:to-teal-800 text-white rounded-lg transition-all duration-200 font-medium shadow-lg hover:shadow-xl">
                                    <iconify-icon icon="solar:card-send-bold" class="mr-2"></iconify-icon>
                                    Simpan Pembayaran
                                </button>
                            </div>
                        </form>
                    </div>
                @else
                    <div
                        class="bg-white dark:bg-gray-800 rounded-xl border border-gray-200 dark:border-gray-700 shadow-sm p-6">
                        <div class="text-center py-8">
                            <div
                                class="w-16 h-16 bg-green-100 dark:bg-green-900/30 rounded-full flex items-center justify-center mx-auto mb-4 shadow-lg">
                                <iconify-icon icon="solar:verified-check-bold"
                                    class="text-green-600 dark:text-green-400 text-2xl"></iconify-icon>
                            </div>
                            <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-2">Transaksi Sudah Lunas! 🎉
                            </h3>
                            <p class="text-gray-500 dark:text-gray-400 mb-4">Semua pembayaran telah diterima dengan
                                lengkap.</p>
                            <a href="{{ route('admin.transaksi.show', $transaksi->id) }}"
                                class="inline-flex items-center gap-2 bg-blue-600 hover:bg-blue-700 dark:bg-blue-700 dark:hover:bg-blue-800 text-white px-4 py-2 rounded-lg transition-colors shadow-md">
                                <iconify-icon icon="solar:eye-bold"></iconify-icon>
                                Lihat Detail Transaksi
                            </a>
                        </div>
                    </div>
                @endif

                <!-- Payment History -->
                <div
                    class="bg-white dark:bg-gray-800 rounded-xl border border-gray-200 dark:border-gray-700 shadow-sm p-6">
                    <div class="flex items-center gap-3 mb-6">
                        <div
                            class="w-10 h-10 bg-gradient-to-r from-blue-500 to-purple-500 dark:from-blue-600 dark:to-purple-600 rounded-xl flex items-center justify-center shadow-md">
                            <iconify-icon icon="solar:history-bold" class="text-white text-xl"></iconify-icon>
                        </div>
                        <div>
                            <h2 class="text-xl font-bold text-gray-900 dark:text-white">Riwayat Pembayaran</h2>
                            <p class="text-sm text-gray-500 dark:text-gray-400">{{ $transaksi->pembayaran->count() }}
                                pembayaran tercatat</p>
                        </div>
                    </div>

                    @if ($transaksi->pembayaran->count() > 0)
                        <div class="space-y-4">
                            @foreach ($transaksi->pembayaran as $index => $bayar)
                                <div
                                    class="bg-gradient-to-r from-gray-50 to-blue-50 dark:from-gray-700 dark:to-blue-900/30 border border-gray-200 dark:border-gray-700 rounded-lg p-4 hover:shadow-md transition-all duration-200">
                                    <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
                                        <!-- Payment Info -->
                                        <div class="flex-1">
                                            <div class="flex items-center gap-3 mb-2">
                                                <div
                                                    class="flex-shrink-0 w-8 h-8 bg-blue-100 dark:bg-blue-900/50 rounded-full flex items-center justify-center shadow-sm">
                                                    <span
                                                        class="text-sm font-bold text-blue-600 dark:text-blue-300">#{{ $index + 1 }}</span>
                                                </div>
                                                <div>
                                                    <h4 class="font-semibold text-gray-900 dark:text-white">
                                                        Rp {{ number_format($bayar->jumlah, 0, ',', '.') }}
                                                    </h4>
                                                    <p class="text-sm text-gray-500 dark:text-gray-400">
                                                        {{ $bayar->tanggal_bayar ? Carbon\Carbon::parse($bayar->tanggal_bayar)->format('d/m/Y H:i') : $bayar->created_at->format('d/m/Y H:i') }}
                                                    </p>
                                                </div>
                                            </div>

                                            <div class="flex flex-wrap gap-2 mb-3">
                                                <!-- Payment Method -->
                                                <span
                                                    class="inline-flex items-center gap-1 px-3 py-1 bg-white dark:bg-gray-800 rounded-full text-xs font-medium text-gray-700 dark:text-gray-300 border border-gray-200 dark:border-gray-600 shadow-sm">
                                                    <iconify-icon icon="solar:wallet-bold" class="text-sm"></iconify-icon>
                                                    {{ ucfirst($bayar->metode) }}
                                                </span>

                                                <!-- Status Badge -->
                                                <span
                                                    class="inline-flex items-center gap-1 px-3 py-1 rounded-full text-xs font-medium shadow-sm
                                                    {{ $bayar->status == 'terkonfirmasi' ? 'bg-green-100 dark:bg-green-900/30 text-green-800 dark:text-green-300' : 'bg-yellow-100 dark:bg-yellow-900/30 text-yellow-800 dark:text-yellow-300' }}">
                                                    @if ($bayar->status == 'terkonfirmasi')
                                                        <iconify-icon icon="solar:check-circle-bold"
                                                            class="text-sm"></iconify-icon>
                                                    @elseif ($bayar->status == 'pending')
                                                        <iconify-icon icon="solar:clock-bold"
                                                            class="text-sm"></iconify-icon>
                                                    @elseif ($bayar->status == 'refunded')
                                                        <iconify-icon icon="solar:arrow-circle-down-bold"
                                                            class="text-sm"></iconify-icon>
                                                    @elseif ($bayar->status == 'gagal')
                                                        <iconify-icon icon="solar:close-circle-bold"
                                                            class="text-sm"></iconify-icon>
                                                    @endif
                                                    {{ ucfirst($bayar->status) }}
                                                </span>
                                            </div>

                                            @if ($bayar->keterangan)
                                                <p class="text-sm text-gray-600 dark:text-gray-400 italic">
                                                    {{ $bayar->keterangan }}</p>
                                            @endif
                                        </div>

                                        <!-- Actions -->
                                        <div class="flex flex-wrap gap-2">
                                            @if ($bayar->bukti_pembayaran)
                                                <a href="{{ asset('storage/' . $bayar->bukti_pembayaran) }}"
                                                    target="_blank"
                                                    class="inline-flex items-center gap-2 px-3 py-2 bg-blue-100 hover:bg-blue-200 dark:bg-blue-900/30 dark:hover:bg-blue-900/50 text-blue-700 dark:text-blue-300 rounded-lg text-sm font-medium transition-colors shadow-sm">
                                                    <iconify-icon icon="solar:eye-bold" class="text-sm"></iconify-icon>
                                                    Bukti
                                                </a>
                                            @endif

                                            @if ($bayar->status == 'pending')
                                                <form action="{{ route('admin.pembayaran.confirm', $bayar->id) }}"
                                                    method="POST" class="inline">
                                                    @csrf
                                                    @method('PATCH')
                                                    <button type="submit"
                                                        class="inline-flex items-center gap-2 px-3 py-2 bg-green-100 hover:bg-green-200 dark:bg-green-900/30 dark:hover:bg-green-900/50 text-green-700 dark:text-green-300 rounded-lg text-sm font-medium transition-colors shadow-sm"
                                                        onclick="return confirm('Konfirmasi pembayaran ini?')">
                                                        <iconify-icon icon="solar:check-circle-bold"
                                                            class="text-sm"></iconify-icon>
                                                        Konfirmasi
                                                    </button>
                                                </form>
                                            @endif

                                            <form action="{{ route('admin.pembayaran.destroy', $bayar->id) }}"
                                                method="POST" class="inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit"
                                                    class="inline-flex items-center gap-2 px-3 py-2 bg-red-100 hover:bg-red-200 dark:bg-red-900/30 dark:hover:bg-red-900/50 text-red-700 dark:text-red-300 rounded-lg text-sm font-medium transition-colors shadow-sm"
                                                    onclick="return confirm('Yakin ingin menghapus pembayaran ini?')">
                                                    <iconify-icon icon="solar:trash-bin-minimalistic-bold"
                                                        class="text-sm"></iconify-icon>
                                                    Hapus
                                                </button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <div class="text-center py-12">
                            <div
                                class="w-16 h-16 bg-gray-100 dark:bg-gray-700 rounded-full flex items-center justify-center mx-auto mb-4 shadow-md">
                                <iconify-icon icon="solar:card-bold"
                                    class="text-gray-400 dark:text-gray-500 text-2xl"></iconify-icon>
                            </div>
                            <h3 class="text-lg font-medium text-gray-900 dark:text-white mb-2">Belum Ada Pembayaran</h3>
                            <p class="text-gray-500 dark:text-gray-400">Transaksi ini belum memiliki riwayat pembayaran</p>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Sidebar -->
            <div class="space-y-6">
                <!-- Transaction Summary -->
                <div
                    class="bg-white dark:bg-gray-800 rounded-xl border border-gray-200 dark:border-gray-700 shadow-sm p-6">
                    <div class="flex items-center gap-3 mb-4">
                        <div
                            class="w-8 h-8 bg-blue-100 dark:bg-blue-900/50 rounded-lg flex items-center justify-center shadow-sm">
                            <iconify-icon icon="solar:document-text-bold"
                                class="text-blue-600 dark:text-blue-400"></iconify-icon>
                        </div>
                        <div>
                            <h3 class="font-semibold text-gray-900 dark:text-white">Ringkasan Transaksi</h3>
                        </div>
                    </div>

                    <div class="space-y-3">
                        <div class="flex justify-between items-center py-2 border-b border-gray-100 dark:border-gray-700">
                            <span class="text-sm text-gray-600 dark:text-gray-400">No. Transaksi</span>
                            <span
                                class="text-sm font-medium text-gray-900 dark:text-white">{{ $transaksi->no_transaksi }}</span>
                        </div>
                        <div class="flex justify-between items-center py-2 border-b border-gray-100 dark:border-gray-700">
                            <span class="text-sm text-gray-600 dark:text-gray-400">Pelanggan</span>
                            <span
                                class="text-sm font-medium text-gray-900 dark:text-white">{{ $transaksi->pelanggan->nama }}</span>
                        </div>
                        <div class="flex justify-between items-center py-2 border-b border-gray-100 dark:border-gray-700">
                            <span class="text-sm text-gray-600 dark:text-gray-400">Mobil</span>
                            <span class="text-sm font-medium text-gray-900 dark:text-white">{{ $transaksi->mobil->merk }}
                                {{ $transaksi->mobil->model }}</span>
                        </div>
                        <div class="flex justify-between items-center py-2 border-b border-gray-100 dark:border-gray-700">
                            <span class="text-sm text-gray-600 dark:text-gray-400">Periode</span>
                            <span
                                class="text-sm font-medium text-gray-900 dark:text-white">{{ $transaksi->tanggal_sewa->format('d/m/Y') }}
                                -
                                {{ $transaksi->tanggal_kembali->format('d/m/Y') }}</span>
                        </div>
                        <div class="flex justify-between items-center py-2">
                            <span class="text-sm text-gray-600 dark:text-gray-400">Status</span>
                            @php
                                $statusConfig = [
                                    'booking' => [
                                        'bg' => 'bg-yellow-100 dark:bg-yellow-900/30',
                                        'text' => 'text-yellow-800 dark:text-yellow-300',
                                        'label' => 'Booking',
                                    ],
                                    'aktif' => [
                                        'bg' => 'bg-green-100 dark:bg-green-900/30',
                                        'text' => 'text-green-800 dark:text-green-300',
                                        'label' => 'Aktif',
                                    ],
                                    'selesai' => [
                                        'bg' => 'bg-blue-100 dark:bg-blue-900/30',
                                        'text' => 'text-blue-800 dark:text-blue-300',
                                        'label' => 'Selesai',
                                    ],
                                    'batal' => [
                                        'bg' => 'bg-red-100 dark:bg-red-900/30',
                                        'text' => 'text-red-800 dark:text-red-300',
                                        'label' => 'Batal',
                                    ],
                                ];
                                $status = $statusConfig[$transaksi->status] ?? $statusConfig['booking'];
                            @endphp
                            <span
                                class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium shadow-sm {{ $status['bg'] }} {{ $status['text'] }}">
                                {{ $status['label'] }}
                            </span>
                        </div>
                    </div>
                </div>

                <!-- Financial Summary -->
                <div
                    class="bg-gradient-to-br from-emerald-50 to-teal-50 dark:from-emerald-900/20 dark:to-teal-900/20 rounded-xl border border-emerald-200 dark:border-emerald-800 shadow-sm p-6">
                    <div class="flex items-center gap-3 mb-4">
                        <div
                            class="w-8 h-8 bg-emerald-500 dark:bg-emerald-600 rounded-lg flex items-center justify-center shadow-md">
                            <iconify-icon icon="solar:dollar-minimalistic-bold" class="text-white"></iconify-icon>
                        </div>
                        <div>
                            <h3 class="font-semibold text-gray-900 dark:text-white">Ringkasan Keuangan</h3>
                        </div>
                    </div>

                    <div class="space-y-4">
                        <div class="bg-white/60 dark:bg-gray-800/60 rounded-lg p-4 shadow-sm">
                            <div class="flex justify-between items-center">
                                <span class="text-sm text-emerald-700 dark:text-emerald-300">Total Tagihan</span>
                                <span class="text-lg font-bold text-emerald-800 dark:text-emerald-200">Rp
                                    {{ number_format($transaksi->total, 0, ',', '.') }}</span>
                            </div>
                        </div>

                        <div class="bg-white/60 dark:bg-gray-800/60 rounded-lg p-4 shadow-sm">
                            <div class="flex justify-between items-center">
                                <span class="text-sm text-blue-700 dark:text-blue-300">Total Terbayar</span>
                                <span class="text-lg font-bold text-blue-800 dark:text-blue-200">Rp
                                    {{ number_format($transaksi->total_pembayaran, 0, ',', '.') }}</span>
                            </div>
                        </div>

                        <div
                            class="bg-white dark:bg-gray-800 rounded-lg p-4 border-2 shadow-md {{ $transaksi->sisa_pembayaran > 0 ? 'border-red-200 dark:border-red-800' : 'border-green-200 dark:border-green-800' }}">
                            <div class="flex justify-between items-center">
                                <span
                                    class="text-sm font-medium {{ $transaksi->sisa_pembayaran > 0 ? 'text-red-700 dark:text-red-300' : 'text-green-700 dark:text-green-300' }}">
                                    {{ $transaksi->sisa_pembayaran > 0 ? 'Sisa Tagihan' : 'Status' }}
                                </span>
                                <span
                                    class="text-xl font-bold {{ $transaksi->sisa_pembayaran > 0 ? 'text-red-800 dark:text-red-200' : 'text-green-800 dark:text-green-200' }}">
                                    {{ $transaksi->sisa_pembayaran > 0 ? 'Rp ' . number_format($transaksi->sisa_pembayaran, 0, ',', '.') : '✅ LUNAS' }}
                                </span>
                            </div>
                        </div>
                    </div>

                    @if ($transaksi->sisa_pembayaran > 0)
                        <div
                            class="mt-4 p-3 bg-yellow-100 dark:bg-yellow-900/30 rounded-lg border border-yellow-200 dark:border-yellow-800 shadow-sm">
                            <div class="flex items-center gap-2">
                                <iconify-icon icon="solar:danger-triangle-bold"
                                    class="text-yellow-600 dark:text-yellow-400"></iconify-icon>
                                <p class="text-sm text-yellow-800 dark:text-yellow-200 font-medium">
                                    Perhatian: Masih ada sisa tagihan
                                </p>
                            </div>
                        </div>
                    @endif
                </div>

                <!-- Quick Actions -->
                <div
                    class="bg-white dark:bg-gray-800 rounded-xl border border-gray-200 dark:border-gray-700 shadow-sm p-6">
                    <div class="flex items-center gap-3 mb-4">
                        <div
                            class="w-8 h-8 bg-purple-100 dark:bg-purple-900/50 rounded-lg flex items-center justify-center shadow-sm">
                            <iconify-icon icon="solar:lightning-bold"
                                class="text-purple-600 dark:text-purple-400"></iconify-icon>
                        </div>
                        <h3 class="font-semibold text-gray-900 dark:text-white">Aksi Cepat</h3>
                    </div>

                    <div class="space-y-3">
                        <a href="{{ route('admin.transaksi.show', $transaksi->id) }}"
                            class="flex items-center gap-3 w-full p-3 bg-blue-50 hover:bg-blue-100 dark:bg-blue-900/30 dark:hover:bg-blue-900/50 rounded-lg transition-colors shadow-sm">
                            <iconify-icon icon="solar:eye-bold" class="text-blue-600 dark:text-blue-400"></iconify-icon>
                            <span class="text-sm font-medium text-blue-700 dark:text-blue-300">Detail Transaksi</span>
                        </a>

                        <a href="{{ route('admin.transaksi.edit', $transaksi->id) }}"
                            class="flex items-center gap-3 w-full p-3 bg-orange-50 hover:bg-orange-100 dark:bg-orange-900/30 dark:hover:bg-orange-900/50 rounded-lg transition-colors shadow-sm">
                            <iconify-icon icon="solar:pen-bold"
                                class="text-orange-600 dark:text-orange-400"></iconify-icon>
                            <span class="text-sm font-medium text-orange-700 dark:text-orange-300">Edit Transaksi</span>
                        </a>

                        @if ($transaksi->status === 'selesai')
                            <div
                                class="flex items-center gap-3 w-full p-3 bg-green-50 dark:bg-green-900/30 rounded-lg shadow-sm">
                                <iconify-icon icon="solar:verified-check-bold"
                                    class="text-green-600 dark:text-green-400"></iconify-icon>
                                <span class="text-sm font-medium text-green-700 dark:text-green-300">Transaksi
                                    Selesai</span>
                            </div>
                        @endif
                    </div>
                </div>

                <!-- Tips & Information -->
                <div
                    class="bg-gradient-to-br from-indigo-50 to-purple-50 dark:from-indigo-900/20 dark:to-purple-900/20 rounded-xl border border-indigo-200 dark:border-indigo-800 p-6">
                    <div class="flex items-center gap-3 mb-4">
                        <div
                            class="w-8 h-8 bg-indigo-500 dark:bg-indigo-600 rounded-lg flex items-center justify-center shadow-md">
                            <iconify-icon icon="solar:info-circle-bold" class="text-white"></iconify-icon>
                        </div>
                        <h3 class="font-semibold text-gray-900 dark:text-white">Tips & Panduan</h3>
                    </div>

                    <div class="space-y-3 text-sm">
                        <div class="flex items-start gap-3 p-3 bg-white/60 dark:bg-gray-800/60 rounded-lg shadow-sm">
                            <iconify-icon icon="solar:gallery-bold"
                                class="text-indigo-600 dark:text-indigo-400 mt-0.5 flex-shrink-0"></iconify-icon>
                            <div>
                                <p class="font-medium text-indigo-800 dark:text-indigo-200 mb-1">Bukti Pembayaran</p>
                                <p class="text-indigo-700 dark:text-indigo-300">Selalu minta dan upload bukti pembayaran
                                    untuk dokumentasi</p>
                            </div>
                        </div>

                        <div class="flex items-start gap-3 p-3 bg-white/60 dark:bg-gray-800/60 rounded-lg shadow-sm">
                            <iconify-icon icon="solar:shield-check-bold"
                                class="text-indigo-600 dark:text-indigo-400 mt-0.5 flex-shrink-0"></iconify-icon>
                            <div>
                                <p class="font-medium text-indigo-800 dark:text-indigo-200 mb-1">Verifikasi</p>
                                <p class="text-indigo-700 dark:text-indigo-300">Konfirmasi pembayaran setelah melakukan
                                    verifikasi</p>
                            </div>
                        </div>

                        <div class="flex items-start gap-3 p-3 bg-white/60 dark:bg-gray-800/60 rounded-lg shadow-sm">
                            <iconify-icon icon="solar:refresh-bold"
                                class="text-indigo-600 dark:text-indigo-400 mt-0.5 flex-shrink-0"></iconify-icon>
                            <div>
                                <p class="font-medium text-indigo-800 dark:text-indigo-200 mb-1">Status Update</p>
                                <p class="text-indigo-700 dark:text-indigo-300">Update status transaksi setelah pelunasan
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        function quickPayFull() {
            document.querySelector('input[name="jumlah"]').value = {{ $transaksi->sisa_pembayaran }};
            document.querySelector('select[name="metode_pembayaran"]').value = 'cash';
            document.querySelector('select[name="status"]').value = 'terkonfirmasi';
            document.querySelector('textarea[name="keterangan"]').value = 'Pelunasan pembayaran';
        }

        function quickPayHalf() {
            document.querySelector('input[name="jumlah"]').value = {{ round($transaksi->sisa_pembayaran / 2) }};
            document.querySelector('select[name="metode_pembayaran"]').value = 'cash';
            document.querySelector('select[name="status"]').value = 'terkonfirmasi';
            document.querySelector('textarea[name="keterangan"]').value = 'Pembayaran 50%';
        }
    </script>
@endsection
