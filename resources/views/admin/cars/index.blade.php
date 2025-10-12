@extends('layouts.admin')

@section('title', 'Cars Management')
@section('page-title', 'Cars Management')
@section('page-subtitle', 'Manage your rental car fleet')

@section('content')
    <!-- Search and Filter Bar -->
    <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-sm border border-gray-100 dark:border-gray-700 p-6 mb-6">
        <form method="GET" action="{{ route('admin.cars.index') }}" class="flex flex-col md:flex-row gap-4">
            <!-- Search -->
            <div class="flex-1">
                <div class="relative">
                    <input type="text" name="search" value="{{ request('search') }}"
                        placeholder="Search cars by name, brand, model, or license plate..."
                        class="w-full px-4 py-2 pl-10 pr-4 text-sm bg-gray-50 dark:bg-gray-700 border border-gray-200 dark:border-gray-600 rounded-xl focus:ring-2 focus:ring-indigo-500 dark:focus:ring-indigo-400 focus:border-transparent">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <iconify-icon icon="heroicons:magnifying-glass-20-solid"
                            class="w-4 h-4 text-gray-400"></iconify-icon>
                    </div>
                </div>
            </div>

            <!-- Filters -->
            <div class="flex gap-3">
                <select name="status"
                    class="px-3 py-2 text-sm bg-gray-50 dark:bg-gray-700 border border-gray-200 dark:border-gray-600 rounded-xl focus:ring-2 focus:ring-indigo-500">
                    <option value="">All Status</option>
                    <option value="available" {{ request('status') == 'available' ? 'selected' : '' }}>Available</option>
                    <option value="rented" {{ request('status') == 'rented' ? 'selected' : '' }}>Rented</option>
                    <option value="maintenance" {{ request('status') == 'maintenance' ? 'selected' : '' }}>Maintenance
                    </option>
                </select>

                <select name="brand"
                    class="px-3 py-2 text-sm bg-gray-50 dark:bg-gray-700 border border-gray-200 dark:border-gray-600 rounded-xl focus:ring-2 focus:ring-indigo-500">
                    <option value="">All Brands</option>
                    @foreach ($brands as $brand)
                        <option value="{{ $brand }}" {{ request('brand') == $brand ? 'selected' : '' }}>
                            {{ $brand }}</option>
                    @endforeach
                </select>

                <button type="submit"
                    class="px-4 py-2 bg-indigo-600 hover:bg-indigo-700 text-white text-sm font-medium rounded-xl transition-colors duration-200">
                    Filter
                </button>

                @if (request()->hasAny(['search', 'status', 'brand']))
                    <a href="{{ route('admin.cars.index') }}"
                        class="px-4 py-2 bg-gray-500 hover:bg-gray-600 text-white text-sm font-medium rounded-xl transition-colors duration-200">
                        Clear
                    </a>
                @endif
            </div>
        </form>
    </div>

    <!-- Header with Add Button -->
    <div class="flex items-center justify-between mb-6">
        <div>
            <h3 class="text-lg font-semibold text-gray-800 dark:text-white">Car Fleet ({{ $cars->total() }})</h3>
            <p class="text-sm text-gray-500 dark:text-gray-400">Manage your rental cars inventory</p>
        </div>

        <a href="{{ route('admin.cars.create') }}"
            class="inline-flex items-center px-4 py-2 bg-indigo-600 hover:bg-indigo-700 text-white text-sm font-medium rounded-xl transition-all duration-200 shadow-sm hover:shadow-md">
            <iconify-icon icon="heroicons:plus-20-solid" class="w-4 h-4 mr-2"></iconify-icon>
            Add New Car
        </a>
    </div>

    <!-- Cars Grid -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6 mb-6">
        @forelse($cars as $car)
            <div
                class="bg-white dark:bg-gray-800 rounded-2xl shadow-sm border border-gray-100 dark:border-gray-700 overflow-hidden hover:shadow-md transition-all duration-200">
                <!-- Car Image -->
                <div class="relative h-48 bg-gray-200 dark:bg-gray-700">
                    @if ($car->image)
                        <img src="{{ asset($car->image) }}" alt="{{ $car->name }}" class="w-full h-full object-cover">
                    @else
                        <div class="flex items-center justify-center h-full">
                            <iconify-icon icon="heroicons:truck-20-solid" width="64" height="64"
                                class="text-gray-400"></iconify-icon>
                        </div>
                    @endif

                    <!-- Status Badge -->
                    <div class="absolute top-3 right-3">
                        @php
                            $statusClasses = [
                                'available' =>
                                    'bg-emerald-100 dark:bg-emerald-900/50 text-emerald-800 dark:text-emerald-300',
                                'rented' => 'bg-blue-100 dark:bg-blue-900/50 text-blue-800 dark:text-blue-300',
                                'maintenance' => 'bg-amber-100 dark:bg-amber-900/50 text-amber-800 dark:text-amber-300',
                            ];
                        @endphp
                        <span
                            class="inline-flex px-2 py-1 text-xs font-medium rounded-full {{ $statusClasses[$car->status] }}">
                            {{ ucfirst($car->status) }}
                        </span>
                    </div>
                </div>

                <!-- Car Details -->
                <div class="p-4">
                    <div class="mb-3">
                        <h4 class="text-lg font-semibold text-gray-800 dark:text-white mb-1">{{ $car->name }}</h4>
                        <p class="text-sm text-gray-500 dark:text-gray-400">{{ $car->brand }} {{ $car->model }}
                            ({{ $car->year }})
                        </p>
                    </div>

                    <div class="space-y-2 mb-4">
                        <div class="flex items-center text-sm text-gray-600 dark:text-gray-400">
                            <iconify-icon icon="heroicons:identification-20-solid" class="w-4 h-4 mr-2"></iconify-icon>
                            {{ $car->license_plate }}
                        </div>
                        <div class="flex items-center text-sm text-gray-600 dark:text-gray-400">
                            <iconify-icon icon="heroicons:users-20-solid" class="w-4 h-4 mr-2"></iconify-icon>
                            {{ $car->seats }} seats
                        </div>
                        <div class="flex items-center text-sm text-gray-600 dark:text-gray-400">
                            <iconify-icon icon="heroicons:banknotes-20-solid" class="w-4 h-4 mr-2"></iconify-icon>
                            {{ $car->formatted_price }}/day
                        </div>
                    </div>

                    <!-- Action Buttons -->
                    <div class="flex gap-2">
                        <a href="{{ route('admin.cars.show', $car) }}"
                            class="flex-1 px-3 py-2 bg-gray-100 dark:bg-gray-700 hover:bg-gray-200 dark:hover:bg-gray-600 text-gray-700 dark:text-gray-300 text-xs font-medium rounded-lg transition-colors duration-200 text-center">
                            View
                        </a>
                        <a href="{{ route('admin.cars.edit', $car) }}"
                            class="flex-1 px-3 py-2 bg-indigo-100 dark:bg-indigo-900/50 hover:bg-indigo-200 dark:hover:bg-indigo-900/70 text-indigo-700 dark:text-indigo-300 text-xs font-medium rounded-lg transition-colors duration-200 text-center">
                            Edit
                        </a>
                        <form action="{{ route('admin.cars.destroy', $car) }}" method="POST" class="inline"
                            onsubmit="return confirm('Are you sure you want to delete this car?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit"
                                class="px-3 py-2 bg-red-100 dark:bg-red-900/50 hover:bg-red-200 dark:hover:bg-red-900/70 text-red-700 dark:text-red-300 text-xs font-medium rounded-lg transition-colors duration-200">
                                Delete
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        @empty
            <div class="col-span-full">
                <div
                    class="bg-white dark:bg-gray-800 rounded-2xl shadow-sm border border-gray-100 dark:border-gray-700 p-12 text-center">
                    <iconify-icon icon="heroicons:truck-20-solid"
                        class="w-16 h-16 text-gray-400 mx-auto mb-4"></iconify-icon>
                    <h3 class="text-lg font-medium text-gray-800 dark:text-white mb-2">No cars found</h3>
                    <p class="text-gray-500 dark:text-gray-400 mb-6">Get started by adding your first rental car to the
                        fleet.</p>
                    <a href="{{ route('admin.cars.create') }}"
                        class="inline-flex items-center px-4 py-2 bg-indigo-600 hover:bg-indigo-700 text-white font-medium rounded-xl transition-colors duration-200">
                        <iconify-icon icon="heroicons:plus-20-solid" class="w-4 h-4 mr-2"></iconify-icon>
                        Add Your First Car
                    </a>
                </div>
            </div>
        @endforelse
    </div>

    <!-- Pagination -->
    @if ($cars->hasPages())
        <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-sm border border-gray-100 dark:border-gray-700 p-6">
            {{ $cars->links() }}
        </div>
    @endif
@endsection
