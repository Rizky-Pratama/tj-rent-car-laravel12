@extends('layouts.admin')

@section('title', 'Atur Harga Sewa - ' . $mobil->merk . ' ' . $mobil->model)

@section('content')
    <div class="max-w-6xl mx-auto">
        <!-- Header -->
        <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-sm border border-gray-200 dark:border-gray-700 p-6 mb-6">
            <div class="flex items-center justify-between">
                <div class="flex items-center space-x-4">
                    <div class="w-16 h-16 bg-gray-100 dark:bg-gray-700 rounded-xl flex items-center justify-center">
                        @if ($mobil->foto)
                            <img src="{{ Storage::url($mobil->foto) }}" alt="{{ $mobil->merk }} {{ $mobil->model }}"
                                class="w-16 h-16 object-cover rounded-xl">
                        @else
                            <iconify-icon icon="heroicons:truck-20-solid" class="w-8 h-8 text-gray-400"></iconify-icon>
                        @endif
                    </div>
                    <div>
                        <h1 class="text-2xl font-bold text-gray-900 dark:text-white">Atur Harga Sewa</h1>
                        <p class="text-sm text-gray-600 dark:text-gray-400">
                            {{ $mobil->merk }} {{ $mobil->model }} - {{ $mobil->plat_nomor }}
                        </p>
                    </div>
                </div>
                <div class="flex items-center space-x-3">
                    <a href="{{ route('admin.mobil.show', $mobil) }}"
                        class="inline-flex items-center px-4 py-2 bg-indigo-600 hover:bg-indigo-700 text-white text-sm font-medium rounded-xl transition-colors duration-200">
                        <iconify-icon icon="heroicons:eye-20-solid" class="w-4 h-4 mr-2"></iconify-icon>
                        Lihat Detail
                    </a>
                    <a href="{{ route('admin.mobil.index') }}"
                        class="inline-flex items-center px-4 py-2 bg-gray-500 hover:bg-gray-600 text-white text-sm font-medium rounded-xl transition-colors duration-200">
                        <iconify-icon icon="heroicons:arrow-left-20-solid" class="w-4 h-4 mr-2"></iconify-icon>
                        Kembali
                    </a>
                </div>
            </div>
        </div>

        <!-- Quick Stats -->
        <div class="grid grid-cols-2 md:grid-cols-4 lg:grid-cols-6 gap-4 mb-6">
            <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 p-4">
                <div class="flex items-center">
                    <div class="p-2 bg-indigo-100 dark:bg-indigo-900/50 rounded-lg">
                        <iconify-icon icon="heroicons:document-text-20-solid"
                            class="w-5 h-5 text-indigo-600 dark:text-indigo-400"></iconify-icon>
                    </div>
                    <div class="ml-3">
                        <p class="text-xs font-medium text-gray-600 dark:text-gray-400">Total Jenis</p>
                        <p class="text-xl font-bold text-gray-900 dark:text-white">{{ $stats['total_jenis'] }}</p>
                    </div>
                </div>
            </div>

            <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 p-4">
                <div class="flex items-center">
                    <div class="p-2 bg-green-100 dark:bg-green-900/50 rounded-lg">
                        <iconify-icon icon="heroicons:check-circle-20-solid"
                            class="w-5 h-5 text-green-600 dark:text-green-400"></iconify-icon>
                    </div>
                    <div class="ml-3">
                        <p class="text-xs font-medium text-gray-600 dark:text-gray-400">Aktif</p>
                        <p class="text-xl font-bold text-green-600 dark:text-green-400">{{ $stats['aktif'] }}</p>
                    </div>
                </div>
            </div>

            <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 p-4">
                <div class="flex items-center">
                    <div class="p-2 bg-gray-100 dark:bg-gray-700 rounded-lg">
                        <iconify-icon icon="heroicons:pause-circle-20-solid"
                            class="w-5 h-5 text-gray-600 dark:text-gray-400"></iconify-icon>
                    </div>
                    <div class="ml-3">
                        <p class="text-xs font-medium text-gray-600 dark:text-gray-400">Nonaktif</p>
                        <p class="text-xl font-bold text-gray-600 dark:text-gray-400">{{ $stats['nonaktif'] }}</p>
                    </div>
                </div>
            </div>

            <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 p-4">
                <div class="flex items-center">
                    <div class="p-2 bg-orange-100 dark:bg-orange-900/50 rounded-lg">
                        <iconify-icon icon="heroicons:exclamation-circle-20-solid"
                            class="w-5 h-5 text-orange-600 dark:text-orange-400"></iconify-icon>
                    </div>
                    <div class="ml-3">
                        <p class="text-xs font-medium text-gray-600 dark:text-gray-400">Belum Diatur</p>
                        <p class="text-xl font-bold text-orange-600 dark:text-orange-400">{{ $stats['belum_diatur'] }}</p>
                    </div>
                </div>
            </div>

            <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 p-4">
                <div class="flex items-center">
                    <div class="p-2 bg-blue-100 dark:bg-blue-900/50 rounded-lg">
                        <iconify-icon icon="heroicons:arrow-trending-down-20-solid"
                            class="w-5 h-5 text-blue-600 dark:text-blue-400"></iconify-icon>
                    </div>
                    <div class="ml-3">
                        <p class="text-xs font-medium text-gray-600 dark:text-gray-400">Terendah</p>
                        <p class="text-sm font-bold text-blue-600 dark:text-blue-400">
                            {{ $stats['harga_terendah'] ? 'Rp ' . number_format($stats['harga_terendah'], 0, ',', '.') : '-' }}
                        </p>
                    </div>
                </div>
            </div>

            <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 p-4">
                <div class="flex items-center">
                    <div class="p-2 bg-purple-100 dark:bg-purple-900/50 rounded-lg">
                        <iconify-icon icon="heroicons:arrow-trending-up-20-solid"
                            class="w-5 h-5 text-purple-600 dark:text-purple-400"></iconify-icon>
                    </div>
                    <div class="ml-3">
                        <p class="text-xs font-medium text-gray-600 dark:text-gray-400">Tertinggi</p>
                        <p class="text-sm font-bold text-purple-600 dark:text-purple-400">
                            {{ $stats['harga_tertinggi'] ? 'Rp ' . number_format($stats['harga_tertinggi'], 0, ',', '.') : '-' }}
                        </p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Pricing Form -->
        <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-sm border border-gray-200 dark:border-gray-700">
            <form method="POST" action="{{ route('admin.mobil.pricing.update', $mobil) }}" class="p-6">
                @csrf

                <div class="mb-8">
                    <div class="flex items-start mb-4">
                        <div>
                            <h3 class="text-xl font-bold text-gray-900 dark:text-white mb-2 flex items-center">
                                <iconify-icon icon="heroicons:currency-dollar-20-solid"
                                    class="w-6 h-6 mr-3 text-indigo-600"></iconify-icon>
                                Pengaturan Harga Sewa
                            </h3>
                            <p class="text-sm text-gray-600 dark:text-gray-400 max-w-2xl">
                                Kelola harga sewa untuk berbagai jenis layanan rental. Aktifkan hanya jenis sewa yang ingin
                                Anda tawarkan kepada pelanggan.
                            </p>
                        </div>
                    </div>

                </div>

                <!-- Table Layout -->
                <div
                    class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 overflow-hidden">
                    <div class="overflow-x-auto">
                        <table class="w-full" x-data="pricingTableManager()">
                            <thead class="bg-gray-50 dark:bg-gray-700">
                                <tr>
                                    <th class="px-6 py-4 text-left text-sm font-semibold text-gray-900 dark:text-white">
                                        <div class="flex items-center space-x-2">
                                            <iconify-icon icon="heroicons:document-text-20-solid"
                                                class="w-5 h-5 text-indigo-600"></iconify-icon>
                                            <span>Jenis Sewa</span>
                                        </div>
                                    </th>
                                    <th class="px-6 py-4 text-center text-sm font-semibold text-gray-900 dark:text-white">
                                        Status</th>
                                    <th class="px-6 py-4 text-center text-sm font-semibold text-gray-900 dark:text-white">
                                        <div class="flex items-center justify-center space-x-2">
                                            <iconify-icon icon="heroicons:currency-dollar-20-solid"
                                                class="w-5 h-5 text-indigo-600"></iconify-icon>
                                            <span>Harga Saat Ini</span>
                                        </div>
                                    </th>
                                    <th class="px-6 py-4 text-center text-sm font-semibold text-gray-900 dark:text-white">
                                        <div class="flex items-center justify-center space-x-2">
                                            <iconify-icon icon="heroicons:pencil-square-20-solid"
                                                class="w-5 h-5 text-indigo-600"></iconify-icon>
                                            <span>Harga Baru</span>
                                        </div>
                                    </th>
                                    <th class="px-6 py-4 text-center text-sm font-semibold text-gray-900 dark:text-white">
                                        Toggle</th>
                                    <th class="px-6 py-4 text-center text-sm font-semibold text-gray-900 dark:text-white">
                                        Aksi</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-200 dark:divide-gray-600">
                                @foreach ($jenisSewa as $index => $jenis)
                                    @php
                                        $existing = $existingPricing->get($jenis->id);
                                        $isActive = $existing && $existing->aktif;
                                    @endphp

                                    <tr class="hover:bg-gray-50 dark:hover:bg-gray-700/50 transition-colors duration-150 {{ $isActive ? 'bg-green-50/30 dark:bg-green-900/10' : '' }}"
                                        x-data="{
                                            isEnabled: {{ $isActive ? 'true' : 'false' }},
                                            isEditing: false,
                                            showDetails: false,
                                            newPrice: {{ $existing ? $existing->harga_per_hari : 0 }},
                                            notes: '{{ $existing ? addslashes($existing->catatan ?? '') : '' }}'
                                        }">

                                        <!-- Jenis Sewa Column -->
                                        <td class="px-6 py-4">
                                            <div class="flex items-start space-x-3">
                                                <div class="flex-shrink-0">
                                                    <div
                                                        class="w-10 h-10 rounded-lg flex items-center justify-center {{ $isActive ? 'bg-green-100 dark:bg-green-900/30' : 'bg-gray-100 dark:bg-gray-700' }}">
                                                        <iconify-icon icon="heroicons:document-text-20-solid"
                                                            class="w-5 h-5 {{ $isActive ? 'text-green-600 dark:text-green-400' : 'text-gray-500 dark:text-gray-400' }}"></iconify-icon>
                                                    </div>
                                                </div>
                                                <div class="min-w-0 flex-1">
                                                    <h4 class="text-sm font-semibold text-gray-900 dark:text-white">
                                                        {{ $jenis->nama_jenis }}</h4>
                                                    <p class="text-xs text-gray-600 dark:text-gray-400 mt-1 line-clamp-2">
                                                        {{ $jenis->deskripsi ?: 'Layanan rental standar' }}</p>
                                                    @if ($jenis->tarif_denda_per_hari)
                                                        <div class="flex items-center space-x-1 mt-2">
                                                            <iconify-icon icon="heroicons:exclamation-triangle-20-solid"
                                                                class="w-3 h-3 text-orange-500"></iconify-icon>
                                                            <span
                                                                class="text-xs text-orange-600 dark:text-orange-400">Denda:
                                                                Rp
                                                                {{ number_format($jenis->tarif_denda_per_hari, 0, ',', '.') }}/hari</span>
                                                        </div>
                                                    @endif

                                                    <!-- Details Button -->
                                                    <button type="button" @click="showDetails = !showDetails"
                                                        class="text-xs text-indigo-600 dark:text-indigo-400 hover:text-indigo-700 dark:hover:text-indigo-300 mt-1 flex items-center">
                                                        <iconify-icon icon="heroicons:information-circle-20-solid"
                                                            class="w-3 h-3 mr-1"></iconify-icon>
                                                        <span x-text="showDetails ? 'Sembunyikan' : 'Detail'"></span>
                                                    </button>
                                                </div>
                                            </div>

                                            <!-- Expandable Details -->
                                            <div x-show="showDetails"
                                                x-transition:enter="transition ease-out duration-200"
                                                x-transition:enter-start="opacity-0 max-h-0"
                                                x-transition:enter-end="opacity-100 max-h-screen" class="mt-4 pl-13 pr-4">
                                                <div class="bg-gray-50 dark:bg-gray-700/50 rounded-lg p-4 space-y-3">
                                                    @if ($existing)
                                                        <div class="text-xs">
                                                            <span class="text-gray-600 dark:text-gray-400">Terakhir
                                                                diperbarui:</span>
                                                            <span
                                                                class="font-medium text-gray-900 dark:text-white">{{ $existing->updated_at->format('d M Y, H:i') }}</span>
                                                        </div>
                                                        @if ($existing->catatan)
                                                            <div class="text-xs">
                                                                <span
                                                                    class="text-gray-600 dark:text-gray-400 block mb-1">Catatan
                                                                    saat ini:</span>
                                                                <p
                                                                    class="text-gray-900 dark:text-white bg-white dark:bg-gray-800 p-2 rounded border text-wrap">
                                                                    {{ $existing->catatan }}</p>
                                                            </div>
                                                        @endif
                                                    @else
                                                        <p class="text-xs text-gray-500 dark:text-gray-400 italic">Belum
                                                            ada pengaturan harga untuk jenis sewa ini</p>
                                                    @endif
                                                </div>
                                            </div>
                                        </td>

                                        <!-- Status Column -->
                                        <td class="px-6 py-4 text-center">
                                            @if ($isActive)
                                                <span
                                                    class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-green-100 text-green-800 dark:bg-green-900/30 dark:text-green-300">
                                                    <iconify-icon icon="heroicons:check-circle-20-solid"
                                                        class="w-3 h-3 mr-1"></iconify-icon>
                                                    Tersedia
                                                </span>
                                            @else
                                                <span
                                                    class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-gray-100 text-gray-600 dark:bg-gray-700 dark:text-gray-400">
                                                    <iconify-icon icon="heroicons:minus-circle-20-solid"
                                                        class="w-3 h-3 mr-1"></iconify-icon>
                                                    Nonaktif
                                                </span>
                                            @endif
                                        </td>

                                        <!-- Current Price Column -->
                                        <td class="px-6 py-4 text-center">
                                            @if ($existing)
                                                <div class="flex flex-col items-center">
                                                    <span class="text-lg font-bold text-gray-900 dark:text-white">
                                                        Rp {{ number_format($existing->harga_per_hari, 0, ',', '.') }}
                                                    </span>
                                                    <span class="text-xs text-gray-500 dark:text-gray-400">per hari</span>
                                                </div>
                                            @else
                                                <span class="text-sm text-gray-500 dark:text-gray-400 italic">Belum
                                                    diatur</span>
                                            @endif
                                        </td>

                                        <!-- New Price Input Column -->
                                        <td class="px-6 py-4">
                                            <div class="space-y-3">
                                                <!-- Price Input -->
                                                <div class="relative">
                                                    <div
                                                        class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                                        <span class="text-gray-500 dark:text-gray-400 text-sm">Rp</span>
                                                    </div>
                                                    <input type="number"
                                                        name="pricing[{{ $index }}][harga_per_hari]"
                                                        x-model="newPrice" step="1000" min="0"
                                                        x-bind:required="isEnabled"
                                                        class="w-full pl-10 pr-4 py-2 text-sm rounded-lg border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition-colors duration-200 font-semibold text-center"
                                                        placeholder="0">
                                                    <input type="hidden"
                                                        name="pricing[{{ $index }}][jenis_sewa_id]"
                                                        value="{{ $jenis->id }}">
                                                </div>

                                                <!-- Notes Textarea (Collapsible) -->
                                                <div>
                                                    <button type="button" @click="isEditing = !isEditing"
                                                        class="w-full text-xs text-indigo-600 dark:text-indigo-400 hover:text-indigo-700 dark:hover:text-indigo-300 flex items-center justify-center space-x-1 py-1">
                                                        <iconify-icon icon="heroicons:chat-bubble-left-ellipsis-20-solid"
                                                            class="w-3 h-3"></iconify-icon>
                                                        <span
                                                            x-text="isEditing ? 'Tutup Catatan' : 'Tambah Catatan'"></span>
                                                    </button>

                                                    <div x-show="isEditing"
                                                        x-transition:enter="transition ease-out duration-200"
                                                        x-transition:enter-start="opacity-0 max-h-0"
                                                        x-transition:enter-end="opacity-100 max-h-32" class="mt-2">
                                                        <textarea name="pricing[{{ $index }}][catatan]" x-model="notes" rows="2"
                                                            class="w-full px-3 py-2 text-xs rounded-lg border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition-colors duration-200 resize-none"
                                                            placeholder="Catatan khusus..."></textarea>
                                                    </div>
                                                </div>
                                            </div>
                                        </td>

                                        <!-- Toggle Column -->
                                        <td class="px-6 py-4 text-center">
                                            <label class="relative inline-flex items-center cursor-pointer">
                                                <input type="checkbox" name="pricing[{{ $index }}][aktif]"
                                                    value="1" {{ $isActive ? 'checked' : '' }} class="sr-only peer"
                                                    x-model="isEnabled">
                                                <div
                                                    class="w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-indigo-300 dark:peer-focus:ring-indigo-800 rounded-full peer dark:bg-gray-700 peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all dark:border-gray-600 peer-checked:bg-indigo-600">
                                                </div>
                                            </label>
                                        </td>

                                        <!-- Actions Column -->
                                        <td class="px-6 py-4 text-center">
                                            <div class="flex items-center justify-center space-x-2">
                                                @if ($existing)
                                                    <button type="button"
                                                        onclick="resetPricing({{ $index }}, {{ $existing->harga_per_hari }}, '{{ addslashes($existing->catatan ?? '') }}')"
                                                        class="p-2 text-gray-600 dark:text-gray-400 hover:text-indigo-600 dark:hover:text-indigo-400 hover:bg-gray-100 dark:hover:bg-gray-700 rounded-lg transition-colors duration-200"
                                                        title="Reset ke harga saat ini">
                                                        <iconify-icon icon="heroicons:arrow-path-20-solid"
                                                            class="w-4 h-4"></iconify-icon>
                                                    </button>
                                                @endif

                                                <button type="button" onclick="clearPricing({{ $index }})"
                                                    class="p-2 text-gray-600 dark:text-gray-400 hover:text-red-600 dark:hover:text-red-400 hover:bg-gray-100 dark:hover:bg-gray-700 rounded-lg transition-colors duration-200"
                                                    title="Kosongkan form">
                                                    <iconify-icon icon="heroicons:x-mark-20-solid"
                                                        class="w-4 h-4"></iconify-icon>
                                                </button>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    <!-- Quick Actions Footer -->
                    <div class="bg-gray-50 dark:bg-gray-700 px-6 py-4 border-t border-gray-200 dark:border-gray-600">
                        <div class="flex items-center justify-between">
                            <div class="flex items-center space-x-4">
                                <button type="button" onclick="toggleAllPricing(true)"
                                    class="text-sm text-indigo-600 dark:text-indigo-400 hover:text-indigo-700 dark:hover:text-indigo-300 flex items-center space-x-1">
                                    <iconify-icon icon="heroicons:check-circle-20-solid" class="w-4 h-4"></iconify-icon>
                                    <span>Aktifkan Semua</span>
                                </button>

                                <button type="button" onclick="toggleAllPricing(false)"
                                    class="text-sm text-gray-600 dark:text-gray-400 hover:text-gray-700 dark:hover:text-gray-300 flex items-center space-x-1">
                                    <iconify-icon icon="heroicons:x-circle-20-solid" class="w-4 h-4"></iconify-icon>
                                    <span>Nonaktifkan Semua</span>
                                </button>
                            </div>

                            <div class="text-sm text-gray-600 dark:text-gray-400">
                                Total: {{ $jenisSewa->count() }} jenis sewa
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Submit Buttons -->
                <div
                    class="flex items-center justify-end space-x-3 pt-6 border-t border-gray-200 dark:border-gray-700 mt-6">
                    <a href="{{ route('admin.mobil.index') }}"
                        class="px-6 py-2 bg-gray-500 hover:bg-gray-600 text-white text-sm font-medium rounded-xl transition-colors duration-200">
                        Batal
                    </a>
                    <button type="submit"
                        class="px-6 py-2 flex gap-2 items-center bg-indigo-600 hover:bg-indigo-700 text-white text-sm font-medium rounded-xl transition-colors duration-200">
                        <iconify-icon icon="heroicons:check-20-solid" class="w-4 h-4"></iconify-icon>
                        Simpan Semua Harga
                    </button>
                </div>
            </form>
        </div>
    </div>

    @push('scripts')
        <script>
            function pricingTableManager() {
                return {
                    // Initialize any global table state here
                }
            }

            // Helper functions for table actions
            function resetPricing(index, currentPrice, currentNotes) {
                // Find the row and reset to current values
                const row = document.querySelector(`input[name="pricing[${index}][harga_per_hari]"]`).closest('tr');
                const priceInput = row.querySelector(`input[name="pricing[${index}][harga_per_hari]"]`);
                const notesTextarea = row.querySelector(`textarea[name="pricing[${index}][catatan]"]`);

                if (priceInput) {
                    priceInput.value = currentPrice;
                    // Trigger Alpine.js reactivity
                    priceInput.dispatchEvent(new Event('input'));
                }

                if (notesTextarea) {
                    notesTextarea.value = currentNotes;
                    // Trigger Alpine.js reactivity
                    notesTextarea.dispatchEvent(new Event('input'));
                }
            }

            function clearPricing(index) {
                // Find the row and clear all inputs
                const row = document.querySelector(`input[name="pricing[${index}][harga_per_hari]"]`).closest('tr');
                const priceInput = row.querySelector(`input[name="pricing[${index}][harga_per_hari]"]`);
                const notesTextarea = row.querySelector(`textarea[name="pricing[${index}][catatan]"]`);
                const checkbox = row.querySelector(`input[name="pricing[${index}][aktif]"]`);

                if (priceInput) {
                    priceInput.value = '';
                    priceInput.dispatchEvent(new Event('input'));
                }

                if (notesTextarea) {
                    notesTextarea.value = '';
                    notesTextarea.dispatchEvent(new Event('input'));
                }

                if (checkbox) {
                    checkbox.checked = false;
                    checkbox.dispatchEvent(new Event('change'));
                }
            }

            function toggleAllPricing(activate) {
                // Get all checkboxes
                const checkboxes = document.querySelectorAll('input[type="checkbox"][name*="[aktif]"]');

                checkboxes.forEach(function(checkbox) {
                    checkbox.checked = activate;
                    checkbox.dispatchEvent(new Event('change'));
                });
            }

            // Form validation before submit
            document.addEventListener('DOMContentLoaded', function() {
                const form = document.querySelector('form');
                if (form) {
                    form.addEventListener('submit', function(e) {
                        const rows = document.querySelectorAll('tbody tr');
                        let hasValidPricing = true;
                        let missingPrices = [];
                        let activeCount = 0;

                        rows.forEach(function(row) {
                            const checkbox = row.querySelector(
                                'input[type="checkbox"][name*="[aktif]"]');
                            const priceInput = row.querySelector('input[type="number"]');
                            const jenisName = row.querySelector('h4').textContent.trim();

                            if (checkbox && checkbox.checked) {
                                activeCount++;

                                if (!priceInput.value || parseInt(priceInput.value) < 50000) {
                                    hasValidPricing = false;
                                    missingPrices.push(jenisName);
                                }
                            }
                        });

                        // Check if at least one pricing is active
                        if (activeCount === 0) {
                            e.preventDefault();
                            alert('Mohon aktifkan minimal satu jenis sewa dan atur harganya!');
                            return false;
                        }

                        if (!hasValidPricing) {
                            e.preventDefault();
                            alert('Mohon isi harga minimal Rp 50.000 untuk jenis sewa yang diaktifkan:\n• ' +
                                missingPrices.join('\n• '));
                            return false;
                        }

                        // Show confirmation for active changes
                        const confirmMessage = `Anda akan mengaktifkan ${activeCount} jenis sewa. Lanjutkan?`;
                        if (!confirm(confirmMessage)) {
                            e.preventDefault();
                            return false;
                        }
                    });
                }

                // Add currency formatting to price inputs
                document.querySelectorAll('input[type="number"]').forEach(function(input) {
                    input.addEventListener('input', function(e) {
                        let value = e.target.value.replace(/\D/g, '');
                        // Remove leading zeros
                        value = value.replace(/^0+/, '') || '0';
                        e.target.value = value;
                    });

                    // Add blur event for better UX feedback
                    input.addEventListener('blur', function(e) {
                        const value = parseInt(e.target.value);
                        if (value > 0 && value < 50000) {
                            e.target.classList.add('border-red-500', 'focus:border-red-500',
                                'focus:ring-red-500');

                            // Show warning tooltip
                            let warning = e.target.parentElement.querySelector('.price-warning');
                            if (!warning) {
                                warning = document.createElement('p');
                                warning.className = 'price-warning text-xs text-red-500 mt-1';
                                warning.textContent = 'Harga minimal Rp 50.000';
                                e.target.parentElement.appendChild(warning);
                            }
                        } else {
                            e.target.classList.remove('border-red-500', 'focus:border-red-500',
                                'focus:ring-red-500');

                            // Remove warning
                            const warning = e.target.parentElement.querySelector('.price-warning');
                            if (warning) {
                                warning.remove();
                            }
                        }
                    });
                });
            });
        </script>
    @endpush
@endsection
