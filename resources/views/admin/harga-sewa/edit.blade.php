@extends('layouts.admin')

@section('title', 'Edit Pricing')
@section('page-title', 'Edit Pricing')
@section('page-subtitle', 'Update rental rates for vehicles')

@section('content')
    <div class="max-w-4xl mx-auto">
        <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-sm border border-gray-100 dark:border-gray-700">
            <!-- Header -->
            <div class="px-6 py-4 border-b border-gray-200 dark:border-gray-700">
                <div class="flex items-center justify-between">
                    <h3 class="text-lg font-semibold text-gray-800 dark:text-white">Edit Pricing Information</h3>
                    <a href="{{ route('admin.harga-sewa.index') }}"
                        class="inline-flex items-center px-4 py-2 bg-gray-500 hover:bg-gray-600 text-white text-sm font-medium rounded-xl transition-colors duration-200">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                        </svg>
                        Kembali
                    </a>
                </div>
            </div>

            <!-- Form -->
            <form action="{{ route('admin.harga-sewa.update', $hargaSewa) }}" method="POST" class="p-6">
                @csrf
                @method('PUT')

                <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
                    <!-- Left Column - Vehicle & Pricing Type -->
                    <div class="space-y-6">
                        <h4
                            class="text-md font-semibold text-gray-800 dark:text-white border-b border-gray-200 dark:border-gray-700 pb-2">
                            Pilih Mobil & Jenis Sewa
                        </h4>

                        <!-- Vehicle Selection -->
                        <div>
                            <label for="mobil_id" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                Pilih Mobil <span class="text-red-500">*</span>
                            </label>
                            <select name="mobil_id" id="mobil_id" required
                                class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-xl focus:ring-2 focus:ring-indigo-500 dark:focus:ring-indigo-400 focus:border-transparent bg-white dark:bg-gray-700 text-gray-900 dark:text-white">
                                <option value="">Pilih mobil...</option>
                                @foreach ($mobils as $mobil)
                                    <option value="{{ $mobil->id }}"
                                        {{ old('mobil_id', $hargaSewa->mobil_id) == $mobil->id ? 'selected' : '' }}>
                                        {{ $mobil->merk }} {{ $mobil->model }} - {{ $mobil->no_plat }}
                                        ({{ $mobil->tahun }})
                                    </option>
                                @endforeach
                            </select>
                            @error('mobil_id')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Pricing Type Selection -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-3">
                                Jenis Sewa <span class="text-red-500">*</span>
                            </label>
                            <div class="space-y-3">
                                @foreach ($jenisSewa as $jenis)
                                    <div class="relative">
                                        <input type="radio" name="jenis_sewa_id" id="jenis_{{ $jenis->id }}"
                                            value="{{ $jenis->id }}"
                                            {{ old('jenis_sewa_id', $hargaSewa->jenis_sewa_id) == $jenis->id ? 'checked' : '' }}
                                            class="sr-only peer" required>
                                        <label for="jenis_{{ $jenis->id }}"
                                            class="flex items-center p-4 bg-gray-50 dark:bg-gray-700 border border-gray-200 dark:border-gray-600 rounded-xl cursor-pointer hover:bg-gray-100 dark:hover:bg-gray-600 peer-checked:bg-indigo-50 dark:peer-checked:bg-indigo-900 peer-checked:border-indigo-500 peer-checked:ring-2 peer-checked:ring-indigo-500 transition-all duration-200">

                                            <div class="flex-shrink-0 mr-4">
                                                @if ($jenis->slug === 'harian')
                                                    <div
                                                        class="w-10 h-10 bg-blue-100 dark:bg-blue-900 rounded-lg flex items-center justify-center">
                                                        <iconify-icon icon="heroicons:clock-20-solid"
                                                            class="w-5 h-5 text-blue-600 dark:text-blue-400"></iconify-icon>
                                                    </div>
                                                @elseif ($jenis->slug === 'luar-kota')
                                                    <div
                                                        class="w-10 h-10 bg-green-100 dark:bg-green-900 rounded-lg flex items-center justify-center">
                                                        <iconify-icon icon="heroicons:map-pin-20-solid"
                                                            class="w-5 h-5 text-green-600 dark:text-green-400"></iconify-icon>
                                                    </div>
                                                @elseif ($jenis->slug === 'dengan-sopir')
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

                                            <div class="flex-1">
                                                <div class="text-sm font-medium text-gray-900 dark:text-white">
                                                    {{ $jenis->nama_jenis }}
                                                </div>
                                                <div class="text-xs text-gray-500 dark:text-gray-400 mt-1">
                                                    {{ $jenis->deskripsi }}
                                                </div>
                                            </div>

                                            <div class="flex-shrink-0">
                                                <div
                                                    class="w-4 h-4 border-2 border-gray-300 dark:border-gray-600 rounded-full peer-checked:border-indigo-500 peer-checked:bg-indigo-500 peer-checked:bg-opacity-20">
                                                </div>
                                            </div>
                                        </label>
                                    </div>
                                @endforeach
                            </div>
                            @error('jenis_sewa_id')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <!-- Right Column - Price & Validity -->
                    <div class="space-y-6">
                        <h4
                            class="text-md font-semibold text-gray-800 dark:text-white border-b border-gray-200 dark:border-gray-700 pb-2">
                            Atur Harga & Periode
                        </h4>

                        <!-- Price -->
                        <div>
                            <label for="harga_per_hari"
                                class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                Harga per Hari (IDR) <span class="text-red-500">*</span>
                            </label>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <span class="text-gray-500 dark:text-gray-400 text-sm">Rp</span>
                                </div>
                                <input type="number" name="harga_per_hari" id="harga_per_hari"
                                    value="{{ old('harga_per_hari', $hargaSewa->harga_per_hari) }}" required min="0"
                                    step="1000"
                                    class="w-full pl-12 pr-4 py-2 border border-gray-300 dark:border-gray-600 rounded-xl focus:ring-2 focus:ring-indigo-500 dark:focus:ring-indigo-400 focus:border-transparent bg-white dark:bg-gray-700 text-gray-900 dark:text-white"
                                    placeholder="300000">
                            </div>
                            @error('harga_per_hari')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                            <p class="mt-1 text-xs text-gray-500 dark:text-gray-400">Masukkan harga tanpa titik atau koma
                            </p>
                        </div>

                        <!-- Validity Period -->
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">

                        </div>

                        <!-- Status -->
                        <div class="flex items-center">
                            <input type="checkbox" name="aktif" id="aktif" value="1"
                                {{ old('aktif', $hargaSewa->aktif) ? 'checked' : '' }}
                                class="h-4 w-4 text-indigo-600 focus:ring-indigo-500 border-gray-300 rounded">
                            <label for="aktif" class="ml-2 block text-sm text-gray-700 dark:text-gray-300">
                                Aktif (Tarif dapat digunakan)
                            </label>
                        </div>

                        <!-- Notes -->
                        <div>
                            <label for="catatan" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                Catatan (Optional)
                            </label>
                            <textarea name="catatan" id="catatan" rows="3"
                                class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-xl focus:ring-2 focus:ring-indigo-500 dark:focus:ring-indigo-400 focus:border-transparent bg-white dark:bg-gray-700 text-gray-900 dark:text-white"
                                placeholder="Catatan tambahan untuk tarif sewa ini...">{{ old('catatan', $hargaSewa->catatan) }}</textarea>
                            @error('catatan')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                </div>

                <!-- Submit Buttons -->
                <div
                    class="flex items-center justify-end space-x-3 mt-8 pt-6 border-t border-gray-200 dark:border-gray-700">
                    <a href="{{ route('admin.harga-sewa.index') }}"
                        class="px-6 py-2 bg-gray-500 hover:bg-gray-600 text-white font-medium rounded-xl transition-colors duration-200">
                        Cancel
                    </a>
                    <button type="submit"
                        class="px-6 py-2 bg-indigo-600 hover:bg-indigo-700 text-white font-medium rounded-xl transition-colors duration-200">
                        Update Harga Sewa
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- Form Validation Script -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const berlakuDari = document.getElementById('berlaku_dari');
            const berlakuSampai = document.getElementById('berlaku_sampai');

            berlakuDari.addEventListener('change', function() {
                berlakuSampai.min = this.value;
                if (berlakuSampai.value && berlakuSampai.value < this.value) {
                    berlakuSampai.value = '';
                }
            });

            berlakuSampai.addEventListener('change', function() {
                if (this.value && berlakuDari.value && this.value < berlakuDari.value) {
                    alert('Tanggal berakhir tidak boleh lebih awal dari tanggal mulai');
                    this.value = '';
                }
            });

            // Format price input
            const priceInput = document.getElementById('harga_per_hari');
            priceInput.addEventListener('input', function() {
                // Remove non-numeric characters except for the first character if it's a number
                this.value = this.value.replace(/[^\d]/g, '');
            });
        });
    </script>
@endsection
</option>
@endforeach
</select>
@error('jenis_sewa_id')
    <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
@enderror
</div>

<!-- Harga per Hari -->
<div>
    <label for="harga_per_hari" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
        Harga per Hari <span class="text-red-500">*</span>
    </label>
    <div class="relative">
        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
            <span class="text-gray-500 dark:text-gray-400 sm:text-sm">Rp</span>
        </div>
        <input type="number" id="harga_per_hari" name="harga_per_hari"
            value="{{ old('harga_per_hari', $hargaSewa->harga_per_hari) }}" min="0" step="1000" required
            class="w-full pl-12 pr-4 py-3 bg-gray-50 dark:bg-gray-700 border border-gray-200 dark:border-gray-600 rounded-xl focus:ring-2 focus:ring-indigo-500 dark:focus:ring-indigo-400 focus:border-transparent @error('harga_per_hari') !border-red-300 @enderror"
            placeholder="Masukkan harga sewa per hari">
    </div>
    @error('harga_per_hari')
        <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
    @enderror
    <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">Format: tanpa titik atau koma, contoh: 500000
    </p>
</div>

<!-- Tanggal Berlaku -->
<div class="grid grid-cols-1 md:grid-cols-2 gap-6">
    <!-- Berlaku Dari -->
    <div>
        <label for="berlaku_dari" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
            Berlaku Dari <span class="text-red-500">*</span>
        </label>
        <input type="date" id="berlaku_dari" name="berlaku_dari"
            value="{{ old('berlaku_dari', $hargaSewa->berlaku_dari) }}" required
            class="w-full px-4 py-3 bg-gray-50 dark:bg-gray-700 border border-gray-200 dark:border-gray-600 rounded-xl focus:ring-2 focus:ring-indigo-500 dark:focus:ring-indigo-400 focus:border-transparent @error('berlaku_dari') !border-red-300 @enderror">
        @error('berlaku_dari')
            <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
        @enderror
    </div>

    <!-- Berlaku Sampai -->
    <div>
        <label for="berlaku_sampai" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
            Berlaku Sampai
        </label>
        <input type="date" id="berlaku_sampai" name="berlaku_sampai"
            value="{{ old('berlaku_sampai', $hargaSewa->berlaku_sampai) }}"
            class="w-full px-4 py-3 bg-gray-50 dark:bg-gray-700 border border-gray-200 dark:border-gray-600 rounded-xl focus:ring-2 focus:ring-indigo-500 dark:focus:ring-indigo-400 focus:border-transparent @error('berlaku_sampai') !border-red-300 @enderror">
        @error('berlaku_sampai')
            <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
        @enderror
        <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">Kosongkan jika tidak ada batas waktu</p>
    </div>
</div>

<!-- Keterangan -->
<div>
    <label for="keterangan" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
        Keterangan
    </label>
    <textarea id="keterangan" name="keterangan" rows="3"
        class="w-full px-4 py-3 bg-gray-50 dark:bg-gray-700 border border-gray-200 dark:border-gray-600 rounded-xl focus:ring-2 focus:ring-indigo-500 dark:focus:ring-indigo-400 focus:border-transparent @error('keterangan') !border-red-300 @enderror"
        placeholder="Tambahkan catatan atau keterangan khusus (opsional)">{{ old('keterangan', $hargaSewa->keterangan) }}</textarea>
    @error('keterangan')
        <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
    @enderror
</div>

<!-- Form Actions -->
<div class="flex flex-col sm:flex-row gap-3 pt-6 border-t border-gray-200 dark:border-gray-700">
    <button type="submit"
        class="flex-1 sm:flex-none px-6 py-3 bg-gradient-to-r from-amber-500 to-orange-600 hover:from-amber-600 hover:to-orange-700 text-white font-medium rounded-xl transition-all duration-200 shadow-lg hover:shadow-xl">
        <iconify-icon icon="heroicons:check-20-solid" class="w-4 h-4 mr-2 inline"></iconify-icon>
        Perbarui Harga Sewa
    </button>
    <a href="{{ route('admin.harga-sewa.index') }}"
        class="flex-1 sm:flex-none px-6 py-3 bg-gray-100 dark:bg-gray-700 hover:bg-gray-200 dark:hover:bg-gray-600 text-gray-700 dark:text-gray-300 font-medium rounded-xl transition-colors duration-200 text-center">
        <iconify-icon icon="heroicons:x-mark-20-solid" class="w-4 h-4 mr-2 inline"></iconify-icon>
        Batal
    </a>
</div>
</form>
</div>
</div>

<!-- Date Validation Script -->
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const berlakuDari = document.getElementById('berlaku_dari');
        const berlakuSampai = document.getElementById('berlaku_sampai');

        berlakuDari.addEventListener('change', function() {
            berlakuSampai.min = this.value;
            if (berlakuSampai.value && berlakuSampai.value < this.value) {
                berlakuSampai.value = '';
            }
        });

        berlakuSampai.addEventListener('change', function() {
            if (this.value && berlakuDari.value && this.value < berlakuDari.value) {
                alert('Tanggal berlaku sampai tidak boleh lebih awal dari tanggal berlaku dari');
                this.value = '';
            }
        });

        // Set initial min date for berlaku_sampai
        if (berlakuDari.value) {
            berlakuSampai.min = berlakuDari.value;
        }
    });
</script>
@endsection
