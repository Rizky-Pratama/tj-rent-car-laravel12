@extends('layouts.admin')

@section('title', 'Orders Management')
@section('page-title', 'Orders')
@section('page-subtitle', 'Manage rental orders and bookings')

@section('content')
    <div class="space-y-6">
        <!-- Header Actions -->
        <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
            <div class="flex items-center space-x-4">
                <!-- Search -->
                <form method="GET" action="{{ route('admin.orders.index') }}" class="flex items-center space-x-2">
                    <div class="relative">
                        <input type="text" name="search" value="{{ request('search') }}" placeholder="Search orders..."
                            class="pl-10 pr-4 py-2 w-64 text-sm border border-gray-300 dark:border-gray-600 rounded-xl bg-white dark:bg-gray-700 text-gray-900 dark:text-white placeholder-gray-500 dark:placeholder-gray-400 focus:ring-2 focus:ring-indigo-500 focus:border-transparent">
                        <iconify-icon icon="heroicons:magnifying-glass-20-solid"
                            class="absolute left-3 top-2.5 w-4 h-4 text-gray-400"></iconify-icon>
                    </div>

                    <!-- Status Filter -->
                    <select name="status"
                        class="px-3 py-2 text-sm border border-gray-300 dark:border-gray-600 rounded-xl bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-indigo-500 focus:border-transparent">
                        <option value="">All Status</option>
                        <option value="pending" {{ request('status') === 'pending' ? 'selected' : '' }}>Pending</option>
                        <option value="confirmed" {{ request('status') === 'confirmed' ? 'selected' : '' }}>Confirmed
                        </option>
                        <option value="in_progress" {{ request('status') === 'in_progress' ? 'selected' : '' }}>In Progress
                        </option>
                        <option value="completed" {{ request('status') === 'completed' ? 'selected' : '' }}>Completed
                        </option>
                        <option value="cancelled" {{ request('status') === 'cancelled' ? 'selected' : '' }}>Cancelled
                        </option>
                    </select>

                    <!-- Car Filter -->
                    <select name="car_id"
                        class="px-3 py-2 text-sm border border-gray-300 dark:border-gray-600 rounded-xl bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-indigo-500 focus:border-transparent">
                        <option value="">All Cars</option>
                        @foreach (\App\Models\Car::orderBy('name')->get() as $car)
                            <option value="{{ $car->id }}" {{ request('car_id') == $car->id ? 'selected' : '' }}>
                                {{ $car->name }}
                            </option>
                        @endforeach
                    </select>

                    <button type="submit"
                        class="px-4 py-2 bg-gray-100 dark:bg-gray-700 hover:bg-gray-200 dark:hover:bg-gray-600 text-gray-700 dark:text-gray-300 text-sm font-medium rounded-xl transition-colors duration-200">
                        Filter
                    </button>

                    @if (request()->hasAny(['search', 'status', 'car_id']))
                        <a href="{{ route('admin.orders.index') }}"
                            class="px-4 py-2 bg-red-100 dark:bg-red-900/50 hover:bg-red-200 dark:hover:bg-red-900/70 text-red-700 dark:text-red-300 text-sm font-medium rounded-xl transition-colors duration-200">
                            Clear
                        </a>
                    @endif
                </form>
            </div>

            <div class="flex items-center space-x-2">
                <a href="{{ route('admin.orders.create') }}"
                    class="inline-flex items-center px-4 py-2 bg-indigo-600 hover:bg-indigo-700 text-white text-sm font-medium rounded-xl transition-colors duration-200">
                    <iconify-icon icon="heroicons:plus-20-solid" class="w-4 h-4 mr-2"></iconify-icon>
                    New Order
                </a>
            </div>
        </div>

        <!-- Orders Table -->
        @if ($orders->count() > 0)
            <div
                class="bg-white dark:bg-gray-800 rounded-2xl shadow-sm border border-gray-100 dark:border-gray-700 overflow-hidden">
                <div class="overflow-x-auto">
                    <table class="w-full">
                        <thead class="bg-gray-50 dark:bg-gray-700 border-b border-gray-200 dark:border-gray-600">
                            <tr>
                                <th
                                    class="px-6 py-4 text-left text-xs font-semibold text-gray-600 dark:text-gray-400 uppercase tracking-wider">
                                    Order</th>
                                <th
                                    class="px-6 py-4 text-left text-xs font-semibold text-gray-600 dark:text-gray-400 uppercase tracking-wider">
                                    Customer</th>
                                <th
                                    class="px-6 py-4 text-left text-xs font-semibold text-gray-600 dark:text-gray-400 uppercase tracking-wider">
                                    Car</th>
                                <th
                                    class="px-6 py-4 text-left text-xs font-semibold text-gray-600 dark:text-gray-400 uppercase tracking-wider">
                                    Rental Period</th>
                                <th
                                    class="px-6 py-4 text-left text-xs font-semibold text-gray-600 dark:text-gray-400 uppercase tracking-wider">
                                    Total</th>
                                <th
                                    class="px-6 py-4 text-left text-xs font-semibold text-gray-600 dark:text-gray-400 uppercase tracking-wider">
                                    Status</th>
                                <th
                                    class="px-6 py-4 text-left text-xs font-semibold text-gray-600 dark:text-gray-400 uppercase tracking-wider">
                                    Actions</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200 dark:divide-gray-600">
                            @foreach ($orders as $order)
                                <tr class="hover:bg-gray-50 dark:hover:bg-gray-700/50 transition-colors duration-150">
                                    <!-- Order Info -->
                                    <td class="px-6 py-4">
                                        <div>
                                            <div class="text-sm font-medium text-gray-900 dark:text-white">
                                                {{ $order->order_number }}
                                            </div>
                                            <div class="text-xs text-gray-500 dark:text-gray-400">
                                                {{ $order->created_at->format('M d, Y H:i') }}
                                            </div>
                                        </div>
                                    </td>

                                    <!-- Customer -->
                                    <td class="px-6 py-4">
                                        <div>
                                            <div class="text-sm font-medium text-gray-900 dark:text-white">
                                                {{ $order->user->name ?? 'Unknown' }}
                                            </div>
                                            <div class="text-xs text-gray-500 dark:text-gray-400">
                                                {{ $order->user->email ?? '-' }}
                                            </div>
                                        </div>
                                    </td>

                                    <!-- Car -->
                                    <td class="px-6 py-4">
                                        <div class="flex items-center">
                                            @if ($order->car->image)
                                                <img src="{{ asset($order->car->image) }}" alt="{{ $order->car->name }}"
                                                    class="w-10 h-10 rounded-lg object-cover mr-3">
                                            @else
                                                <div
                                                    class="w-10 h-10 bg-gray-200 dark:bg-gray-600 rounded-lg flex items-center justify-center mr-3">
                                                    <iconify-icon icon="heroicons:truck-20-solid"
                                                        class="w-5 h-5 text-gray-400"></iconify-icon>
                                                </div>
                                            @endif
                                            <div>
                                                <div class="text-sm font-medium text-gray-900 dark:text-white">
                                                    {{ $order->car->name }}
                                                </div>
                                                <div class="text-xs text-gray-500 dark:text-gray-400">
                                                    {{ $order->car->brand }} {{ $order->car->model }}
                                                </div>
                                            </div>
                                        </div>
                                    </td>

                                    <!-- Rental Period -->
                                    <td class="px-6 py-4">
                                        <div class="text-sm text-gray-900 dark:text-white">
                                            {{ \Carbon\Carbon::parse($order->start_date)->format('M d') }} -
                                            {{ \Carbon\Carbon::parse($order->end_date)->format('M d, Y') }}
                                        </div>
                                        <div class="text-xs text-gray-500 dark:text-gray-400">
                                            {{ $order->total_days }} day{{ $order->total_days > 1 ? 's' : '' }}
                                        </div>
                                    </td>

                                    <!-- Total -->
                                    <td class="px-6 py-4">
                                        <div class="text-sm font-semibold text-gray-900 dark:text-white">
                                            Rp {{ number_format($order->total_amount, 0, ',', '.') }}
                                        </div>
                                    </td>

                                    <!-- Status -->
                                    <td class="px-6 py-4">
                                        @php
                                            $statusClasses = [
                                                'pending' =>
                                                    'bg-yellow-100 dark:bg-yellow-900/50 text-yellow-800 dark:text-yellow-300',
                                                'confirmed' =>
                                                    'bg-blue-100 dark:bg-blue-900/50 text-blue-800 dark:text-blue-300',
                                                'in_progress' =>
                                                    'bg-purple-100 dark:bg-purple-900/50 text-purple-800 dark:text-purple-300',
                                                'completed' =>
                                                    'bg-green-100 dark:bg-green-900/50 text-green-800 dark:text-green-300',
                                                'cancelled' =>
                                                    'bg-red-100 dark:bg-red-900/50 text-red-800 dark:text-red-300',
                                            ];
                                        @endphp
                                        <span
                                            class="inline-flex px-2 py-1 text-xs font-medium rounded-full {{ $statusClasses[$order->status] }}">
                                            {{ ucfirst($order->status) }}
                                        </span>
                                    </td>

                                    <!-- Actions -->
                                    <td class="px-6 py-4">
                                        <div class="flex items-center space-x-2">
                                            <a href="{{ route('admin.orders.show', $order) }}"
                                                class="p-2 bg-gray-100 dark:bg-gray-700 hover:bg-gray-200 dark:hover:bg-gray-600 text-gray-600 dark:text-gray-300 rounded-lg transition-colors duration-200"
                                                title="View Details">
                                                <iconify-icon icon="heroicons:eye-20-solid" class="w-4 h-4"></iconify-icon>
                                            </a>

                                            <a href="{{ route('admin.orders.edit', $order) }}"
                                                class="p-2 bg-indigo-100 dark:bg-indigo-900/50 hover:bg-indigo-200 dark:hover:bg-indigo-900/70 text-indigo-600 dark:text-indigo-400 rounded-lg transition-colors duration-200"
                                                title="Edit Order">
                                                <iconify-icon icon="heroicons:pencil-20-solid"
                                                    class="w-4 h-4"></iconify-icon>
                                            </a>

                                            <form action="{{ route('admin.orders.destroy', $order) }}" method="POST"
                                                class="inline"
                                                onsubmit="return confirm('Are you sure you want to delete this order?')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit"
                                                    class="p-2 bg-red-100 dark:bg-red-900/50 hover:bg-red-200 dark:hover:bg-red-900/70 text-red-600 dark:text-red-400 rounded-lg transition-colors duration-200"
                                                    title="Delete Order">
                                                    <iconify-icon icon="heroicons:trash-20-solid"
                                                        class="w-4 h-4"></iconify-icon>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <!-- Pagination -->
                @if ($orders->hasPages())
                    <div class="px-6 py-4 border-t border-gray-200 dark:border-gray-600">
                        {{ $orders->withQueryString()->links() }}
                    </div>
                @endif
            </div>
        @else
            <!-- Empty State -->
            <div
                class="bg-white dark:bg-gray-800 rounded-2xl shadow-sm border border-gray-100 dark:border-gray-700 p-12 text-center">
                <iconify-icon icon="heroicons:clipboard-document-list-20-solid"
                    class="w-24 h-24 text-gray-400 mx-auto mb-6"></iconify-icon>
                <h3 class="text-xl font-semibold text-gray-900 dark:text-white mb-2">No orders found</h3>
                <p class="text-gray-500 dark:text-gray-400 mb-6 max-w-md mx-auto">
                    @if (request()->hasAny(['search', 'status', 'car_id']))
                        No orders match your current filters. Try adjusting your search criteria.
                    @else
                        There are no rental orders yet. Create your first order to get started.
                    @endif
                </p>
                <div class="flex justify-center space-x-3">
                    @if (request()->hasAny(['search', 'status', 'car_id']))
                        <a href="{{ route('admin.orders.index') }}"
                            class="inline-flex items-center px-4 py-2 bg-gray-100 dark:bg-gray-700 hover:bg-gray-200 dark:hover:bg-gray-600 text-gray-700 dark:text-gray-300 text-sm font-medium rounded-xl transition-colors duration-200">
                            Clear Filters
                        </a>
                    @endif
                    <a href="{{ route('admin.orders.create') }}"
                        class="inline-flex items-center px-4 py-2 bg-indigo-600 hover:bg-indigo-700 text-white text-sm font-medium rounded-xl transition-colors duration-200">
                        <iconify-icon icon="heroicons:plus-20-solid" class="w-4 h-4 mr-2"></iconify-icon>
                        Create First Order
                    </a>
                </div>
            </div>
        @endif
    </div>
@endsection
