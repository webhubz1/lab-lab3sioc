<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order; // Correct import of the Order model
use Illuminate\Http\Request; // Import Request class
use Illuminate\Support\Facades\Auth; // Import Auth facade

class OrderController extends Controller
{
    /**
     * Display a listing of all orders for admin.
     */
    public function index()
{
    $orders = Order::with('user')->paginate(10); // Adjust '10' to your desired items per page
    return view('admin.orders.index', compact('orders'));
}

    /**
     * Display a listing of orders for the authenticated user.
     */
    public function userOrders(Request $request)
    {
        // Fetch the orders for the authenticated user
        $orders = Order::where('user_id', $request->user()->id)->get();

        return view('orders.index', compact('orders'));
    }

    /**
     * Display the specified order.
     *
     * @param  Order  $order
     * @return \Illuminate\View\View
     */
    public function show(Order $order)
    {
        // Ensure the user is viewing their own order
        if ($order->user_id !== auth()->id()) {
            abort(403, 'Unauthorized action.');
        }

        return view('orders.order-details', compact('order'));
    }

    /**
     * Show the form for creating a new order.
     */
    public function create()
    {
        // Show form for creating a new order
        return view('admin.orders.create');
    }

    /**
     * Store a newly created order in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        // Validate and store the new order
        // $request->validate([...]);

        $order = Order::create($request->all());

        return redirect()->route('admin.orders.index')->with('success', 'Order created successfully.');
    }

    /**
     * Show the form for editing the specified order.
     *
     * @param  Order  $order
     * @return \Illuminate\View\View
     */
    public function edit(Order $order)
    {
        return view('admin.orders.edit', compact('order'));
    }

    /**
     * Update the specified order in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  Order  $order
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, Order $order)
    {
        // Validate and update the order
        // $request->validate([...]);

        $order->update($request->all());

        return redirect()->route('admin.orders.index')->with('success', 'Order updated successfully.');
    }

    /**
     * Remove the specified order from storage.
     *
     * @param  Order  $order
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(Order $order)
    {
        $order->delete();

        return redirect()->route('admin.orders.index')->with('success', 'Order deleted successfully.');
    }

    
}
