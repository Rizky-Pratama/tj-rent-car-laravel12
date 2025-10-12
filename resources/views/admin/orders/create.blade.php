@extends('layouts.admin')

@section('title', 'Create New Order')
@section('page-title', 'Create Order')
@section('page-subtitle', 'Add a new rental order to the system')

@section('content')
    <div class="max-w-4xl mx-auto">
        <form action="{{ route('admin.orders.store') }}" method="POST" class="space-y-6" x-data="orderForm()">
            @csrf

            <!-- Order Details Card -->
            <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-sm border border-gray-100 dark:border-gray-700 p-6">
                <h3 class="text-lg font-semibold text-gray-800 dark:text-white mb-6">Order Details</h3>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Customer Selection -->
                    <div>
                        <label for="user_id" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                            Customer *
                        </label>
                        <select name="user_id" id="user_id" required
                            class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-xl bg-white dark:bg-gray-700 text-gray-900 dark:text-white placeholder-gray-500 dark:placeholder-gray-400 focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition-colors duration-200">
                            <option value="">Select Customer</option>
                            @foreach ($users as $user)
                                <option value="{{ $user->id }}" {{ old('user_id') == $user->id ? 'selected' : '' }}>
                                    {{ $user->name }} ({{ $user->email }})
                                </option>
                            @endforeach
                        </select>
                        @error('user_id')
                            <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Car Selection -->
                    <div>
                        <label for="car_id" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                            Car *
                        </label>
                        <select name="car_id" id="car_id" required x-model="selectedCar" @change="updateCarDetails()"
                            class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-xl bg-white dark:bg-gray-700 text-gray-900 dark:text-white placeholder-gray-500 dark:placeholder-gray-400 focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition-colors duration-200">
                            <option value="">Select Car</option>
                            @foreach ($cars as $car)
                                <option value="{{ $car->id }}" data-price="{{ $car->price_per_day }}"
                                    data-name="{{ $car->name }}" data-image="{{ $car->image ? asset($car->image) : '' }}"
                                    {{ old('car_id') == $car->id ? 'selected' : '' }}>
                                    {{ $car->name }} - Rp {{ number_format($car->price_per_day, 0, ',', '.') }}/day
                                </option>
                            @endforeach
                        </select>
                        @error('car_id')
                            <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
            </div>

            <!-- Rental Period Card -->
            <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-sm border border-gray-100 dark:border-gray-700 p-6">
                <h3 class="text-lg font-semibold text-gray-800 dark:text-white mb-6">Rental Period</h3>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Start Date -->
                    <div>
                        <label for="start_date" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                            Start Date *
                        </label>
                        <input type="date" name="start_date" id="start_date" required
                            value="{{ old('start_date', date('Y-m-d')) }}" min="{{ date('Y-m-d') }}" x-model="startDate"
                            @change="calculateTotal()"
                            class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-xl bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition-colors duration-200">
                        @error('start_date')
                            <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- End Date -->
                    <div>
                        <label for="end_date" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                            End Date *
                        </label>
                        <input type="date" name="end_date" id="end_date" required value="{{ old('end_date') }}"
                            x-model="endDate" @change="calculateTotal()"
                            class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-xl bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition-colors duration-200">
                        @error('end_date')
                            <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <!-- Rental Summary -->
                <div x-show="totalDays > 0" class="mt-6 p-4 bg-gray-50 dark:bg-gray-700 rounded-xl">
                    <div class="flex justify-between items-center text-sm">
                        <span class="text-gray-600 dark:text-gray-400">Rental Duration:</span>
                        <span class="font-semibold text-gray-900 dark:text-white"
                            x-text="totalDays + ' day' + (totalDays > 1 ? 's' : '')"></span>
                    </div>
                    <div class="flex justify-between items-center text-sm mt-2">
                        <span class="text-gray-600 dark:text-gray-400">Price per Day:</span>
                        <span class="font-semibold text-gray-900 dark:text-white"
                            x-text="'Rp ' + pricePerDay.toLocaleString('id-ID')"></span>
                    </div>
                    <div class="border-t border-gray-200 dark:border-gray-600 pt-2 mt-2">
                        <div class="flex justify-between items-center">
                            <span class="text-base font-medium text-gray-900 dark:text-white">Total Amount:</span>
                            <span class="text-lg font-bold text-indigo-600 dark:text-indigo-400"
                                x-text="'Rp ' + totalAmount.toLocaleString('id-ID')"></span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Order Status Card -->
            <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-sm border border-gray-100 dark:border-gray-700 p-6">
                <h3 class="text-lg font-semibold text-gray-800 dark:text-white mb-6">Order Status</h3>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Status -->
                    <div>
                        <label for="status" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                            Status *
                        </label>
                        <select name="status" id="status" required
                            class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-xl bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition-colors duration-200">
                            <option value="pending" {{ old('status', 'pending') === 'pending' ? 'selected' : '' }}>Pending
                            </option>
                            <option value="confirmed" {{ old('status') === 'confirmed' ? 'selected' : '' }}>Confirmed
                            </option>
                            <option value="in_progress" {{ old('status') === 'in_progress' ? 'selected' : '' }}>In Progress
                            </option>
                            <option value="completed" {{ old('status') === 'completed' ? 'selected' : '' }}>Completed
                            </option>
                            <option value="cancelled" {{ old('status') === 'cancelled' ? 'selected' : '' }}>Cancelled
                            </option>
                        </select>
                        @error('status')
                            <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Payment Status -->
                    <div>
                        <label for="payment_status" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                            Payment Status
                        </label>
                        <select name="payment_status" id="payment_status"
                            class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-xl bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition-colors duration-200">
                            <option value="pending" {{ old('payment_status', 'pending') === 'pending' ? 'selected' : '' }}>
                                Pending</option>
                            <option value="paid" {{ old('payment_status') === 'paid' ? 'selected' : '' }}>Paid</option>
                            <option value="cancelled" {{ old('payment_status') === 'cancelled' ? 'selected' : '' }}>
                                Cancelled</option>
                        </select>
                        @error('payment_status')
                            <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
            </div>

            <!-- Notes Card -->
            <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-sm border border-gray-100 dark:border-gray-700 p-6">
                <h3 class="text-lg font-semibold text-gray-800 dark:text-white mb-6">Additional Information</h3>

                <div>
                    <label for="notes" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                        Notes
                    </label>
                    <textarea name="notes" id="notes" rows="4" placeholder="Add any special requests or notes for this order..."
                        class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-xl bg-white dark:bg-gray-700 text-gray-900 dark:text-white placeholder-gray-500 dark:placeholder-gray-400 focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition-colors duration-200 resize-none">{{ old('notes') }}</textarea>
                    @error('notes')
                        <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <!-- Selected Car Preview -->
            <div x-show="selectedCar"
                class="bg-white dark:bg-gray-800 rounded-2xl shadow-sm border border-gray-100 dark:border-gray-700 p-6">
                <h3 class="text-lg font-semibold text-gray-800 dark:text-white mb-6">Selected Car</h3>

                <div class="flex items-center space-x-4">
                    <div class="w-20 h-20 bg-gray-200 dark:bg-gray-600 rounded-xl overflow-hidden">
                        <img x-show="carImage" :src="carImage" :alt="carName"
                            class="w-full h-full object-cover">
                        <div x-show="!carImage" class="w-full h-full flex items-center justify-center">
                            <svg class="w-8 h-8 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10" />
                            </svg>
                        </div>
                    </div>
                    <div class="flex-1">
                        <h4 class="text-lg font-semibold text-gray-900 dark:text-white" x-text="carName"></h4>
                        <p class="text-sm text-gray-500 dark:text-gray-400"
                            x-text="'Rp ' + pricePerDay.toLocaleString('id-ID') + ' per day'"></p>
                    </div>
                </div>
            </div>

            <!-- Action Buttons -->
            <div class="flex items-center justify-between pt-6 border-t border-gray-200 dark:border-gray-600">
                <a href="{{ route('admin.orders.index') }}"
                    class="inline-flex items-center px-6 py-3 bg-gray-500 hover:bg-gray-600 text-white text-sm font-medium rounded-xl transition-colors duration-200">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                    </svg>
                    Cancel
                </a>

                <button type="submit"
                    class="inline-flex items-center px-6 py-3 bg-indigo-600 hover:bg-indigo-700 text-white text-sm font-medium rounded-xl transition-colors duration-200">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                    </svg>
                    Create Order
                </button>
            </div>

            <!-- Hidden fields for calculated values -->
            <input type="hidden" name="total_days" x-model="totalDays">
            <input type="hidden" name="total_amount" x-model="totalAmount">
        </form>
    </div>

    <script>
        function orderForm() {
            return {
                selectedCar: '{{ old('car_id') }}',
                startDate: '{{ old('start_date', date('Y-m-d')) }}',
                endDate: '{{ old('end_date') }}',
                pricePerDay: 0,
                totalDays: 0,
                totalAmount: 0,
                carName: '',
                carImage: '',

                init() {
                    this.updateCarDetails();
                    this.calculateTotal();

                    // Update end date minimum when start date changes
                    this.$watch('startDate', () => {
                        const endDateInput = document.getElementById('end_date');
                        if (endDateInput) {
                            endDateInput.min = this.startDate;
                            if (this.endDate && this.endDate < this.startDate) {
                                this.endDate = this.startDate;
                            }
                        }
                        this.calculateTotal();
                    });
                },

                updateCarDetails() {
                    const carSelect = document.getElementById('car_id');
                    const selectedOption = carSelect.options[carSelect.selectedIndex];

                    if (selectedOption && selectedOption.value) {
                        this.pricePerDay = parseInt(selectedOption.dataset.price) || 0;
                        this.carName = selectedOption.dataset.name || '';
                        this.carImage = selectedOption.dataset.image || '';
                        this.calculateTotal();
                    } else {
                        this.pricePerDay = 0;
                        this.carName = '';
                        this.carImage = '';
                        this.totalAmount = 0;
                        this.totalDays = 0;
                    }
                },

                calculateTotal() {
                    if (this.startDate && this.endDate && this.pricePerDay > 0) {
                        const start = new Date(this.startDate);
                        const end = new Date(this.endDate);

                        if (end >= start) {
                            this.totalDays = Math.ceil((end - start) / (1000 * 60 * 60 * 24)) + 1;
                            this.totalAmount = this.totalDays * this.pricePerDay;
                        } else {
                            this.totalDays = 0;
                            this.totalAmount = 0;
                        }
                    } else {
                        this.totalDays = 0;
                        this.totalAmount = 0;
                    }
                }
            }
        }
    </script>
@endsection
