@extends('layouts.admin')

@section('title', 'Edit Pembayaran')
@section('page-title', 'Edit Pembayaran')
@section('page-subtitle', 'Edit data pembayaran transaksi')

@section('content')
    <div class="max-w-4xl mx-auto">
        <form action="{{ route('admin.pembayaran.update', $pembayaran->id) }}" method="POST" enctype="multipart/form-data"
            class="space-y-6">
            @csrf
            @method('PUT')

            <!-- Info Transaksi -->
            <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-sm border border-gray-100 dark:border-gray-700 p-6">
                <div class="flex items-center mb-6">
                    <div class="flex-shrink-0">
                        <div
                            class="w-10 h-10 bg-gradient-to-r from-blue-500 to-purple-600 rounded-lg flex items-center justify-center">
                            <iconify-icon icon="heroicons:document-text-20-solid" class="w-5 h-5 text-white"></iconify-icon>
                        </div>
                    </div>
                    <div class="ml-4">
                        <h3 class="text-lg font-semibold text-gray-900 dark:text-white">Info Transaksi</h3>
                        <p class="text-sm text-gray-600 dark:text-gray-400">Detail transaksi terkait pembayaran</p>
                    </div>
                </div>

                <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                    <!-- Info Transaksi -->
                    <div class="space-y-4">
                        <div class="p-4 bg-gray-50 dark:bg-gray-700 rounded-xl border border-gray-200 dark:border-gray-600">
                            <h4 class="font-medium text-gray-900 dark:text-white mb-3">Detail Transaksi</h4>
                            <div class="space-y-2 text-sm">
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
                                    <span class="text-gray-600 dark:text-gray-400">Mobil:</span>
                                    <span
                                        class="font-medium text-gray-900 dark:text-white">{{ $pembayaran->transaksi->mobil->merk }}
                                        {{ $pembayaran->transaksi->mobil->model }}</span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Status Pembayaran -->
                    <div class="space-y-4">
                        <div
                            class="p-4 bg-blue-50 dark:bg-blue-900/20 rounded-xl border border-blue-200 dark:border-blue-800">
                            <h4 class="font-medium text-gray-900 dark:text-white mb-3">Status Pembayaran</h4>
                            <div class="space-y-2 text-sm">
                                <div class="flex justify-between">
                                    <span class="text-gray-600 dark:text-gray-400">Total Tagihan:</span>
                                    <span class="font-bold text-gray-900 dark:text-white">Rp
                                        {{ number_format($pembayaran->transaksi->total, 0, ',', '.') }}</span>
                                </div>
                                <div class="flex justify-between">
                                    <span class="text-gray-600 dark:text-gray-400">Sudah Dibayar:</span>
                                    <span class="font-medium text-green-600 dark:text-green-400">Rp
                                        {{ number_format($pembayaran->transaksi->total_pembayaran, 0, ',', '.') }}</span>
                                </div>
                                <div class="flex justify-between border-t border-blue-200 dark:border-blue-700 pt-2">
                                    <span class="text-gray-600 dark:text-gray-400">Sisa Tagihan:</span>
                                    <span class="font-bold text-red-600 dark:text-red-400">Rp
                                        {{ number_format($pembayaran->transaksi->sisa_pembayaran, 0, ',', '.') }}</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Form Edit Pembayaran -->
            <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-sm border border-gray-100 dark:border-gray-700 p-6">
                <div class="flex items-center mb-6">
                    <div class="flex-shrink-0">
                        <div
                            class="w-10 h-10 bg-gradient-to-r from-green-500 to-blue-600 rounded-lg flex items-center justify-center">
                            <iconify-icon icon="heroicons:credit-card-20-solid" class="w-5 h-5 text-white"></iconify-icon>
                        </div>
                    </div>
                    <div class="ml-4">
                        <h3 class="text-lg font-semibold text-gray-900 dark:text-white">Edit Pembayaran</h3>
                        <p class="text-sm text-gray-600 dark:text-gray-400">Ubah detail pembayaran</p>
                    </div>
                </div>

                <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                    <!-- Jumlah Pembayaran -->
                    <div>
                        <label for="jumlah" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                            Jumlah Pembayaran *
                        </label>
                        <div class="relative">
                            <div
                                class="absolute left-4 top-1/2 -translate-y-1/2 text-gray-500 dark:text-gray-400 pointer-events-none">
                                Rp
                            </div>
                            <input type="text" name="jumlah" id="jumlah"
                                value="{{ old('jumlah') ? old('jumlah') : number_format($pembayaran->jumlah, 0, ',', '.') }}"
                                data-max="{{ $pembayaran->transaksi->sisa_pembayaran }}" placeholder="0" required
                                class="w-full pl-12 pr-4 py-2 border border-gray-200 dark:border-gray-600 rounded-xl focus:ring-2 focus:ring-indigo-500 dark:focus:ring-indigo-400 bg-white dark:bg-gray-700 text-gray-900 dark:text-white">
                        </div>

                        <!-- Quick Action Buttons -->
                        <div class="mt-2 flex flex-wrap gap-2" x-data="paymentInput()">
                            <button type="button" @click="setPercentage(25)"
                                class="quick-payment-btn px-3 py-1 text-xs font-medium bg-blue-50 dark:bg-blue-900/20 text-blue-700 dark:text-blue-300 rounded-lg hover:bg-blue-100 dark:hover:bg-blue-900/40 transition-colors">
                                25%
                            </button>
                            <button type="button" @click="setPercentage(50)"
                                class="quick-payment-btn px-3 py-1 text-xs font-medium bg-indigo-50 dark:bg-indigo-900/20 text-indigo-700 dark:text-indigo-300 rounded-lg hover:bg-indigo-100 dark:hover:bg-indigo-900/40 transition-colors">
                                50%
                            </button>
                            <button type="button" @click="setPercentage(75)"
                                class="quick-payment-btn px-3 py-1 text-xs font-medium bg-purple-50 dark:bg-purple-900/20 text-purple-700 dark:text-purple-300 rounded-lg hover:bg-purple-100 dark:hover:bg-purple-900/40 transition-colors">
                                75%
                            </button>
                            <button type="button" @click="setPercentage(100)"
                                class="quick-payment-btn px-3 py-1 text-xs font-medium bg-green-50 dark:bg-green-900/20 text-green-700 dark:text-green-300 rounded-lg hover:bg-green-100 dark:hover:bg-green-900/40 transition-colors border border-green-200 dark:border-green-800">
                                <iconify-icon icon="heroicons:check-circle-solid"
                                    class="inline text-sm mr-1"></iconify-icon>
                                Lunas
                            </button>
                            <button type="button" @click="clearAmount()"
                                class="px-3 py-1 text-xs font-medium bg-gray-50 dark:bg-gray-700 text-gray-700 dark:text-gray-300 rounded-lg hover:bg-gray-100 dark:hover:bg-gray-600 transition-colors">
                                <iconify-icon icon="heroicons:x-mark-solid" class="inline text-sm"></iconify-icon>
                                Reset
                            </button>
                        </div>

                        @error('jumlah')
                            <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                        @enderror
                        <p class="mt-1 text-xs text-gray-500 dark:text-gray-400">
                            Maksimal: Rp
                            {{ number_format($pembayaran->transaksi->sisa_pembayaran, 0, ',', '.') }}
                        </p>
                    </div>

                    <!-- Metode Pembayaran -->
                    <div>
                        <label for="metode" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                            Metode Pembayaran *
                        </label>
                        <select name="metode" id="metode" required
                            class="w-full px-4 py-2 border border-gray-200 dark:border-gray-600 rounded-xl focus:ring-2 focus:ring-indigo-500 dark:focus:ring-indigo-400 bg-white dark:bg-gray-700 text-gray-900 dark:text-white">
                            <option value="">Pilih metode pembayaran</option>
                            <option value="tunai" {{ old('metode', $pembayaran->metode) === 'tunai' ? 'selected' : '' }}>
                                Tunai</option>
                            <option value="transfer"
                                {{ old('metode', $pembayaran->metode) === 'transfer' ? 'selected' : '' }}>Transfer Bank
                            </option>
                            <option value="qris" {{ old('metode', $pembayaran->metode) === 'qris' ? 'selected' : '' }}>
                                QRIS</option>
                            <option value="kartu" {{ old('metode', $pembayaran->metode) === 'kartu' ? 'selected' : '' }}>
                                Kartu Debit/Kredit</option>
                            <option value="ewallet"
                                {{ old('metode', $pembayaran->metode) === 'ewallet' ? 'selected' : '' }}>E-Wallet</option>
                        </select>
                        @error('metode')
                            <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Status Pembayaran -->
                    <div>
                        <label for="status" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                            Status Pembayaran *
                        </label>
                        <select name="status" id="status" required
                            class="w-full px-4 py-2 border border-gray-200 dark:border-gray-600 rounded-xl focus:ring-2 focus:ring-indigo-500 dark:focus:ring-indigo-400 bg-white dark:bg-gray-700 text-gray-900 dark:text-white">
                            <option value="pending"
                                {{ old('status', $pembayaran->status) === 'pending' ? 'selected' : '' }}>Pending</option>
                            <option value="terkonfirmasi"
                                {{ old('status', $pembayaran->status) === 'terkonfirmasi' ? 'selected' : '' }}>
                                Terkonfirmasi</option>
                            <option value="gagal" {{ old('status', $pembayaran->status) === 'gagal' ? 'selected' : '' }}>
                                Gagal</option>
                            <option value="refund"
                                {{ old('status', $pembayaran->status) === 'refund' ? 'selected' : '' }}>
                                Refund</option>
                        </select>
                        @error('status')
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
                            value="{{ old('tanggal_bayar', $pembayaran->tanggal_bayar ? $pembayaran->tanggal_bayar->format('Y-m-d\TH:i') : '') }}"
                            required
                            class="w-full px-4 py-2 border border-gray-200 dark:border-gray-600 rounded-xl focus:ring-2 focus:ring-indigo-500 dark:focus:ring-indigo-400 bg-white dark:bg-gray-700 text-gray-900 dark:text-white">
                        @error('tanggal_bayar')
                            <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Bukti Pembayaran Saat Ini -->
                    @if ($pembayaran->bukti_bayar)
                        <div class="lg:col-span-2">
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                Bukti Pembayaran Saat Ini
                            </label>
                            <div class="flex items-center space-x-4">
                                <img src="{{ asset('storage/' . $pembayaran->bukti_bayar) }}" alt="Bukti Pembayaran"
                                    class="w-32 h-32 object-cover rounded-lg border border-gray-200 dark:border-gray-600">
                                <div class="text-sm text-gray-600 dark:text-gray-400">
                                    <p>File saat ini: {{ basename($pembayaran->bukti_bayar) }}</p>
                                    <p class="mt-1">Upload file baru untuk mengubah bukti pembayaran</p>
                                </div>
                            </div>
                        </div>
                    @endif

                    <!-- Upload Bukti Pembayaran Baru -->
                    <div class="lg:col-span-2">
                        <label for="bukti_bayar" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                            {{ $pembayaran->bukti_bayar ? 'Ubah Bukti Pembayaran' : 'Bukti Pembayaran' }}
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
                            class="w-full px-4 py-2 border border-gray-200 dark:border-gray-600 rounded-xl focus:ring-2 focus:ring-indigo-500 dark:focus:ring-indigo-400 bg-white dark:bg-gray-700 text-gray-900 dark:text-white">{{ old('catatan', $pembayaran->catatan) }}</textarea>
                        @error('catatan')
                            <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
            </div>

            <!-- Action Buttons -->
            <div class="flex flex-col sm:flex-row gap-4 justify-end">
                <a href="{{ route('admin.pembayaran.show', $pembayaran->id) }}"
                    class="px-6 py-2 border border-gray-300 dark:border-gray-600 text-gray-700 dark:text-gray-300 bg-white dark:bg-gray-800 rounded-xl hover:bg-gray-50 dark:hover:bg-gray-700 font-medium transition-colors duration-200 text-center">
                    Batal
                </a>
                <button type="submit"
                    class="px-6 py-2 flex items-center bg-indigo-600 hover:bg-indigo-700 text-white font-medium rounded-xl transition-colors duration-200">
                    <iconify-icon icon="heroicons:check-20-solid" class="w-4 h-4 mr-2 inline"></iconify-icon>
                    Update Pembayaran
                </button>
            </div>
        </form>
    </div>

    @push('scripts')
        <script>
            // Alpine.js Component: Payment Input with Currency Formatting
            function paymentInput() {
                return {
                    rawValue: '',
                    showWarning: false,
                    warningTimeout: null,

                    init() {
                        const input = this.$el.previousElementSibling.querySelector('#jumlah');
                        if (!input) return;

                        // Handle input event
                        input.addEventListener('input', (e) => this.handleInput(e));

                        // Handle blur event
                        input.addEventListener('blur', (e) => this.handleBlur(e));

                        // Handle form submit
                        const form = input.closest('form');
                        if (form) {
                            form.addEventListener('submit', (e) => this.handleSubmit(e, input));
                        }
                    },

                    handleInput(e) {
                        let value = e.target.value.replace(/\D/g, '');

                        if (value) {
                            const numValue = parseInt(value);
                            const maxValue = parseInt(e.target.getAttribute('data-max') || 0);

                            // Validate against max value
                            if (maxValue > 0 && numValue > maxValue) {
                                value = maxValue.toString();
                                this.displayWarning(e.target);
                            }

                            // Format with thousands separator
                            e.target.value = parseInt(value).toLocaleString('id-ID');
                            this.rawValue = value;
                        } else {
                            e.target.value = '';
                            this.rawValue = '';
                        }
                    },

                    handleBlur(e) {
                        let value = e.target.value.replace(/\D/g, '');
                        if (value && value !== '0') {
                            e.target.value = parseInt(value).toLocaleString('id-ID');
                        } else {
                            e.target.value = '';
                        }
                    },

                    handleSubmit(e, input) {
                        const rawValue = input.value.replace(/\D/g, '');
                        input.value = rawValue || '0';
                    },

                    displayWarning(inputElement) {
                        // Clear existing timeout
                        if (this.warningTimeout) {
                            clearTimeout(this.warningTimeout);
                        }

                        // Remove existing warning
                        const existingWarning = inputElement.parentElement.parentElement.querySelector('.max-warning');
                        if (existingWarning) {
                            existingWarning.remove();
                        }

                        // Create new warning
                        const warnEl = document.createElement('p');
                        warnEl.className = 'mt-1 text-xs text-orange-600 dark:text-orange-400 max-warning';
                        warnEl.textContent = 'Jumlah melebihi sisa tagihan, disesuaikan ke maksimal';
                        inputElement.parentElement.parentElement.appendChild(warnEl);

                        // Auto-remove after 3 seconds
                        this.warningTimeout = setTimeout(() => warnEl.remove(), 3000);
                    },

                    setPercentage(percentage) {
                        const input = document.getElementById('jumlah');
                        if (!input) return;

                        const maxValue = parseInt(input.getAttribute('data-max') || 0);
                        if (maxValue === 0) return;

                        // Calculate amount
                        const amount = Math.round(maxValue * (percentage / 100));

                        // Set value and trigger formatting
                        input.value = amount.toString();
                        input.dispatchEvent(new Event('input'));

                        // Visual feedback
                        input.classList.add('ring-2', 'ring-green-500');
                        setTimeout(() => {
                            input.classList.remove('ring-2', 'ring-green-500');
                        }, 500);
                    },

                    clearAmount() {
                        const input = document.getElementById('jumlah');
                        if (input) {
                            input.value = '';
                            this.rawValue = '';
                            input.focus();
                        }
                    }
                }
            }
        </script>
    @endpush
@endsection
