@extends('layouts.admin')

@section('title', 'Profil Saya')
@section('page-title', 'Profil Saya')
@section('page-subtitle', 'Informasi akun dan pengaturan profil Anda')

@section('content')
    <div class="max-w-4xl mx-auto space-y-6">
        <!-- Profile Card -->
        <div
            class="bg-white dark:bg-gray-800 rounded-2xl shadow-sm border border-gray-100 dark:border-gray-700 overflow-hidden">
            <!-- Header with gradient -->
            <div class="h-32 bg-gradient-to-r from-indigo-500 to-purple-600"></div>

            <!-- Profile Content -->
            <div class="px-6 pb-6">
                <div class="flex flex-col sm:flex-row items-start sm:items-end -mt-15 mb-6">
                    <!-- Avatar -->
                    <div class="relative mb-4 sm:mb-0">
                        <div
                            class="w-32 h-32 rounded-2xl border-4 border-white dark:border-gray-800 bg-gradient-to-br from-indigo-500 to-purple-600 flex items-center justify-center shadow-lg">
                            <span class="text-4xl font-bold text-white">
                                {{ strtoupper(substr($user->nama, 0, 1)) }}
                            </span>
                        </div>
                    </div>

                    <!-- Name & Role -->
                    <div class="sm:ml-6 flex-1">
                        <h2 class="text-2xl font-bold text-gray-900 dark:text-white line-clamp-1">{{ $user->nama }}</h2>
                        <div class="flex items-center mt-2 space-x-3">
                            <span
                                class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-indigo-100 text-indigo-800 dark:bg-indigo-900 dark:text-indigo-200">
                                <iconify-icon icon="heroicons:shield-check-solid" class="w-4 h-4 mr-1"></iconify-icon>
                                {{ ucfirst($user->role) }}
                            </span>
                            @if ($user->aktif)
                                <span
                                    class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200">
                                    <iconify-icon icon="heroicons:check-circle-solid" class="w-4 h-4 mr-1"></iconify-icon>
                                    Aktif
                                </span>
                            @else
                                <span
                                    class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-gray-100 text-gray-800 dark:bg-gray-900 dark:text-gray-200">
                                    Nonaktif
                                </span>
                            @endif
                        </div>
                    </div>

                    <!-- Edit Button -->
                    <div class="mt-4 sm:mt-0">
                        <a href="{{ route('admin.profile.edit') }}"
                            class="inline-flex items-center px-4 py-2 bg-indigo-600 hover:bg-indigo-700 text-white text-sm font-medium rounded-lg transition-colors">
                            <iconify-icon icon="heroicons:pencil-square-solid" class="w-4 h-4 mr-2"></iconify-icon>
                            Edit Profil
                        </a>
                    </div>
                </div>

                <!-- Info Grid -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mt-8">
                    <!-- Email -->
                    <div class="flex items-start space-x-3">
                        <div
                            class="flex-shrink-0 w-10 h-10 bg-indigo-100 dark:bg-indigo-900/30 rounded-lg flex items-center justify-center">
                            <iconify-icon icon="heroicons:envelope-solid"
                                class="w-5 h-5 text-indigo-600 dark:text-indigo-400"></iconify-icon>
                        </div>
                        <div class="flex-1 min-w-0">
                            <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Email</p>
                            <p class="mt-1 text-sm text-gray-900 dark:text-white truncate">{{ $user->email }}</p>
                        </div>
                    </div>

                    <!-- Phone -->
                    <div class="flex items-start space-x-3">
                        <div
                            class="flex-shrink-0 w-10 h-10 bg-green-100 dark:bg-green-900/30 rounded-lg flex items-center justify-center">
                            <iconify-icon icon="heroicons:phone-solid"
                                class="w-5 h-5 text-green-600 dark:text-green-400"></iconify-icon>
                        </div>
                        <div class="flex-1 min-w-0">
                            <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Telepon</p>
                            <p class="mt-1 text-sm text-gray-900 dark:text-white">
                                {{ $user->telepon ?? '-' }}
                            </p>
                        </div>
                    </div>

                    <!-- Address -->
                    <div class="flex items-start space-x-3 md:col-span-2">
                        <div
                            class="flex-shrink-0 w-10 h-10 bg-purple-100 dark:bg-purple-900/30 rounded-lg flex items-center justify-center">
                            <iconify-icon icon="heroicons:map-pin-solid"
                                class="w-5 h-5 text-purple-600 dark:text-purple-400"></iconify-icon>
                        </div>
                        <div class="flex-1 min-w-0">
                            <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Alamat</p>
                            <p class="mt-1 text-sm text-gray-900 dark:text-white">
                                {{ $user->alamat ?? '-' }}
                            </p>
                        </div>
                    </div>

                    <!-- Member Since -->
                    <div class="flex items-start space-x-3">
                        <div
                            class="flex-shrink-0 w-10 h-10 bg-blue-100 dark:bg-blue-900/30 rounded-lg flex items-center justify-center">
                            <iconify-icon icon="heroicons:calendar-solid"
                                class="w-5 h-5 text-blue-600 dark:text-blue-400"></iconify-icon>
                        </div>
                        <div class="flex-1 min-w-0">
                            <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Terdaftar Sejak</p>
                            <p class="mt-1 text-sm text-gray-900 dark:text-white">
                                {{ $user->created_at->timeZone('Asia/Jakarta')->format('d F Y') }}
                            </p>
                        </div>
                    </div>

                    <!-- Last Updated -->
                    <div class="flex items-start space-x-3">
                        <div
                            class="flex-shrink-0 w-10 h-10 bg-orange-100 dark:bg-orange-900/30 rounded-lg flex items-center justify-center">
                            <iconify-icon icon="heroicons:clock-solid"
                                class="w-5 h-5 text-orange-600 dark:text-orange-400"></iconify-icon>
                        </div>
                        <div class="flex-1 min-w-0">
                            <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Terakhir Diperbarui</p>
                            <p class="mt-1 text-sm text-gray-900 dark:text-white">
                                {{ $user->updated_at->timeZone('Asia/Jakarta')->format('d F Y, H:i') }}
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Security Card -->
        <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-sm border border-gray-100 dark:border-gray-700 p-6">
            <div class="flex items-center mb-6">
                <div class="flex-shrink-0">
                    <div
                        class="w-10 h-10 bg-gradient-to-r from-red-500 to-pink-600 rounded-lg flex items-center justify-center">
                        <iconify-icon icon="heroicons:lock-closed-solid" class="w-5 h-5 text-white"></iconify-icon>
                    </div>
                </div>
                <div class="ml-4">
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-white">Keamanan Akun</h3>
                    <p class="text-sm text-gray-600 dark:text-gray-400">Kelola password dan keamanan akun Anda</p>
                </div>
            </div>

            <div class="space-y-4">
                <div class="flex items-center justify-between p-4 bg-gray-50 dark:bg-gray-700/50 rounded-lg">
                    <div class="flex items-center space-x-3">
                        <iconify-icon icon="heroicons:key-solid" class="w-5 h-5 text-gray-400"></iconify-icon>
                        <div>
                            <p class="text-sm font-medium text-gray-900 dark:text-white">Password</p>
                        </div>
                    </div>
                    <a href="{{ route('admin.profile.edit') }}#password-section"
                        class="text-sm font-medium text-indigo-600 hover:text-indigo-700 dark:text-indigo-400 dark:hover:text-indigo-300">
                        Ubah Password
                    </a>
                </div>
            </div>
        </div>
    </div>
@endsection
