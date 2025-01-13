<?php

namespace App\Http\Controllers\User;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Models\User; // Make sure to include the User model
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use App\Models\Product; // Correctly import the Product model



class UserController extends Controller
{
    // Get dashboard for users (not admin)
    public function getDashboard()
    {
        return view('user.dashboard'); // Ensure this view exists at resources/views/user/dashboard.blade.php
    }

    // Handle user sign-in
    public function postSignin(Request $request)
    {
        $remember = $request->input('remember_me');

        if (Auth::attempt(['email' => $request['email'], 'password' => $request['password']], $remember)) {
            // Check user role
            $user = Auth::user();
            if ($user->role === 'admin') {
                return redirect()->route('admin.dashboard'); // Redirect to admin dashboard
            } else {
                return redirect()->route('user.dashboard'); // Redirect to user dashboard
            }
        }

        return redirect()->back()->withErrors(['email' => 'Invalid credentials']);
    }

    // Show user profile
    public function showProfile()
    {
        // Return the user's profile view
        return view('user.profile');
    }

    // Show all users
    public function index()
    {
        // Get all users from the database
        $users = User::all(); // Or use pagination if you have a lot of users: User::paginate(10);
        return view('admin.users.index', compact('users')); // Ensure this view exists
    }

    // Create user form
    public function create()
    {
        return view('admin.users.create'); // Ensure this view exists
    }

    // Store new user
    public function store(Request $request)
    {
        // Validate request data
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
            'role' => 'required|in:user,admin', // Ensure role is either 'user' or 'admin'
        ]);

        // Create new user
        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => $request->role,
        ]);

        return redirect()->route('admin.users.index')->with('success', 'User created successfully.');
    }

    // Optional: If you want pagination functionality
    public function paginate($query, $perPage = null)
    {
        $perPage = $perPage ?? $this->defaultPageSize;
        return $query->paginate($perPage);
    }

    // Edit user form
public function edit($id)
{
    $user = User::findOrFail($id);
    return view('admin.users.edit', compact('user')); // Ensure this view exists
}

// Update user
public function update(Request $request, $id)
{
    $user = User::findOrFail($id);

    // Validate request data
    $request->validate([
        'name' => 'required|string|max:255',
        'email' => 'required|string|email|max:255|unique:users,email,' . $user->id,
        'role' => 'required|in:user,admin', // Ensure role is either 'user' or 'admin'
    ]);

    // Update user details
    $user->update([
        'name' => $request->name,
        'email' => $request->email,
        'role' => $request->role,
    ]);

    return redirect()->route('admin.users.index')->with('success', 'User updated successfully.');
}

public function addToCart(Request $request, $productId)
{
    // Validate the request if necessary
    $request->validate([
        'quantity' => 'required|integer|min:1',
    ]);

    // Retrieve the product from the database
    $product = Product::find($productId);

    // Check if the product exists
    if (!$product) {
        return redirect()->back()->with('error', 'Product not found.');
    }

    // Get the cart from the session or initialize an empty array
    $cart = Session::get('cart', []);

    // Check if the product already exists in the cart
    if (isset($cart[$productId])) {
        $cart[$productId]['quantity'] += $request->input('quantity');
    } else {
        // Add new product to the cart with its price
        $cart[$productId] = [
            'quantity' => $request->input('quantity'),
            'price' => $product->price, // Use the price from the retrieved product
        ];
    }

    // Store the updated cart in the session
    Session::put('cart', $cart);

    // Redirect back with a success message
    return redirect()->back()->with('success', 'Product added to cart successfully!');
}

public function destroy(User $user)
    {
        $user->delete(); // Delete the user

        return redirect()->route('admin.users.index')->with('success', 'User deleted successfully.');
    }

}