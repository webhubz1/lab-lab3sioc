<?php

namespace App\Http\Controllers\Admin;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use App\Models\Product; // Import your Product model if needed
use App\Models\Order;


class AdminController extends Controller
{
    // Display a listing of the users (for admin use)
    public function index()
    {   
        // Fetch all users
        $users = User::all(); // Retrieve all users from the database

        // Optionally, fetch products if needed
        $products = Product::all(); // Retrieve all products from the database
        $products = Product::with('sizes')->get(); // Retrieve all products along with their associated sizes

        // Pass both users and products to the view
        return view('admin.dashboard', compact('users', 'products'));
    }

    // Show the form for creating a new user (for admin use)
    public function create()
    {
        return view('admin.users.create'); // Return the view for creating a user
    }

    // Store a newly created user in storage (for admin use)
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
            'role' => 'required|string',
        ]);

        // Create a new user
        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password), // Hash the password
            'role' => $request->role,
        ]);

        return redirect()->route('admin.users.index')->with('success', 'User created successfully.');
    }

    // Show the form for editing the specified user (for admin use)
    public function edit(User $user)
    {
        return view('admin.users.edit', compact('user')); // Return the view for editing a user
    }

    // Update the specified user in storage (for admin use)
    public function update(Request $request, User $user)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $user->id,
            'password' => 'nullable|string|min:8|confirmed',
            'role' => 'required|string',
        ]);

        // Update user fields
        $user->name = $request->name;
        $user->email = $request->email;
        $user->role = $request->role;

        // Check if password needs to be updated
        if ($request->filled('password')) {
            $user->password = Hash::make($request->password); // Hash the new password
        }

        $user->save(); // Save the updated user

        return redirect()->route('admin.users.index')->with('success', 'User updated successfully.');
    }

    // Remove the specified user from storage (for admin use)   
    public function destroy(User $user)
    {
        $user->delete(); // Delete the user

        return redirect()->route('admin.users.index')->with('success', 'User deleted successfully.');
    }
    
    public function getDashboard()
    {
        // Logic for the dashboard
        $users = User::all();
        return view('admin.dashboard', compact('users'));
    }

    public function showOrders()
    {
        $orders = Order::all(); // Fetch all orders; modify as necessary
        return view('admin.orders.index', compact('orders')); // Ensure this view exists
    }
    
}

