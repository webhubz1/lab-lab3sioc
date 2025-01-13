<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order; // Ensure you import the Order model

class OrderController extends Controller
{
    // Display a list of user orders
    public function index()
    {
        // Fetch orders for the authenticated user
        $orders = auth()->user()->orders; // Ensure the User model has the 'orders' relationship

        return view('orders.index', compact('orders')); // Return the orders view with the orders data
    }

    public function myOrders()
    {
        // Retrieve orders for the authenticated user
        $orders = auth()->user()->orders; // Ensure you have a relationship defined in the User model

        return view('orders.my_orders', compact('orders')); // Pass orders to the view
    }
}
