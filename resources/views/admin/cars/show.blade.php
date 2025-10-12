@extends('layouts.admin')

@section('title', 'Car Details - ' . $car->name)
@section('page-title', 'Car Details')
@section('page-subtitle', 'View complete car information and rental history')

@section('content')
    <div class="max-w-6xl mx-auto">
        <!-- Car Header -->
        <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-sm border border-gray-100 dark:border-gray-700 mb-6">
            <div class="px-6 py-4 border-b border-gray-200 dark:border-gray-700">
                <div class="flex items-center justify-between">
                    <div>
                        <h3 class="text-2xl font-bold text-gray-800 dark:text-white">{{ $car->name }}</h3>
                        <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">{{ $car->full_name }}</p>
                    </div>

                    <div class="flex items-center space-x-2">
                        @php
                            $statusClasses = [
                                'available' =>
                                    'bg-emerald-100 dark:bg-emerald-900/50 text-emerald-800 dark:text-emerald-300',
                                'rented' => 'bg-blue-100 dark:bg-blue-900/50 text-blue-800 dark:text-blue-300',
                                'maintenance' => 'bg-amber-100 dark:bg-amber-900/50 text-amber-800 dark:text-amber-300',
                            ];
                        @endphp
                        <span
                            class="inline-flex px-3 py-1 text-sm font-medium rounded-full {{ $statusClasses[$car->status] }}">
                            {{ ucfirst($car->status) }}
                        </span>
                        @if ($car->is_active)
                            <span
                                class="inline-flex px-3 py-1 text-sm font-medium rounded-full bg-green-100 dark:bg-green-900/50 text-green-800 dark:text-green-300">
                                Active
                            </span>
                        @else
                            <span
                                class="inline-flex px-3 py-1 text-sm font-medium rounded-full bg-red-100 dark:bg-red-900/50 text-red-800 dark:text-red-300">
                                Inactive
                            </span>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Action Buttons -->
            <div class="px-6 py-4 bg-gray-50 dark:bg-gray-700/50 flex items-center justify-between">
                <a href="{{ route('admin.cars.index') }}"
                    class="inline-flex items-center px-4 py-2 bg-gray-500 hover:bg-gray-600 text-white text-sm font-medium rounded-xl transition-colors duration-200">
                    <iconify-icon icon="heroicons:arrow-left-20-solid" class="w-4 h-4 mr-2"></iconify-icon>
                    Back to Cars
                </a>

                <div class="flex items-center space-x-2">
                    <a href="{{ route('admin.cars.edit', $car) }}"
                        class="inline-flex items-center px-4 py-2 bg-indigo-600 hover:bg-indigo-700 text-white text-sm font-medium rounded-xl transition-colors duration-200">
                        <iconify-icon icon="heroicons:pencil-20-solid" class="w-4 h-4 mr-2"></iconify-icon>
                        Edit Car
                    </a>

                    <form action="{{ route('admin.cars.destroy', $car) }}" method="POST" class="inline"
                        onsubmit="return confirm('Are you sure you want to delete this car? This action cannot be undone.')">
                        @csrf
                        @method('DELETE')
                        <button type="submit"
                            class="inline-flex items-center px-4 py-2 bg-red-600 hover:bg-red-700 text-white text-sm font-medium rounded-xl transition-colors duration-200">
                            <iconify-icon icon="heroicons:trash-20-solid" class="w-4 h-4 mr-2"></iconify-icon>
                            Delete
                        </button>
                    </form>
                </div>
            </div>
        </div>

        <!-- Car Details -->
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            <!-- Car Image and Basic Info -->
            <div class="lg:col-span-2 space-y-6">
                <!-- Image -->
                <div
                    class="bg-white dark:bg-gray-800 rounded-2xl shadow-sm border border-gray-100 dark:border-gray-700 overflow-hidden">
                    <div class="aspect-video bg-gray-200 dark:bg-gray-700">
                        @if ($car->image)
                            <img src="{{ asset($car->image) }}" alt="{{ $car->name }}"
                                class="w-full h-full object-cover">
                        @else
                            <div class="flex items-center justify-center h-full">
                                <div class="text-center">
                                    <iconify-icon icon="heroicons:truck-20-solid" width="64" height="64"
                                        class="text-gray-400 mx-auto mb-4"></iconify-icon>
                                    <p class="text-gray-500 dark:text-gray-400 font-medium">No image available</p>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>

                <!-- Specifications -->
                <div
                    class="bg-white dark:bg-gray-800 rounded-2xl shadow-sm border border-gray-100 dark:border-gray-700 p-6">
                    <h4 class="text-lg font-semibold text-gray-800 dark:text-white mb-6">Specifications</h4>

                    <div class="grid grid-cols-2 gap-6">
                        <div class="space-y-4">
                            <div class="flex items-center text-gray-600 dark:text-gray-400">
                                <iconify-icon icon="heroicons:tag-20-solid" class="w-5 h-5 mr-3"></iconify-icon>
                                <span class="text-sm font-medium">Brand: <span
                                        class="text-gray-900 dark:text-white">{{ $car->brand }}</span></span>
                            </div>

                            <div class="flex items-center text-gray-600 dark:text-gray-400">
                                <iconify-icon icon="heroicons:calendar-20-solid" class="w-5 h-5 mr-3"></iconify-icon>
                                <span class="text-sm font-medium">Year: <span
                                        class="text-gray-900 dark:text-white">{{ $car->year }}</span></span>
                            </div>

                            <div class="flex items-center text-gray-600 dark:text-gray-400">
                                <iconify-icon icon="heroicons:swatch-20-solid" class="w-5 h-5 mr-3"></iconify-icon>
                                <span class="text-sm font-medium">Color: <span
                                        class="text-gray-900 dark:text-white">{{ $car->color }}</span></span>
                            </div>

                            <div class="flex items-center text-gray-600 dark:text-gray-400">
                                <iconify-icon icon="heroicons:users-20-solid" class="w-5 h-5 mr-3"></iconify-icon>
                                <span class="text-sm font-medium">Seats: <span
                                        class="text-gray-900 dark:text-white">{{ $car->seats }} passengers</span></span>
                            </div>
                        </div>

                        <div class="space-y-4">
                            <div class="flex items-center text-gray-600 dark:text-gray-400">
                                <iconify-icon icon="heroicons:cog-6-tooth-20-solid" class="w-5 h-5 mr-3"></iconify-icon>
                                <span class="text-sm font-medium">Transmission: <span
                                        class="text-gray-900 dark:text-white">{{ ucfirst($car->transmission) }}</span></span>
                            </div>

                            <div class="flex items-center text-gray-600 dark:text-gray-400">
                                <iconify-icon icon="heroicons:fire-20-solid" class="w-5 h-5 mr-3"></iconify-icon>
                                <span class="text-sm font-medium">Fuel: <span
                                        class="text-gray-900 dark:text-white">{{ ucfirst($car->fuel_type) }}</span></span>
                            </div>

                            <div class="flex items-center text-gray-600 dark:text-gray-400">
                                <iconify-icon icon="heroicons:map-pin-20-solid" class="w-5 h-5 mr-3"></iconify-icon>
                                <span class="text-sm font-medium">License: <span
                                        class="text-gray-900 dark:text-white">{{ $car->license_plate }}</span></span>
                            </div>

                            <div class="flex items-center text-gray-600 dark:text-gray-400">
                                <iconify-icon icon="heroicons:banknotes-20-solid" class="w-5 h-5 mr-3"></iconify-icon>
                                <span class="text-sm font-medium">Price: <span
                                        class="text-gray-900 dark:text-white font-semibold">{{ $car->formatted_price }}/day</span></span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Features -->
                @if ($car->features && count($car->features) > 0)
                    <div
                        class="bg-white dark:bg-gray-800 rounded-2xl shadow-sm border border-gray-100 dark:border-gray-700 p-6">
                        <h4 class="text-lg font-semibold text-gray-800 dark:text-white mb-4">Features</h4>
                        <div class="grid grid-cols-2 md:grid-cols-3 gap-3">
                            @php
                                $featureLabels = [
                                    'air_conditioning' => 'Air Conditioning',
                                    'gps_navigation' => 'GPS Navigation',
                                    'bluetooth' => 'Bluetooth',
                                    'usb_charging' => 'USB Charging',
                                    'backup_camera' => 'Backup Camera',
                                    'leather_seats' => 'Leather Seats',
                                    'sunroof' => 'Sunroof',
                                    'cruise_control' => 'Cruise Control',
                                ];
                            @endphp
                            @foreach ($car->features as $feature)
                                <div class="flex items-center p-2 bg-gray-50 dark:bg-gray-700 rounded-lg">
                                    <iconify-icon icon="heroicons:check-20-solid"
                                        class="text-green-500 mr-2"></iconify-icon>
                                    <span
                                        class="text-sm text-gray-700 dark:text-gray-300">{{ $featureLabels[$feature] ?? ucfirst(str_replace('_', ' ', $feature)) }}</span>
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endif

                <!-- Description -->
                @if ($car->description)
                    <div
                        class="bg-white dark:bg-gray-800 rounded-2xl shadow-sm border border-gray-100 dark:border-gray-700 p-6">
                        <h4 class="text-lg font-semibold text-gray-800 dark:text-white mb-4">Description</h4>
                        <p class="text-gray-600 dark:text-gray-400 leading-relaxed">{{ $car->description }}</p>
                    </div>
                @endif
            </div>

            <!-- Sidebar -->
            <div class="space-y-6">
                <!-- Quick Stats -->
                <div
                    class="bg-white dark:bg-gray-800 rounded-2xl shadow-sm border border-gray-100 dark:border-gray-700 p-6">
                    <h4 class="text-lg font-semibold text-gray-800 dark:text-white mb-4">Quick Stats</h4>
                    <div class="space-y-3">
                        <div class="flex items-center justify-between">
                            <span class="text-sm text-gray-600 dark:text-gray-400">Total Orders</span>
                            <span
                                class="text-sm font-semibold text-gray-900 dark:text-white">{{ $car->orders->count() }}</span>
                        </div>
                        <div class="flex items-center justify-between">
                            <span class="text-sm text-gray-600 dark:text-gray-400">Active Orders</span>
                            <span
                                class="text-sm font-semibold text-gray-900 dark:text-white">{{ $car->orders->whereIn('status', ['confirmed', 'in_progress'])->count() }}</span>
                        </div>
                        <div class="flex items-center justify-between">
                            <span class="text-sm text-gray-600 dark:text-gray-400">Completed Orders</span>
                            <span
                                class="text-sm font-semibold text-gray-900 dark:text-white">{{ $car->orders->where('status', 'completed')->count() }}</span>
                        </div>
                    </div>
                </div>

                <!-- Recent Orders -->
                @if ($car->orders->count() > 0)
                    <div
                        class="bg-white dark:bg-gray-800 rounded-2xl shadow-sm border border-gray-100 dark:border-gray-700 p-6">
                        <h4 class="text-lg font-semibold text-gray-800 dark:text-white mb-4">Recent Orders</h4>
                        <div class="space-y-3">
                            @foreach ($car->orders->take(5) as $order)
                                <div class="p-3 border border-gray-200 dark:border-gray-600 rounded-lg">
                                    <div class="flex items-center justify-between mb-2">
                                        <span
                                            class="text-sm font-medium text-gray-900 dark:text-white">{{ $order->order_number }}</span>
                                        <span
                                            class="inline-flex px-2 py-1 text-xs font-medium rounded-full {{ $order->status_badge }}">
                                            {{ ucfirst($order->status) }}
                                        </span>
                                    </div>
                                    <div class="text-xs text-gray-500 dark:text-gray-400">
                                        <p>{{ $order->user->name ?? 'Unknown Customer' }}</p>
                                        <p>{{ $order->created_at->format('M d, Y') }}</p>
                                    </div>
                                </div>
                            @endforeach
                        </div>

                        @if ($car->orders->count() > 5)
                            <div class="mt-4 text-center">
                                <a href="{{ route('admin.orders.index', ['car_id' => $car->id]) }}"
                                    class="text-sm text-indigo-600 dark:text-indigo-400 hover:text-indigo-800 dark:hover:text-indigo-300 font-medium">
                                    View All Orders ({{ $car->orders->count() }})
                                </a>
                            </div>
                        @endif
                    </div>
                @else
                    <div
                        class="bg-white dark:bg-gray-800 rounded-2xl shadow-sm border border-gray-100 dark:border-gray-700 p-6 text-center">
                        <iconify-icon icon="heroicons:clipboard-document-list-20-solid" width="64" height="64"
                            class="text-gray-400 mx-auto mb-3"></iconify-icon>
                        <h5 class="text-sm font-medium text-gray-900 dark:text-white mb-1">No Orders Yet</h5>
                        <p class="text-xs text-gray-500 dark:text-gray-400">This car hasn't been rented yet.</p>
                    </div>
                @endif
            </div>
        </div>
    </div>
@endsection
