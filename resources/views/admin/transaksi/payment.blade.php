@extends('layouts.admin')

@section('title', 'Kelola Pembayaran')
@section('page-title', 'Kelola Pembayaran')
@section('page-subtitle', 'Manajemen pembayaran transaksi rental')

@section('content')
    <div class="max-w-7xl mx-auto">
        <!-- Back Button -->
        <div class="mb-4">
            <a href="{{ route('admin.transaksi.show', $transaksi->id) }}"
                class="inline-flex items-center text-sm text-gray-600 hover:text-gray-900 transition-colors">
                <iconify-icon icon="solar:arrow-left-outline" class="mr-2"></iconify-icon>
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
        <div class="bg-gradient-to-r from-blue-600 to-purple-600 rounded-xl p-6 mb-8 text-white">
            <div class="flex flex-col md:flex-row md:items-center md:justify-between">
                <div>
                    <h1 class="text-2xl font-bold mb-2">💳 Kelola Pembayaran</h1>
                    <div class="flex flex-wrap gap-4 text-sm">
                        <span class="flex items-center gap-2 bg-white/20 px-3 py-1 rounded-full">
                            <iconify-icon icon="solar:document-text-outline"></iconify-icon>
                            {{ $transaksi->no_transaksi }}
                        </span>
                        <span class="flex items-center gap-2 bg-white/20 px-3 py-1 rounded-full">
                            <iconify-icon icon="solar:user-outline"></iconify-icon>
                            {{ $transaksi->pelanggan->nama }}
                        </span>
                    </div>
                </div>
                @if ($transaksi->sisa_pembayaran <= 0)
                    <div class="mt-4 md:mt-0">
                        <div class="inline-flex items-center gap-2 bg-green-500 px-4 py-2 rounded-full text-sm font-medium">
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
                    <div class="bg-white rounded-xl border border-gray-200 shadow-sm p-6">
                        <div class="flex items-center gap-3 mb-6">
                            <div
                                class="w-10 h-10 bg-gradient-to-r from-emerald-500 to-teal-500 rounded-xl flex items-center justify-center">
                                <iconify-icon icon="solar:card-send-bold" class="text-white text-xl"></iconify-icon>
                            </div>
                            <div>
                                <h2 class="text-xl font-bold text-gray-900">💵 Tambah Pembayaran Baru</h2>
                                <p class="text-sm text-gray-500">Catat pembayaran dari pelanggan</p>
                            </div>
                        </div>

                        <form action="{{ route('admin.pembayaran.store') }}" method="POST" enctype="multipart/form-data"
                            class="space-y-6">
                            @csrf
                            <input type="hidden" name="transaksi_id" value="{{ $transaksi->id }}">

                            <!-- Payment Amount & Method -->
                            <div class="grid md:grid-cols-2 gap-6">
                                <div class="space-y-2">
                                    <label class="flex items-center text-sm font-medium text-gray-700 mb-3">
                                        <iconify-icon icon="solar:dollar-minimalistic-outline"
                                            class="mr-2 text-emerald-600"></iconify-icon>
                                        Jumlah Pembayaran *
                                    </label>
                                    <input type="number" name="jumlah" required min="1"
                                        max="{{ $transaksi->sisa_pembayaran }}"
                                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:border-transparent transition-all duration-200"
                                        placeholder="Masukkan jumlah">
                                    <div class="flex justify-between text-xs">
                                        <span class="text-gray-500">Min: Rp 1</span>
                                        <span class="text-emerald-600 font-medium">Maks: Rp
                                            {{ number_format($transaksi->sisa_pembayaran, 0, ',', '.') }}</span>
                                    </div>
                                </div>

                                <div class="space-y-2">
                                    <label class="flex items-center text-sm font-medium text-gray-700 mb-3">
                                        <iconify-icon icon="solar:wallet-outline" class="mr-2 text-blue-600"></iconify-icon>
                                        Metode Pembayaran *
                                    </label>
                                    <select name="metode" required
                                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all duration-200">
                                        <option value="">-- Pilih Metode --</option>
                                        <option value="cash">💵 Cash / Tunai</option>
                                        <option value="transfer">🏦 Transfer Bank</option>
                                        <option value="debit">💳 Kartu Debit</option>
                                        <option value="kredit">💎 Kartu Kredit</option>
                                        <option value="ewallet">📱 E-Wallet</option>
                                    </select>
                                </div>
                            </div>

                            <!-- Date & Status -->
                            <div class="grid md:grid-cols-2 gap-6">
                                <div class="space-y-2">
                                    <label class="flex items-center text-sm font-medium text-gray-700 mb-3">
                                        <iconify-icon icon="solar:calendar-outline"
                                            class="mr-2 text-purple-600"></iconify-icon>
                                        Tanggal & Waktu *
                                    </label>
                                    <input type="datetime-local" name="tanggal_bayar" required
                                        value="{{ now()->format('Y-m-d\TH:i') }}"
                                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-purple-500 focus:border-transparent transition-all duration-200">
                                </div>

                                <div class="space-y-2">
                                    <label class="flex items-center text-sm font-medium text-gray-700 mb-3">
                                        <iconify-icon icon="solar:shield-check-outline"
                                            class="mr-2 text-orange-600"></iconify-icon>
                                        Status Pembayaran *
                                    </label>
                                    <select name="status" required
                                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-orange-500 focus:border-transparent transition-all duration-200">
                                        <option value="terkonfirmasi">✅ Terkonfirmasi</option>
                                        <option value="pending">⏳ Pending Konfirmasi</option>
                                    </select>
                                </div>
                            </div>

                            <!-- Description -->
                            <div class="space-y-2">
                                <label class="flex items-center text-sm font-medium text-gray-700 mb-3">
                                    <iconify-icon icon="solar:notes-outline" class="mr-2 text-gray-600"></iconify-icon>
                                    Keterangan (Opsional)
                                </label>
                                <textarea name="keterangan" rows="3"
                                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-gray-400 focus:border-transparent transition-all duration-200 resize-none"
                                    placeholder="Catatan tambahan untuk pembayaran ini..."></textarea>
                            </div>

                            <!-- Payment Proof -->
                            <div class="space-y-2">
                                <label class="flex items-center text-sm font-medium text-gray-700 mb-3">
                                    <iconify-icon icon="solar:gallery-outline" class="mr-2 text-indigo-600"></iconify-icon>
                                    Bukti Pembayaran
                                </label>
                                <div
                                    class="border-2 border-dashed border-gray-300 rounded-lg p-6 hover:border-indigo-400 transition-colors">
                                    <input type="file" name="bukti_pembayaran" accept="image/*,.pdf"
                                        class="w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-medium file:bg-indigo-50 file:text-indigo-700 hover:file:bg-indigo-100">
                                    <p class="text-xs text-gray-500 mt-2">📄 Format: JPG, PNG, PDF • Maksimal 2MB</p>
                                </div>
                            </div>
                            <!-- Quick Payment Actions -->
                            <div class="bg-gradient-to-r from-gray-50 to-blue-50 rounded-lg p-4 border border-blue-100">
                                <div class="flex items-center gap-2 mb-3">
                                    <iconify-icon icon="solar:lightning-outline" class="text-blue-600"></iconify-icon>
                                    <span class="text-sm font-medium text-gray-700">Aksi Cepat</span>
                                </div>
                                <div class="flex flex-wrap gap-2">
                                    <button type="button" onclick="quickPayFull()"
                                        class="flex-1 min-w-0 bg-emerald-500 hover:bg-emerald-600 text-white px-3 py-2 rounded-lg text-sm font-medium transition-colors">
                                        💰 Bayar Lunas
                                    </button>
                                    <button type="button" onclick="quickPayHalf()"
                                        class="flex-1 min-w-0 bg-blue-500 hover:bg-blue-600 text-white px-3 py-2 rounded-lg text-sm font-medium transition-colors">
                                        🎯 Bayar 50%
                                    </button>
                                </div>
                            </div>

                            <!-- Submit Button -->
                            <div class="flex flex-col sm:flex-row gap-4 justify-end pt-4 border-t border-gray-200">
                                <button type="reset"
                                    class="inline-flex items-center justify-center px-6 py-3 border border-gray-300 rounded-lg text-gray-700 bg-white hover:bg-gray-50 transition-colors font-medium">
                                    <iconify-icon icon="solar:restart-outline" class="mr-2"></iconify-icon>
                                    Reset
                                </button>
                                <button type="submit"
                                    class="inline-flex items-center justify-center px-8 py-3 bg-gradient-to-r from-emerald-600 to-teal-600 hover:from-emerald-700 hover:to-teal-700 text-white rounded-lg transition-all duration-200 font-medium shadow-lg hover:shadow-xl">
                                    <iconify-icon icon="solar:card-send-outline" class="mr-2"></iconify-icon>
                                    Simpan Pembayaran
                                </button>
                            </div>
                        </form>
                    </div>
                @else
                    <div class="bg-white rounded-xl border border-gray-200 shadow-sm p-6">
                        <div class="text-center py-8">
                            <div class="w-16 h-16 bg-green-100 rounded-full flex items-center justify-center mx-auto mb-4">
                                <iconify-icon icon="solar:verified-check-bold"
                                    class="text-green-600 text-2xl"></iconify-icon>
                            </div>
                            <h3 class="text-lg font-semibold text-gray-900 mb-2">Transaksi Sudah Lunas! 🎉</h3>
                            <p class="text-gray-500 mb-4">Semua pembayaran telah diterima dengan lengkap.</p>
                            <a href="{{ route('admin.transaksi.show', $transaksi->id) }}"
                                class="inline-flex items-center gap-2 bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg transition-colors">
                                <iconify-icon icon="solar:eye-outline"></iconify-icon>
                                Lihat Detail Transaksi
                            </a>
                        </div>
                    </div>
                @endif

                <!-- Payment History -->
                <div class="bg-white rounded-xl border border-gray-200 shadow-sm p-6">
                    <div class="flex items-center gap-3 mb-6">
                        <div
                            class="w-10 h-10 bg-gradient-to-r from-blue-500 to-purple-500 rounded-xl flex items-center justify-center">
                            <iconify-icon icon="solar:history-bold" class="text-white text-xl"></iconify-icon>
                        </div>
                        <div>
                            <h2 class="text-xl font-bold text-gray-900">📋 Riwayat Pembayaran</h2>
                            <p class="text-sm text-gray-500">{{ $transaksi->pembayaran->count() }} pembayaran tercatat</p>
                        </div>
                    </div>

                    @if ($transaksi->pembayaran->count() > 0)
                        <div class="space-y-4">
                            @foreach ($transaksi->pembayaran as $index => $bayar)
                                <div
                                    class="bg-gradient-to-r from-gray-50 to-blue-50 border border-gray-200 rounded-lg p-4 hover:shadow-md transition-all duration-200">
                                    <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
                                        <!-- Payment Info -->
                                        <div class="flex-1">
                                            <div class="flex items-center gap-3 mb-2">
                                                <div
                                                    class="flex-shrink-0 w-8 h-8 bg-blue-100 rounded-full flex items-center justify-center">
                                                    <span
                                                        class="text-sm font-bold text-blue-600">#{{ $index + 1 }}</span>
                                                </div>
                                                <div>
                                                    <h4 class="font-semibold text-gray-900">
                                                        Rp {{ number_format($bayar->jumlah, 0, ',', '.') }}
                                                    </h4>
                                                    <p class="text-sm text-gray-500">
                                                        {{ $bayar->tanggal_bayar ? Carbon\Carbon::parse($bayar->tanggal_bayar)->format('d/m/Y H:i') : $bayar->created_at->format('d/m/Y H:i') }}
                                                    </p>
                                                </div>
                                            </div>

                                            <div class="flex flex-wrap gap-2 mb-3">
                                                <!-- Payment Method -->
                                                <span
                                                    class="inline-flex items-center gap-1 px-3 py-1 bg-white rounded-full text-xs font-medium text-gray-700 border border-gray-200">
                                                    @if ($bayar->metode_pembayaran == 'cash')
                                                        💵
                                                    @elseif($bayar->metode_pembayaran == 'transfer')
                                                        🏦
                                                    @elseif($bayar->metode_pembayaran == 'debit')
                                                        💳
                                                    @elseif($bayar->metode_pembayaran == 'kredit')
                                                        💎
                                                    @elseif($bayar->metode_pembayaran == 'ewallet')
                                                        📱
                                                    @endif
                                                    {{ ucfirst($bayar->metode_pembayaran) }}
                                                </span>

                                                <!-- Status Badge -->
                                                <span
                                                    class="inline-flex items-center gap-1 px-3 py-1 rounded-full text-xs font-medium
                                                    {{ $bayar->status == 'terkonfirmasi' ? 'bg-green-100 text-green-800' : 'bg-yellow-100 text-yellow-800' }}">
                                                    @if ($bayar->status == 'terkonfirmasi')
                                                        ✅
                                                    @else
                                                        ⏳
                                                    @endif
                                                    {{ ucfirst($bayar->status) }}
                                                </span>
                                            </div>

                                            @if ($bayar->keterangan)
                                                <p class="text-sm text-gray-600 italic">{{ $bayar->keterangan }}</p>
                                            @endif
                                        </div>

                                        <!-- Actions -->
                                        <div class="flex flex-wrap gap-2">
                                            @if ($bayar->bukti_pembayaran)
                                                <a href="{{ asset('storage/' . $bayar->bukti_pembayaran) }}"
                                                    target="_blank"
                                                    class="inline-flex items-center gap-2 px-3 py-2 bg-blue-100 hover:bg-blue-200 text-blue-700 rounded-lg text-sm font-medium transition-colors">
                                                    <iconify-icon icon="solar:eye-outline" class="text-sm"></iconify-icon>
                                                    Bukti
                                                </a>
                                            @endif

                                            @if ($bayar->status == 'pending')
                                                <form action="{{ route('admin.pembayaran.confirm', $bayar->id) }}"
                                                    method="POST" class="inline">
                                                    @csrf
                                                    @method('PATCH')
                                                    <button type="submit"
                                                        class="inline-flex items-center gap-2 px-3 py-2 bg-green-100 hover:bg-green-200 text-green-700 rounded-lg text-sm font-medium transition-colors"
                                                        onclick="return confirm('Konfirmasi pembayaran ini?')">
                                                        <iconify-icon icon="solar:check-circle-outline"
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
                                                    class="inline-flex items-center gap-2 px-3 py-2 bg-red-100 hover:bg-red-200 text-red-700 rounded-lg text-sm font-medium transition-colors"
                                                    onclick="return confirm('Yakin ingin menghapus pembayaran ini?')">
                                                    <iconify-icon icon="solar:trash-bin-minimalistic-outline"
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
                            <div class="w-16 h-16 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-4">
                                <iconify-icon icon="solar:card-outline" class="text-gray-400 text-2xl"></iconify-icon>
                            </div>
                            <h3 class="text-lg font-medium text-gray-900 mb-2">Belum Ada Pembayaran</h3>
                            <p class="text-gray-500">Transaksi ini belum memiliki riwayat pembayaran</p>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Sidebar -->
            <div class="space-y-6">
                <!-- Transaction Summary -->
                <div class="bg-white rounded-xl border border-gray-200 shadow-sm p-6">
                    <div class="flex items-center gap-3 mb-4">
                        <div class="w-8 h-8 bg-blue-100 rounded-lg flex items-center justify-center">
                            <iconify-icon icon="solar:document-text-bold" class="text-blue-600"></iconify-icon>
                        </div>
                        <div>
                            <h3 class="font-semibold text-gray-900">Ringkasan Transaksi</h3>
                        </div>
                    </div>

                    <div class="space-y-3">
                        <div class="flex justify-between items-center py-2 border-b border-gray-100">
                            <span class="text-sm text-gray-600">No. Transaksi</span>
                            <span class="text-sm font-medium">{{ $transaksi->no_transaksi }}</span>
                        </div>
                        <div class="flex justify-between items-center py-2 border-b border-gray-100">
                            <span class="text-sm text-gray-600">Pelanggan</span>
                            <span class="text-sm font-medium">{{ $transaksi->pelanggan->nama }}</span>
                        </div>
                        <div class="flex justify-between items-center py-2 border-b border-gray-100">
                            <span class="text-sm text-gray-600">Mobil</span>
                            <span class="text-sm font-medium">{{ $transaksi->mobil->merk }}
                                {{ $transaksi->mobil->model }}</span>
                        </div>
                        <div class="flex justify-between items-center py-2 border-b border-gray-100">
                            <span class="text-sm text-gray-600">Periode</span>
                            <span class="text-sm font-medium">{{ $transaksi->tanggal_sewa->format('d/m/Y') }} -
                                {{ $transaksi->tanggal_kembali->format('d/m/Y') }}</span>
                        </div>
                        <div class="flex justify-between items-center py-2">
                            <span class="text-sm text-gray-600">Status</span>
                            @php
                                $statusConfig = [
                                    'booking' => [
                                        'bg' => 'bg-yellow-100',
                                        'text' => 'text-yellow-800',
                                        'label' => 'Booking',
                                    ],
                                    'aktif' => ['bg' => 'bg-green-100', 'text' => 'text-green-800', 'label' => 'Aktif'],
                                    'selesai' => [
                                        'bg' => 'bg-blue-100',
                                        'text' => 'text-blue-800',
                                        'label' => 'Selesai',
                                    ],
                                    'batal' => ['bg' => 'bg-red-100', 'text' => 'text-red-800', 'label' => 'Batal'],
                                ];
                                $status = $statusConfig[$transaksi->status] ?? $statusConfig['booking'];
                            @endphp
                            <span
                                class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium {{ $status['bg'] }} {{ $status['text'] }}">
                                {{ $status['label'] }}
                            </span>
                        </div>
                    </div>
                </div>

                <!-- Financial Summary -->
                <div
                    class="bg-gradient-to-br from-emerald-50 to-teal-50 rounded-xl border border-emerald-200 shadow-sm p-6">
                    <div class="flex items-center gap-3 mb-4">
                        <div class="w-8 h-8 bg-emerald-500 rounded-lg flex items-center justify-center">
                            <iconify-icon icon="solar:dollar-minimalistic-bold" class="text-white"></iconify-icon>
                        </div>
                        <div>
                            <h3 class="font-semibold text-gray-900">💰 Ringkasan Keuangan</h3>
                        </div>
                    </div>

                    <div class="space-y-4">
                        <div class="bg-white/60 rounded-lg p-4">
                            <div class="flex justify-between items-center">
                                <span class="text-sm text-emerald-700">Total Tagihan</span>
                                <span class="text-lg font-bold text-emerald-800">Rp
                                    {{ number_format($transaksi->total, 0, ',', '.') }}</span>
                            </div>
                        </div>

                        <div class="bg-white/60 rounded-lg p-4">
                            <div class="flex justify-between items-center">
                                <span class="text-sm text-blue-700">Total Terbayar</span>
                                <span class="text-lg font-bold text-blue-800">Rp
                                    {{ number_format($transaksi->total_pembayaran, 0, ',', '.') }}</span>
                            </div>
                        </div>

                        <div
                            class="bg-white rounded-lg p-4 border-2 {{ $transaksi->sisa_pembayaran > 0 ? 'border-red-200' : 'border-green-200' }}">
                            <div class="flex justify-between items-center">
                                <span
                                    class="text-sm font-medium {{ $transaksi->sisa_pembayaran > 0 ? 'text-red-700' : 'text-green-700' }}">
                                    {{ $transaksi->sisa_pembayaran > 0 ? 'Sisa Tagihan' : 'Status' }}
                                </span>
                                <span
                                    class="text-xl font-bold {{ $transaksi->sisa_pembayaran > 0 ? 'text-red-800' : 'text-green-800' }}">
                                    {{ $transaksi->sisa_pembayaran > 0 ? 'Rp ' . number_format($transaksi->sisa_pembayaran, 0, ',', '.') : '✅ LUNAS' }}
                                </span>
                            </div>
                        </div>
                    </div>

                    @if ($transaksi->sisa_pembayaran > 0)
                        <div class="mt-4 p-3 bg-yellow-100 rounded-lg border border-yellow-200">
                            <div class="flex items-center gap-2">
                                <iconify-icon icon="solar:danger-triangle-outline" class="text-yellow-600"></iconify-icon>
                                <p class="text-sm text-yellow-800 font-medium">
                                    Perhatian: Masih ada sisa tagihan
                                </p>
                            </div>
                        </div>
                    @endif
                </div>

                <!-- Quick Actions -->
                <div class="bg-white rounded-xl border border-gray-200 shadow-sm p-6">
                    <div class="flex items-center gap-3 mb-4">
                        <div class="w-8 h-8 bg-purple-100 rounded-lg flex items-center justify-center">
                            <iconify-icon icon="solar:lightning-bold" class="text-purple-600"></iconify-icon>
                        </div>
                        <h3 class="font-semibold text-gray-900">Aksi Cepat</h3>
                    </div>

                    <div class="space-y-3">
                        <a href="{{ route('admin.transaksi.show', $transaksi->id) }}"
                            class="flex items-center gap-3 w-full p-3 bg-blue-50 hover:bg-blue-100 rounded-lg transition-colors">
                            <iconify-icon icon="solar:eye-outline" class="text-blue-600"></iconify-icon>
                            <span class="text-sm font-medium text-blue-700">Detail Transaksi</span>
                        </a>

                        <a href="{{ route('admin.transaksi.edit', $transaksi->id) }}"
                            class="flex items-center gap-3 w-full p-3 bg-orange-50 hover:bg-orange-100 rounded-lg transition-colors">
                            <iconify-icon icon="solar:pen-outline" class="text-orange-600"></iconify-icon>
                            <span class="text-sm font-medium text-orange-700">Edit Transaksi</span>
                        </a>

                        @if ($transaksi->status === 'selesai')
                            <div class="flex items-center gap-3 w-full p-3 bg-green-50 rounded-lg">
                                <iconify-icon icon="solar:verified-check-outline" class="text-green-600"></iconify-icon>
                                <span class="text-sm font-medium text-green-700">Transaksi Selesai</span>
                            </div>
                        @endif
                    </div>
                </div>

                <!-- Tips & Information -->
                <div class="bg-gradient-to-br from-indigo-50 to-purple-50 rounded-xl border border-indigo-200 p-6">
                    <div class="flex items-center gap-3 mb-4">
                        <div class="w-8 h-8 bg-indigo-500 rounded-lg flex items-center justify-center">
                            <iconify-icon icon="solar:info-circle-bold" class="text-white"></iconify-icon>
                        </div>
                        <h3 class="font-semibold text-gray-900">💡 Tips & Panduan</h3>
                    </div>

                    <div class="space-y-3 text-sm">
                        <div class="flex items-start gap-3 p-3 bg-white/60 rounded-lg">
                            <iconify-icon icon="solar:gallery-outline"
                                class="text-indigo-600 mt-0.5 flex-shrink-0"></iconify-icon>
                            <div>
                                <p class="font-medium text-indigo-800 mb-1">Bukti Pembayaran</p>
                                <p class="text-indigo-700">Selalu minta dan upload bukti pembayaran untuk dokumentasi</p>
                            </div>
                        </div>

                        <div class="flex items-start gap-3 p-3 bg-white/60 rounded-lg">
                            <iconify-icon icon="solar:shield-check-outline"
                                class="text-indigo-600 mt-0.5 flex-shrink-0"></iconify-icon>
                            <div>
                                <p class="font-medium text-indigo-800 mb-1">Verifikasi</p>
                                <p class="text-indigo-700">Konfirmasi pembayaran setelah melakukan verifikasi</p>
                            </div>
                        </div>

                        <div class="flex items-start gap-3 p-3 bg-white/60 rounded-lg">
                            <iconify-icon icon="solar:refresh-outline"
                                class="text-indigo-600 mt-0.5 flex-shrink-0"></iconify-icon>
                            <div>
                                <p class="font-medium text-indigo-800 mb-1">Status Update</p>
                                <p class="text-indigo-700">Update status transaksi setelah pelunasan</p>
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
