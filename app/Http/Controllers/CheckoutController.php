<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use PayPalCheckoutSdk\Core\PayPalHttpClient;
use PayPalCheckoutSdk\Core\SandboxEnvironment;
use PayPalCheckoutSdk\Orders\OrdersCreateRequest;
use PayPalCheckoutSdk\Orders\OrdersCaptureRequest;
use App\Models\Order;

class CheckoutController extends Controller
{
    private $client;

    public function __construct()
    {
        $environment = new SandboxEnvironment(config('paypal.client_id'), config('paypal.client_secret'));
        $this->client = new PayPalHttpClient($environment);
    }

    public function showCheckoutForm()
    {
        return view('checkout'); // Your checkout view
    }

    public function processCheckout(Request $request)
    {
        // Validate request
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'address' => 'required|string|max:255',
        ]);

        // Create a new order
        $order = new OrdersCreateRequest();
        $order->body = [
            'intent' => 'CAPTURE',
            'purchase_units' => [[
                'amount' => [
                    'currency_code' => 'USD',
                    'value' => '10.00', // Set the total amount
                ],
            ]],
            'application_context' => [
                'return_url' => route('checkout.success'),
                'cancel_url' => route('checkout.cancel'),
            ],
        ];

        try {
            $response = $this->client->execute($order);

            // Store order in the database
            $orderModel = Order::create([
                'name' => $request->name,
                'email' => $request->email,
                'address' => $request->address,
                'payment_method' => 'paypal',
                'total_amount' => '10.00', // Include the amount
                'status' => 'Pending',
                'paypal_order_id' => $response->result->id, // Save PayPal order ID
            ]);

            // Redirect to PayPal
            $approveLink = collect($response->result->links)->firstWhere('rel', 'approve')->href;
            return redirect($approveLink);
        } catch (\Exception $e) {
            \Log::error('Order creation failed: ' . $e->getMessage());
            return redirect()->route('checkout.error')->with('error', 'Order creation failed. Please try again.');
        }
    }

    public function success(Request $request)
    {
        // Capture the payment
        $orderId = $request->query('token'); // Use the correct query parameter
        $captureRequest = new OrdersCaptureRequest($orderId);
        try {
            $response = $this->client->execute($captureRequest);
            // Update order status to 'Paid'
            $order = Order::where('paypal_order_id', $orderId)->first();
            if ($order) {
                $order->update(['status' => 'Paid']);
            }

            return view('checkout.success', compact('order'));
        } catch (\Exception $e) {
            \Log::error('Payment capture failed: ' . $e->getMessage());
            return redirect()->route('checkout.error')->with('error', 'Payment capture failed. Please try again.');
        }
    }

    public function cancel(Request $request)
    {
        return view('checkout.cancel');
    }
}
