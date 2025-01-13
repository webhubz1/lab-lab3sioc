<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product; // Ensure to include the Product model
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class CartController extends Controller
{
    // Add a product to the cart
    public function addToCart(Request $request)
    {
        // Validate the request
        $request->validate([
            'product_id' => 'required|exists:products,id', // Validate product ID
            'quantity' => 'required|integer|min:1', // Validate quantity
        ]);

        $cart = session()->get('cart', []);
        $productId = $request->product_id;
        $quantity = $request->quantity;

        // Fetch the product price from the database
        $product = Product::find($productId);
        $price = $product->price ?? 0; // Default to 0 if not found

        // If the product is already in the cart, update the quantity
        if (isset($cart[$productId])) {
            $cart[$productId]['quantity'] += $quantity;
        } else {
            $cart[$productId] = [
                'quantity' => $quantity,
                'price' => $price,
            ];
        }

        session()->put('cart', $cart);

        return redirect()->back()->with('success', 'Product added to cart!');
    }

    // View the current cart
    public function viewCart()
    {
        $cart = session()->get('cart', []);
        return view('cart.view', compact('cart'));
    }

    // Update the cart with new quantities or remove items
    public function updateCart(Request $request)
    {
        // Validate the request
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'quantity' => 'required|integer', // Quantity can be 0 for removal
        ]);

        $cart = session()->get('cart', []);
        $productId = $request->product_id;

        // Handle removal of the product
        if ($request->quantity <= 0) {
            unset($cart[$productId]);
        } else {
            $cart[$productId]['quantity'] = $request->quantity; // Update the quantity
        }

        session()->put('cart', $cart);
        return redirect()->back()->with('success', 'Cart updated successfully!');

        
    }

    // Process the checkout and validate the order details
    public function processCheckout(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required|email',
            'address' => 'required',
            'payment_method' => 'required',
        ]);

        $cart = session()->get('cart', []);
        if (empty($cart)) {
            return redirect()->back()->with('error', 'Your cart is empty!');
        }

        // Calculate the total amount
        $totalAmount = array_reduce($cart, function ($sum, $item) {
            return $sum + ($item['price'] * $item['quantity']);
        }, 0);

        // Store order details in the database
        $order = Order::create([
            'user_id' => auth()->id(),
            'total_amount' => $totalAmount,
            'payment_status' => 'Pending',
            'shipping_status' => 'Pending',
        ]);

        // Store each item in the order_items table
        foreach ($cart as $productId => $item) {
            Order::create([
                'order_id' => $order->id,
                'product_id' => $productId,
                'quantity' => $item['quantity'],
                'price' => $item['price'],
            ]);
        }

        // Clear the cart session
        session()->forget('cart');

        // Redirect to payment process (mock or real)
        return redirect()->route('payment.process', ['order' => $order->id]);
    }

    // Handle the payment (mock or real payment gateway integration)
    public function handlePayment(Request $request, $orderId)
    {
        $order = Order::findOrFail($orderId);

        // Example: mock payment process
        // Replace this with real PayPal/Stripe payment logic
        if ($request->payment_method === 'mock') {
            return $this->paymentSuccess($order);
        }

        // If integrating a real gateway like Stripe/PayPal, redirect to their payment page.
        return redirect()->back()->with('error', 'Payment method not implemented yet.');
    }

    // Mark the payment as successful and update order details
    public function paymentSuccess($order)
    {
        // Mark the order as paid
        $order->update([
            'payment_status' => 'Paid',
            'shipping_status' => 'Pending',
        ]);

        // Optionally, send an email confirmation to the user

        return redirect()->route('order.success')->with('success', 'Payment successful!');
    }

    // Display the success message after payment
    public function orderSuccess()
    {
        return view('order.success')->with('success', 'Your order has been placed successfully!');
    }

    public function index(Request $request)
{
    // Get the cart from session (or database)
    $cart = session()->get('cart', []);

    // Initialize total price to 0
    $totalPrice = 0;

    // Calculate total price by iterating over the cart
    foreach ($cart as $item) {
        $totalPrice += $item['price'] * $item['quantity'];
    }

    // Pass cart and total price to the view
    return view('user.cart', compact('cart', 'totalPrice'));
}
}