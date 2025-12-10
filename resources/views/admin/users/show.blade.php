@extends('layouts.admin')

@section('title', 'Detail Pengguna')
@section('page-title', 'Detail Pengguna')
@section('page-subtitle', 'Informasi lengkap pengguna')

@section('content')
    <div class="max-w-4xl mx-auto">
        <!-- Header Card -->
        <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-sm border border-gray-100 dark:border-gray-700 p-6 mb-6">
            <div class="flex items-start justify-between">
                <div class="flex items-center">
                    <div class="flex-shrink-0 h-16 w-16">
                        <div
                            class="h-16 w-16 rounded-full bg-gradient-to-r from-indigo-500 to-purple-600 flex items-center justify-center">
                            <span class="text-lg font-medium text-white">
                                {{ substr($user->nama, 0, 2) }}
                            </span>
                        </div>
                    </div>
                    <div class="ml-6">
                        <h1 class="text-2xl font-bold text-gray-900 dark:text-white">{{ $user->nama }}</h1>
                        <p class="text-sm text-gray-500 dark:text-gray-400">{{ $user->email }}</p>
                        <div class="flex items-center gap-2 mt-2">
                            <span
                                class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium
                                {{ $user->role === 'admin' ? 'bg-purple-100 text-purple-800 dark:bg-purple-900 dark:text-purple-200' : 'bg-blue-100 text-blue-800 dark:bg-blue-900 dark:text-blue-200' }}">
                                {{ ucfirst($user->role) }}
                            </span>
                            <span
                                class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium
                                {{ $user->aktif ? 'bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200' : 'bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-200' }}">
                                {{ $user->aktif ? 'Aktif' : 'Tidak Aktif' }}
                            </span>
                        </div>
                    </div>
                </div>
                <div class="flex gap-2">
                    @can('update', $user)
                        <a href="{{ route('admin.users.edit', $user) }}"
                            class="inline-flex items-center px-4 py-2 bg-amber-600 hover:bg-amber-700 text-white text-sm font-medium rounded-xl transition-colors duration-200">
                            <iconify-icon icon="heroicons:pencil-20-solid" class="w-4 h-4 mr-2"></iconify-icon>
                            Edit
                        </a>
                    @endcan
                    <a href="{{ route('admin.users.index') }}"
                        class="inline-flex items-center px-4 py-2 bg-gray-600 hover:bg-gray-700 text-white text-sm font-medium rounded-xl transition-colors duration-200">
                        <iconify-icon icon="heroicons:arrow-left-20-solid" class="w-4 h-4 mr-2"></iconify-icon>
                        Kembali
                    </a>
                </div>
            </div>
        </div>

        <!-- Information Cards -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
            <!-- Personal Information -->
            <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-sm border border-gray-100 dark:border-gray-700 p-6">
                <h2 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">
                    <iconify-icon icon="heroicons:user-20-solid" class="w-5 h-5 inline mr-2"></iconify-icon>
                    Informasi Personal
                </h2>
                <div class="space-y-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-500 dark:text-gray-400">Nama Lengkap</label>
                        <p class="text-sm text-gray-900 dark:text-white">{{ $user->nama }}</p>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-500 dark:text-gray-400">Email</label>
                        <p class="text-sm text-gray-900 dark:text-white">{{ $user->email }}</p>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-500 dark:text-gray-400">Telepon</label>
                        <p class="text-sm text-gray-900 dark:text-white">{{ $user->telepon }}</p>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-500 dark:text-gray-400">Alamat</label>
                        <p class="text-sm text-gray-900 dark:text-white">{{ $user->alamat }}</p>
                    </div>
                </div>
            </div>

            <!-- System Information -->
            <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-sm border border-gray-100 dark:border-gray-700 p-6">
                <h2 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">
                    <iconify-icon icon="heroicons:cog-6-tooth-20-solid" class="w-5 h-5 inline mr-2"></iconify-icon>
                    Informasi Sistem
                </h2>
                <div class="space-y-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-500 dark:text-gray-400">Role</label>
                        <p class="text-sm text-gray-900 dark:text-white">{{ ucfirst($user->role) }}</p>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-500 dark:text-gray-400">Status</label>
                        <p class="text-sm text-gray-900 dark:text-white">{{ $user->aktif ? 'Aktif' : 'Tidak Aktif' }}</p>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-500 dark:text-gray-400">Terdaftar</label>
                        <p class="text-sm text-gray-900 dark:text-white">{{ $user->created_at->format('d F Y, H:i') }}</p>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-500 dark:text-gray-400">Terakhir
                            Diperbarui</label>
                        <p class="text-sm text-gray-900 dark:text-white">{{ $user->updated_at->format('d F Y, H:i') }}</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Activity Log (Placeholder for future implementation) -->
        <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-sm border border-gray-100 dark:border-gray-700 p-6">
            <h2 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">
                <iconify-icon icon="heroicons:clock-20-solid" class="w-5 h-5 inline mr-2"></iconify-icon>
                Log Aktivitas Terbaru
            </h2>
            <div class="text-center py-8">
                <iconify-icon icon="heroicons:document-text-20-solid"
                    class="w-12 h-12 text-gray-400 mx-auto mb-4"></iconify-icon>
                <p class="text-sm text-gray-500 dark:text-gray-400">Log aktivitas akan ditampilkan di sini.</p>
            </div>
        </div>
    </div>
@endsection
