@extends('layouts.admin')

@section('title', 'Order Details - ' . $order->order_number)
@section('page-title', 'Order Details')
@section('page-subtitle', 'View complete order information and rental history')

@section('content')
    <div class="max-w-6xl mx-auto">
        <!-- Order Header -->
        <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-sm border border-gray-100 dark:border-gray-700 mb-6">
            <div class="px-6 py-4 border-b border-gray-200 dark:border-gray-700">
                <div class="flex items-center justify-between">
                    <div>
                        <h3 class="text-2xl font-bold text-gray-800 dark:text-white">{{ $order->order_number }}</h3>
                        <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">Created on
                            {{ $order->created_at->format('M d, Y \a\t H:i') }}</p>
                    </div>

                    <div class="flex items-center space-x-3">
                        @php
                            $statusClasses = [
                                'pending' => 'bg-yellow-100 dark:bg-yellow-900/50 text-yellow-800 dark:text-yellow-300',
                                'confirmed' => 'bg-blue-100 dark:bg-blue-900/50 text-blue-800 dark:text-blue-300',
                                'in_progress' =>
                                    'bg-purple-100 dark:bg-purple-900/50 text-purple-800 dark:text-purple-300',
                                'completed' => 'bg-green-100 dark:bg-green-900/50 text-green-800 dark:text-green-300',
                                'cancelled' => 'bg-red-100 dark:bg-red-900/50 text-red-800 dark:text-red-300',
                            ];

                            $paymentStatusClasses = [
                                'pending' => 'bg-orange-100 dark:bg-orange-900/50 text-orange-800 dark:text-orange-300',
                                'paid' =>
                                    'bg-emerald-100 dark:bg-emerald-900/50 text-emerald-800 dark:text-emerald-300',
                                'cancelled' => 'bg-gray-100 dark:bg-gray-900/50 text-gray-800 dark:text-gray-300',
                            ];
                        @endphp

                        <span
                            class="inline-flex px-3 py-1 text-sm font-medium rounded-full {{ $statusClasses[$order->status] }}">
                            {{ ucfirst($order->status) }}
                        </span>

                        <span
                            class="inline-flex px-3 py-1 text-sm font-medium rounded-full {{ $paymentStatusClasses[$order->payment_status] }}">
                            {{ ucfirst(str_replace('_', ' ', $order->payment_status)) }}
                        </span>
                    </div>
                </div>
            </div>

            <!-- Action Buttons -->
            <div class="px-6 py-4 bg-gray-50 dark:bg-gray-700/50 flex items-center justify-between">
                <a href="{{ route('admin.orders.index') }}"
                    class="inline-flex items-center px-4 py-2 bg-gray-500 hover:bg-gray-600 text-white text-sm font-medium rounded-xl transition-colors duration-200">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                    </svg>
                    Back to Orders
                </a>

                <div class="flex items-center space-x-2">
                    <a href="{{ route('admin.orders.edit', $order) }}"
                        class="inline-flex items-center px-4 py-2 bg-indigo-600 hover:bg-indigo-700 text-white text-sm font-medium rounded-xl transition-colors duration-200">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                        </svg>
                        Edit Order
                    </a>

                    <form action="{{ route('admin.orders.destroy', $order) }}" method="POST" class="inline"
                        onsubmit="return confirm('Are you sure you want to delete this order? This action cannot be undone.')">
                        @csrf
                        @method('DELETE')
                        <button type="submit"
                            class="inline-flex items-center px-4 py-2 bg-red-600 hover:bg-red-700 text-white text-sm font-medium rounded-xl transition-colors duration-200">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                            </svg>
                            Delete
                        </button>
                    </form>
                </div>
            </div>
        </div>

        <!-- Order Details -->
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            <!-- Main Content -->
            <div class="lg:col-span-2 space-y-6">
                <!-- Customer Information -->
                <div
                    class="bg-white dark:bg-gray-800 rounded-2xl shadow-sm border border-gray-100 dark:border-gray-700 p-6">
                    <h4 class="text-lg font-semibold text-gray-800 dark:text-white mb-4 flex items-center">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                        </svg>
                        Customer Information
                    </h4>

                    <div class="space-y-4">
                        <div class="flex items-center justify-between">
                            <span class="text-sm font-medium text-gray-600 dark:text-gray-400">Name:</span>
                            <span
                                class="text-sm text-gray-900 dark:text-white">{{ $order->user->name ?? 'Unknown Customer' }}</span>
                        </div>
                        <div class="flex items-center justify-between">
                            <span class="text-sm font-medium text-gray-600 dark:text-gray-400">Email:</span>
                            <span class="text-sm text-gray-900 dark:text-white">{{ $order->user->email ?? '-' }}</span>
                        </div>
                        <div class="flex items-center justify-between">
                            <span class="text-sm font-medium text-gray-600 dark:text-gray-400">Phone:</span>
                            <span
                                class="text-sm text-gray-900 dark:text-white">{{ $order->user->phone ?? 'Not provided' }}</span>
                        </div>
                    </div>
                </div>

                <!-- Car Information -->
                <div
                    class="bg-white dark:bg-gray-800 rounded-2xl shadow-sm border border-gray-100 dark:border-gray-700 p-6">
                    <h4 class="text-lg font-semibold text-gray-800 dark:text-white mb-4 flex items-center">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10" />
                        </svg>
                        Car Information
                    </h4>

                    <div class="flex items-start space-x-4">
                        <div class="w-24 h-24 bg-gray-200 dark:bg-gray-600 rounded-xl overflow-hidden flex-shrink-0">
                            @if ($order->car->image)
                                <img src="{{ asset($order->car->image) }}" alt="{{ $order->car->name }}"
                                    class="w-full h-full object-cover">
                            @else
                                <div class="w-full h-full flex items-center justify-center">
                                    <svg class="w-8 h-8 text-gray-400" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10" />
                                    </svg>
                                </div>
                            @endif
                        </div>

                        <div class="flex-1 space-y-3">
                            <div>
                                <h5 class="text-lg font-semibold text-gray-900 dark:text-white">{{ $order->car->name }}
                                </h5>
                                <p class="text-sm text-gray-500 dark:text-gray-400">{{ $order->car->brand }}
                                    {{ $order->car->model }} ({{ $order->car->year }})</p>
                            </div>

                            <div class="grid grid-cols-2 gap-4 text-sm">
                                <div class="flex items-center text-gray-600 dark:text-gray-400">
                                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M7 11.5V14m0-2.5v-6a1.5 1.5 0 113 0m-3 6a1.5 1.5 0 00-3 0v2a7.5 7.5 0 0015 0v-5a1.5 1.5 0 00-3 0m-6-3V11m0-5.5v-1a1.5 1.5 0 013 0v1m0 0V11m0-5.5a1.5 1.5 0 013 0v3m0 0V11" />
                                    </svg>
                                    {{ $order->car->color }}
                                </div>
                                <div class="flex items-center text-gray-600 dark:text-gray-400">
                                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197m13.5-9a2.5 2.5 0 11-5 0 2.5 2.5 0 015 0z" />
                                    </svg>
                                    {{ $order->car->seats }} seats
                                </div>
                                <div class="flex items-center text-gray-600 dark:text-gray-400">
                                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z" />
                                    </svg>
                                    {{ ucfirst($order->car->transmission) }}
                                </div>
                                <div class="flex items-center text-gray-600 dark:text-gray-400">
                                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M17.657 18.657A8 8 0 016.343 7.343S7 9 9 10c0-2 .5-5 2.986-7C14 5 16.09 5.777 17.656 7.343A7.975 7.975 0 0120 13a7.975 7.975 0 01-2.343 5.657z" />
                                    </svg>
                                    {{ ucfirst($order->car->fuel_type) }}
                                </div>
                            </div>

                            <div class="pt-2">
                                <a href="{{ route('admin.cars.show', $order->car) }}"
                                    class="inline-flex items-center text-sm text-indigo-600 dark:text-indigo-400 hover:text-indigo-800 dark:hover:text-indigo-300">
                                    View Car Details
                                    <svg class="w-4 h-4 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M9 5l7 7-7 7" />
                                    </svg>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Notes -->
                @if ($order->notes)
                    <div
                        class="bg-white dark:bg-gray-800 rounded-2xl shadow-sm border border-gray-100 dark:border-gray-700 p-6">
                        <h4 class="text-lg font-semibold text-gray-800 dark:text-white mb-4 flex items-center">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                            </svg>
                            Notes
                        </h4>
                        <p class="text-gray-600 dark:text-gray-400 leading-relaxed">{{ $order->notes }}</p>
                    </div>
                @endif
            </div>

            <!-- Sidebar -->
            <div class="space-y-6">
                <!-- Rental Summary -->
                <div
                    class="bg-white dark:bg-gray-800 rounded-2xl shadow-sm border border-gray-100 dark:border-gray-700 p-6">
                    <h4 class="text-lg font-semibold text-gray-800 dark:text-white mb-4">Rental Summary</h4>

                    <div class="space-y-4">
                        <div class="flex items-center justify-between">
                            <span class="text-sm text-gray-600 dark:text-gray-400">Start Date:</span>
                            <span class="text-sm font-medium text-gray-900 dark:text-white">
                                {{ \Carbon\Carbon::parse($order->start_date)->format('M d, Y') }}
                            </span>
                        </div>

                        <div class="flex items-center justify-between">
                            <span class="text-sm text-gray-600 dark:text-gray-400">End Date:</span>
                            <span class="text-sm font-medium text-gray-900 dark:text-white">
                                {{ \Carbon\Carbon::parse($order->end_date)->format('M d, Y') }}
                            </span>
                        </div>

                        <div class="flex items-center justify-between">
                            <span class="text-sm text-gray-600 dark:text-gray-400">Duration:</span>
                            <span class="text-sm font-medium text-gray-900 dark:text-white">
                                {{ $order->total_days }} day{{ $order->total_days > 1 ? 's' : '' }}
                            </span>
                        </div>

                        <div class="flex items-center justify-between">
                            <span class="text-sm text-gray-600 dark:text-gray-400">Price per Day:</span>
                            <span class="text-sm font-medium text-gray-900 dark:text-white">
                                Rp {{ number_format($order->car->price_per_day, 0, ',', '.') }}
                            </span>
                        </div>

                        <div class="border-t border-gray-200 dark:border-gray-600 pt-4">
                            <div class="flex items-center justify-between">
                                <span class="text-base font-semibold text-gray-900 dark:text-white">Total Amount:</span>
                                <span class="text-lg font-bold text-indigo-600 dark:text-indigo-400">
                                    Rp {{ number_format($order->total_amount, 0, ',', '.') }}
                                </span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Quick Actions -->
                <div
                    class="bg-white dark:bg-gray-800 rounded-2xl shadow-sm border border-gray-100 dark:border-gray-700 p-6">
                    <h4 class="text-lg font-semibold text-gray-800 dark:text-white mb-4">Quick Actions</h4>

                    <div class="space-y-3">
                        @if ($order->status === 'pending')
                            <form action="{{ route('admin.orders.update', $order) }}" method="POST" class="w-full">
                                @csrf
                                @method('PATCH')
                                <input type="hidden" name="status" value="confirmed">
                                <button type="submit"
                                    class="w-full px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white text-sm font-medium rounded-lg transition-colors duration-200">
                                    Confirm Order
                                </button>
                            </form>
                        @endif

                        @if ($order->status === 'confirmed')
                            <form action="{{ route('admin.orders.update', $order) }}" method="POST" class="w-full">
                                @csrf
                                @method('PATCH')
                                <input type="hidden" name="status" value="in_progress">
                                <button type="submit"
                                    class="w-full px-4 py-2 bg-purple-600 hover:bg-purple-700 text-white text-sm font-medium rounded-lg transition-colors duration-200">
                                    Start Rental
                                </button>
                            </form>
                        @endif

                        @if ($order->status === 'in_progress')
                            <form action="{{ route('admin.orders.update', $order) }}" method="POST" class="w-full">
                                @csrf
                                @method('PATCH')
                                <input type="hidden" name="status" value="completed">
                                <button type="submit"
                                    class="w-full px-4 py-2 bg-green-600 hover:bg-green-700 text-white text-sm font-medium rounded-lg transition-colors duration-200">
                                    Complete Rental
                                </button>
                            </form>
                        @endif

                        @if (in_array($order->status, ['pending', 'confirmed']))
                            <form action="{{ route('admin.orders.update', $order) }}" method="POST" class="w-full">
                                @csrf
                                @method('PATCH')
                                <input type="hidden" name="status" value="cancelled">
                                <button type="submit"
                                    class="w-full px-4 py-2 bg-red-600 hover:bg-red-700 text-white text-sm font-medium rounded-lg transition-colors duration-200"
                                    onclick="return confirm('Are you sure you want to cancel this order?')">
                                    Cancel Order
                                </button>
                            </form>
                        @endif

                        @if ($order->payment_status === 'pending')
                            <form action="{{ route('admin.orders.update', $order) }}" method="POST" class="w-full">
                                @csrf
                                @method('PATCH')
                                <input type="hidden" name="payment_status" value="paid">
                                <button type="submit"
                                    class="w-full px-4 py-2 bg-emerald-600 hover:bg-emerald-700 text-white text-sm font-medium rounded-lg transition-colors duration-200">
                                    Mark as Paid
                                </button>
                            </form>
                        @endif
                    </div>
                </div>

                <!-- Order Timeline -->
                <div
                    class="bg-white dark:bg-gray-800 rounded-2xl shadow-sm border border-gray-100 dark:border-gray-700 p-6">
                    <h4 class="text-lg font-semibold text-gray-800 dark:text-white mb-4">Order Timeline</h4>

                    <div class="space-y-4">
                        <div class="flex items-start">
                            <div class="flex-shrink-0 w-2 h-2 bg-blue-500 rounded-full mt-2 mr-3"></div>
                            <div class="flex-1">
                                <p class="text-sm font-medium text-gray-900 dark:text-white">Order Created</p>
                                <p class="text-xs text-gray-500 dark:text-gray-400">
                                    {{ $order->created_at->format('M d, Y \a\t H:i') }}</p>
                            </div>
                        </div>

                        @if ($order->updated_at->ne($order->created_at))
                            <div class="flex items-start">
                                <div class="flex-shrink-0 w-2 h-2 bg-gray-400 rounded-full mt-2 mr-3"></div>
                                <div class="flex-1">
                                    <p class="text-sm font-medium text-gray-900 dark:text-white">Last Updated</p>
                                    <p class="text-xs text-gray-500 dark:text-gray-400">
                                        {{ $order->updated_at->format('M d, Y \a\t H:i') }}</p>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
