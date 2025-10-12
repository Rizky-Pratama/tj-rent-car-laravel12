<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Car;
use App\Models\User;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Order::with(['user', 'car'])->latest();

        // Search filter
        if ($request->filled('search')) {
            $search = $request->get('search');
            $query->where(function ($q) use ($search) {
                $q->where('order_number', 'like', "%{$search}%")
                    ->orWhereHas('user', function ($q) use ($search) {
                        $q->where('name', 'like', "%{$search}%")
                            ->orWhere('email', 'like', "%{$search}%");
                    })
                    ->orWhereHas('car', function ($q) use ($search) {
                        $q->where('name', 'like', "%{$search}%")
                            ->orWhere('brand', 'like', "%{$search}%")
                            ->orWhere('model', 'like', "%{$search}%");
                    });
            });
        }

        // Status filter
        if ($request->filled('status')) {
            $query->where('status', $request->get('status'));
        }

        // Car filter
        if ($request->filled('car_id')) {
            $query->where('car_id', $request->get('car_id'));
        }

        $orders = $query->paginate(15);

        return view('admin.orders.index', compact('orders'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $users = User::orderBy('name')->get();
        $cars = Car::where('is_active', true)->orderBy('name')->get();

        return view('admin.orders.create', compact('users', 'cars'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'user_id' => 'required|exists:users,id',
            'car_id' => 'required|exists:cars,id',
            'start_date' => 'required|date|after_or_equal:today',
            'end_date' => 'required|date|after_or_equal:start_date',
            'total_days' => 'required|integer|min:1',
            'total_amount' => 'required|numeric|min:0',
            'status' => 'required|in:pending,confirmed,in_progress,completed,cancelled',
            'payment_status' => 'nullable|in:pending,paid,cancelled',
            'notes' => 'nullable|string|max:1000'
        ]);

        // Generate order number
        $validated['order_number'] = 'ORD-' . strtoupper(uniqid());
        $validated['payment_status'] = $validated['payment_status'] ?? 'pending';

        // Create the order
        $order = Order::create($validated);

        return redirect()->route('admin.orders.index')
            ->with('success', 'Order created successfully!');
    }

    /**
     * Display the specified resource.
     */
    public function show(Order $order)
    {
        $order->load(['user', 'car']);
        return view('admin.orders.show', compact('order'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Order $order)
    {
        $users = User::orderBy('name')->get();
        $cars = Car::where('is_active', true)->orderBy('name')->get();

        return view('admin.orders.edit', compact('order', 'users', 'cars'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Order $order)
    {
        // Handle quick status updates
        if ($request->has('status') && !$request->has('user_id')) {
            $request->validate([
                'status' => 'required|in:pending,confirmed,in_progress,completed,cancelled'
            ]);

            $order->update(['status' => $request->status]);

            return redirect()->back()
                ->with('success', 'Order status updated successfully!');
        }

        // Handle quick payment status updates
        if ($request->has('payment_status') && !$request->has('user_id')) {
            $request->validate([
                'payment_status' => 'required|in:pending,paid,cancelled'
            ]);

            $order->update(['payment_status' => $request->payment_status]);

            return redirect()->back()
                ->with('success', 'Payment status updated successfully!');
        }

        // Handle full order updates
        $validated = $request->validate([
            'user_id' => 'required|exists:users,id',
            'car_id' => 'required|exists:cars,id',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
            'total_days' => 'required|integer|min:1',
            'total_amount' => 'required|numeric|min:0',
            'status' => 'required|in:pending,confirmed,in_progress,completed,cancelled',
            'payment_status' => 'nullable|in:pending,paid,cancelled',
            'notes' => 'nullable|string|max:1000'
        ]);

        $validated['payment_status'] = $validated['payment_status'] ?? 'pending';

        $order->update($validated);

        return redirect()->route('admin.orders.index')
            ->with('success', 'Order updated successfully!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Order $order)
    {
        $orderNumber = $order->order_number;
        $order->delete();

        return redirect()->route('admin.orders.index')
            ->with('success', "Order {$orderNumber} deleted successfully!");
    }
}
