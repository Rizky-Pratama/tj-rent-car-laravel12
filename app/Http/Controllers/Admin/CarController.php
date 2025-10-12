<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Car;
use Illuminate\Http\Request;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;

class CarController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Car::query();

        // Search functionality
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                    ->orWhere('brand', 'like', "%{$search}%")
                    ->orWhere('model', 'like', "%{$search}%")
                    ->orWhere('license_plate', 'like', "%{$search}%");
            });
        }

        // Filter by status
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        // Filter by brand
        if ($request->filled('brand')) {
            $query->where('brand', $request->brand);
        }

        $cars = $query->latest()->paginate(10)->withQueryString();
        $brands = Car::distinct('brand')->pluck('brand')->sort();

        return view('admin.cars.index', compact('cars', 'brands'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $brands = ['Toyota', 'Honda', 'Mitsubishi', 'Daihatsu', 'Suzuki', 'Nissan', 'Mazda', 'Isuzu'];
        return view('admin.cars.create', compact('brands'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'brand' => 'required|string|max:100',
            'model' => 'required|string|max:100',
            'year' => 'required|integer|min:1990|max:' . (date('Y') + 1),
            'color' => 'required|string|max:50',
            'license_plate' => 'required|string|max:15|unique:cars,license_plate',
            'seats' => 'required|integer|min:2|max:20',
            'transmission' => 'required|in:manual,automatic',
            'fuel_type' => 'required|in:gasoline,diesel,electric,hybrid',
            'price_per_day' => 'required|numeric|min:0',
            'description' => 'nullable|string|max:1000',
            'features' => 'nullable|array',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'status' => 'required|in:available,rented,maintenance',
            'is_active' => 'boolean'
        ]);

        // Handle image upload
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $filename = time() . '_' . $image->getClientOriginalName();

            // Create image manager instance with GD driver
            $manager = new ImageManager(new Driver());
            $processedImage = $manager->read($image);

            // Resize and optimize
            $processedImage->resize(800, 600, function ($constraint) {
                $constraint->aspectRatio();
                $constraint->upsize();
            });

            // Save to public/storage/cars
            $path = public_path('storage/cars/' . $filename);
            if (!file_exists(dirname($path))) {
                mkdir(dirname($path), 0755, true);
            }

            $processedImage->save($path);
            $validated['image'] = 'storage/cars/' . $filename;
        }

        Car::create($validated);

        return redirect()->route('admin.cars.index')->with('success', 'Car created successfully!');
    }

    /**
     * Display the specified resource.
     */
    public function show(Car $car)
    {
        $car->load('orders.user');
        return view('admin.cars.show', compact('car'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Car $car)
    {
        $brands = ['Toyota', 'Honda', 'Mitsubishi', 'Daihatsu', 'Suzuki', 'Nissan', 'Mazda', 'Isuzu'];
        return view('admin.cars.edit', compact('car', 'brands'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Car $car)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'brand' => 'required|string|max:100',
            'model' => 'required|string|max:100',
            'year' => 'required|integer|min:1990|max:' . (date('Y') + 1),
            'color' => 'required|string|max:50',
            'license_plate' => 'required|string|max:15|unique:cars,license_plate,' . $car->id,
            'seats' => 'required|integer|min:2|max:20',
            'transmission' => 'required|in:manual,automatic',
            'fuel_type' => 'required|in:gasoline,diesel,electric,hybrid',
            'price_per_day' => 'required|numeric|min:0',
            'description' => 'nullable|string|max:1000',
            'features' => 'nullable|array',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'status' => 'required|in:available,rented,maintenance',
            'is_active' => 'boolean'
        ]);

        // Handle image upload
        if ($request->hasFile('image')) {
            // Delete old image
            if ($car->image && file_exists(public_path($car->image))) {
                unlink(public_path($car->image));
            }

            $image = $request->file('image');
            $filename = time() . '_' . $image->getClientOriginalName();

            // Create image manager instance with GD driver
            $manager = new ImageManager(new Driver());
            $processedImage = $manager->read($image);

            // Resize and optimize
            $processedImage->resize(800, 600, function ($constraint) {
                $constraint->aspectRatio();
                $constraint->upsize();
            });

            // Save to public/storage/cars
            $path = public_path('storage/cars/' . $filename);
            if (!file_exists(dirname($path))) {
                mkdir(dirname($path), 0755, true);
            }

            $processedImage->save($path);
            $validated['image'] = 'storage/cars/' . $filename;
        }

        $car->update($validated);

        return redirect()->route('admin.cars.index')->with('success', 'Car updated successfully!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Car $car)
    {
        // Check if car has active orders
        if ($car->orders()->whereIn('status', ['confirmed', 'in_progress'])->exists()) {
            return redirect()->route('admin.cars.index')->with('error', 'Cannot delete car with active orders!');
        }

        // Delete image file
        if ($car->image && file_exists(public_path($car->image))) {
            unlink(public_path($car->image));
        }

        $car->delete();

        return redirect()->route('admin.cars.index')->with('success', 'Car deleted successfully!');
    }
}
