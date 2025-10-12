@extends('layouts.admin')

@section('title', 'Edit Car - ' . $car->name)
@section('page-title', 'Edit Car')
@section('page-subtitle', 'Update car information')

@section('content')
    <div class="max-w-4xl mx-auto">
        <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-sm border border-gray-100 dark:border-gray-700">
            <!-- Header -->
            <div class="px-6 py-4 border-b border-gray-200 dark:border-gray-700">
                <div class="flex items-center justify-between">
                    <div>
                        <h3 class="text-lg font-semibold text-gray-800 dark:text-white">Edit: {{ $car->name }}</h3>
                        <p class="text-sm text-gray-500 dark:text-gray-400">{{ $car->brand }} {{ $car->model }}
                            ({{ $car->year }})</p>
                    </div>
                    <div class="flex items-center space-x-2">
                        <a href="{{ route('admin.cars.show', $car) }}"
                            class="inline-flex items-center px-4 py-2 bg-blue-500 hover:bg-blue-600 text-white text-sm font-medium rounded-xl transition-colors duration-200">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                            </svg>
                            View
                        </a>
                        <a href="{{ route('admin.cars.index') }}"
                            class="inline-flex items-center px-4 py-2 bg-gray-500 hover:bg-gray-600 text-white text-sm font-medium rounded-xl transition-colors duration-200">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                            </svg>
                            Back to Cars
                        </a>
                    </div>
                </div>
            </div>

            <!-- Current Image Preview -->
            @if ($car->image)
                <div class="px-6 py-4 border-b border-gray-200 dark:border-gray-700">
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Current Image</label>
                    <div class="relative inline-block">
                        <img src="{{ asset($car->image) }}" alt="{{ $car->name }}"
                            class="w-32 h-24 object-cover rounded-lg border border-gray-200 dark:border-gray-600">
                    </div>
                </div>
            @endif

            <!-- Form -->
            <form action="{{ route('admin.cars.update', $car) }}" method="POST" enctype="multipart/form-data"
                class="p-6">
                @csrf
                @method('PUT')

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Basic Information -->
                    <div class="space-y-6">
                        <h4
                            class="text-md font-semibold text-gray-800 dark:text-white border-b border-gray-200 dark:border-gray-700 pb-2">
                            Basic Information</h4>

                        <!-- Car Name -->
                        <div>
                            <label for="name"
                                class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Car Name *</label>
                            <input type="text" name="name" id="name" value="{{ old('name', $car->name) }}"
                                required
                                class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-xl focus:ring-2 focus:ring-indigo-500 dark:focus:ring-indigo-400 focus:border-transparent bg-white dark:bg-gray-700 text-gray-900 dark:text-white"
                                placeholder="e.g., Toyota Avanza Premium">
                            @error('name')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Brand -->
                        <div>
                            <label for="brand"
                                class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Brand *</label>
                            <select name="brand" id="brand" required
                                class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-xl focus:ring-2 focus:ring-indigo-500 dark:focus:ring-indigo-400 focus:border-transparent bg-white dark:bg-gray-700 text-gray-900 dark:text-white">
                                <option value="">Select Brand</option>
                                @foreach ($brands as $brand)
                                    <option value="{{ $brand }}"
                                        {{ old('brand', $car->brand) == $brand ? 'selected' : '' }}>{{ $brand }}
                                    </option>
                                @endforeach
                            </select>
                            @error('brand')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Model -->
                        <div>
                            <label for="model"
                                class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Model *</label>
                            <input type="text" name="model" id="model" value="{{ old('model', $car->model) }}"
                                required
                                class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-xl focus:ring-2 focus:ring-indigo-500 dark:focus:ring-indigo-400 focus:border-transparent bg-white dark:bg-gray-700 text-gray-900 dark:text-white"
                                placeholder="e.g., Avanza, Jazz, Xpander">
                            @error('model')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Year -->
                        <div>
                            <label for="year"
                                class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Year *</label>
                            <input type="number" name="year" id="year" value="{{ old('year', $car->year) }}"
                                required min="1990" max="{{ date('Y') + 1 }}"
                                class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-xl focus:ring-2 focus:ring-indigo-500 dark:focus:ring-indigo-400 focus:border-transparent bg-white dark:bg-gray-700 text-gray-900 dark:text-white"
                                placeholder="2023">
                            @error('year')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Color -->
                        <div>
                            <label for="color"
                                class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Color *</label>
                            <input type="text" name="color" id="color" value="{{ old('color', $car->color) }}"
                                required
                                class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-xl focus:ring-2 focus:ring-indigo-500 dark:focus:ring-indigo-400 focus:border-transparent bg-white dark:bg-gray-700 text-gray-900 dark:text-white"
                                placeholder="e.g., White, Black, Silver">
                            @error('color')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- License Plate -->
                        <div>
                            <label for="license_plate"
                                class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">License Plate
                                *</label>
                            <input type="text" name="license_plate" id="license_plate"
                                value="{{ old('license_plate', $car->license_plate) }}" required
                                class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-xl focus:ring-2 focus:ring-indigo-500 dark:focus:ring-indigo-400 focus:border-transparent bg-white dark:bg-gray-700 text-gray-900 dark:text-white"
                                placeholder="e.g., B 1234 ABC">
                            @error('license_plate')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <!-- Specifications -->
                    <div class="space-y-6">
                        <h4
                            class="text-md font-semibold text-gray-800 dark:text-white border-b border-gray-200 dark:border-gray-700 pb-2">
                            Specifications</h4>

                        <!-- Seats -->
                        <div>
                            <label for="seats"
                                class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Number of Seats
                                *</label>
                            <input type="number" name="seats" id="seats" value="{{ old('seats', $car->seats) }}"
                                required min="2" max="20"
                                class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-xl focus:ring-2 focus:ring-indigo-500 dark:focus:ring-indigo-400 focus:border-transparent bg-white dark:bg-gray-700 text-gray-900 dark:text-white"
                                placeholder="7">
                            @error('seats')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Transmission -->
                        <div>
                            <label for="transmission"
                                class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Transmission
                                *</label>
                            <select name="transmission" id="transmission" required
                                class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-xl focus:ring-2 focus:ring-indigo-500 dark:focus:ring-indigo-400 focus:border-transparent bg-white dark:bg-gray-700 text-gray-900 dark:text-white">
                                <option value="">Select Transmission</option>
                                <option value="manual"
                                    {{ old('transmission', $car->transmission) == 'manual' ? 'selected' : '' }}>Manual
                                </option>
                                <option value="automatic"
                                    {{ old('transmission', $car->transmission) == 'automatic' ? 'selected' : '' }}>
                                    Automatic</option>
                            </select>
                            @error('transmission')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Fuel Type -->
                        <div>
                            <label for="fuel_type"
                                class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Fuel Type *</label>
                            <select name="fuel_type" id="fuel_type" required
                                class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-xl focus:ring-2 focus:ring-indigo-500 dark:focus:ring-indigo-400 focus:border-transparent bg-white dark:bg-gray-700 text-gray-900 dark:text-white">
                                <option value="">Select Fuel Type</option>
                                <option value="gasoline"
                                    {{ old('fuel_type', $car->fuel_type) == 'gasoline' ? 'selected' : '' }}>Gasoline
                                </option>
                                <option value="diesel"
                                    {{ old('fuel_type', $car->fuel_type) == 'diesel' ? 'selected' : '' }}>Diesel</option>
                                <option value="electric"
                                    {{ old('fuel_type', $car->fuel_type) == 'electric' ? 'selected' : '' }}>Electric
                                </option>
                                <option value="hybrid"
                                    {{ old('fuel_type', $car->fuel_type) == 'hybrid' ? 'selected' : '' }}>Hybrid</option>
                            </select>
                            @error('fuel_type')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Price Per Day -->
                        <div>
                            <label for="price_per_day"
                                class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Price Per Day (IDR)
                                *</label>
                            <input type="number" name="price_per_day" id="price_per_day"
                                value="{{ old('price_per_day', $car->price_per_day) }}" required min="0"
                                step="1000"
                                class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-xl focus:ring-2 focus:ring-indigo-500 dark:focus:ring-indigo-400 focus:border-transparent bg-white dark:bg-gray-700 text-gray-900 dark:text-white"
                                placeholder="300000">
                            @error('price_per_day')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Status -->
                        <div>
                            <label for="status"
                                class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Status *</label>
                            <select name="status" id="status" required
                                class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-xl focus:ring-2 focus:ring-indigo-500 dark:focus:ring-indigo-400 focus:border-transparent bg-white dark:bg-gray-700 text-gray-900 dark:text-white">
                                <option value="available"
                                    {{ old('status', $car->status) == 'available' ? 'selected' : '' }}>Available</option>
                                <option value="rented" {{ old('status', $car->status) == 'rented' ? 'selected' : '' }}>
                                    Rented</option>
                                <option value="maintenance"
                                    {{ old('status', $car->status) == 'maintenance' ? 'selected' : '' }}>Maintenance
                                </option>
                            </select>
                            @error('status')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Active Status -->
                        <div class="flex items-center">
                            <input type="checkbox" name="is_active" id="is_active" value="1"
                                {{ old('is_active', $car->is_active) ? 'checked' : '' }}
                                class="h-4 w-4 text-indigo-600 focus:ring-indigo-500 border-gray-300 rounded">
                            <label for="is_active" class="ml-2 block text-sm text-gray-700 dark:text-gray-300">
                                Active (Available for booking)
                            </label>
                        </div>
                    </div>
                </div>

                <!-- Full Width Fields -->
                <div class="mt-6 space-y-6">
                    <!-- Car Image -->
                    <div>
                        <label for="image"
                            class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Update Car Image
                            (Optional)</label>
                        <div
                            class="mt-1 flex justify-center px-6 pt-5 pb-6 border-2 border-gray-300 dark:border-gray-600 border-dashed rounded-xl">
                            <div class="space-y-1 text-center">
                                <svg class="mx-auto h-12 w-12 text-gray-400" stroke="currentColor" fill="none"
                                    viewBox="0 0 48 48">
                                    <path
                                        d="M28 8H12a4 4 0 00-4 4v20m32-12v8m0 0v8a4 4 0 01-4 4H12a4 4 0 01-4-4v-4m32-4l-3.172-3.172a4 4 0 00-5.656 0L28 28M8 32l9.172-9.172a4 4 0 015.656 0L28 28m0 0l4 4m4-24h8m-4-4v8m-12 4h.02"
                                        stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                                </svg>
                                <div class="flex text-sm text-gray-600 dark:text-gray-400">
                                    <label for="image"
                                        class="relative cursor-pointer bg-white dark:bg-gray-800 rounded-md font-medium text-indigo-600 dark:text-indigo-400 hover:text-indigo-500 focus-within:outline-none focus-within:ring-2 focus-within:ring-offset-2 focus-within:ring-indigo-500">
                                        <span>Upload a file</span>
                                        <input id="image" name="image" type="file" accept="image/*"
                                            class="sr-only">
                                    </label>
                                    <p class="pl-1">or drag and drop</p>
                                </div>
                                <p class="text-xs text-gray-500 dark:text-gray-400">PNG, JPG, GIF up to 2MB</p>
                            </div>
                        </div>
                        @error('image')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Features -->
                    <div>
                        <label for="features"
                            class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Features
                            (Optional)</label>
                        <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-3">
                            @php
                                $availableFeatures = [
                                    'air_conditioning' => 'Air Conditioning',
                                    'gps_navigation' => 'GPS Navigation',
                                    'bluetooth' => 'Bluetooth',
                                    'usb_charging' => 'USB Charging',
                                    'backup_camera' => 'Backup Camera',
                                    'leather_seats' => 'Leather Seats',
                                    'sunroof' => 'Sunroof',
                                    'cruise_control' => 'Cruise Control',
                                ];
                                $carFeatures = old('features', $car->features ?? []);
                            @endphp
                            @foreach ($availableFeatures as $key => $label)
                                <div class="flex items-center">
                                    <input type="checkbox" name="features[]" id="feature_{{ $key }}"
                                        value="{{ $key }}" {{ in_array($key, $carFeatures) ? 'checked' : '' }}
                                        class="h-4 w-4 text-indigo-600 focus:ring-indigo-500 border-gray-300 rounded">
                                    <label for="feature_{{ $key }}"
                                        class="ml-2 block text-sm text-gray-700 dark:text-gray-300">{{ $label }}</label>
                                </div>
                            @endforeach
                        </div>
                    </div>

                    <!-- Description -->
                    <div>
                        <label for="description"
                            class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Description
                            (Optional)</label>
                        <textarea name="description" id="description" rows="4"
                            class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-xl focus:ring-2 focus:ring-indigo-500 dark:focus:ring-indigo-400 focus:border-transparent bg-white dark:bg-gray-700 text-gray-900 dark:text-white"
                            placeholder="Additional information about the car...">{{ old('description', $car->description) }}</textarea>
                        @error('description')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <!-- Submit Buttons -->
                <div
                    class="flex items-center justify-end space-x-3 mt-8 pt-6 border-t border-gray-200 dark:border-gray-700">
                    <a href="{{ route('admin.cars.index') }}"
                        class="px-6 py-2 bg-gray-500 hover:bg-gray-600 text-white font-medium rounded-xl transition-colors duration-200">
                        Cancel
                    </a>
                    <button type="submit"
                        class="px-6 py-2 bg-indigo-600 hover:bg-indigo-700 text-white font-medium rounded-xl transition-colors duration-200">
                        Update Car
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection
