<?php


namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Omnipay\Omnipay;

class PayPalController extends Controller
{
    protected $gateway;

    public function __construct()
    {
        // Initialize the PayPal gateway using Omnipay
        $this->gateway = Omnipay::create('PayPal_Express');
        $this->gateway->setUsername(config('omnipay.paypal.username'));
        $this->gateway->setPassword(config('omnipay.paypal.password'));
        $this->gateway->setSignature(config('omnipay.paypal.signature'));
        $this->gateway->setTestMode(config('omnipay.paypal.test_mode'));
    }

    // Show PayPal payment form
    public function createPayment(Request $request)
    {
        // Create the payment request
        $response = $this->gateway->purchase([
            'amount' => '10.00', // Set the payment amount
            'currency' => 'USD',
            'returnUrl' => route('paypal.status'),
            'cancelUrl' => route('paypal.cancel'),
        ])->send();

        // Check if the payment is successful
        if ($response->isRedirect()) {
            return redirect()->away($response->getRedirectUrl());  // Redirect to PayPal
        } else {
            // Handle payment failure
            return redirect()->route('payment.failed');
        }
    }

    // Handle the PayPal response after payment
    public function paymentStatus(Request $request)
    {
        // Get the payment response
        $response = $this->gateway->completePurchase([
            'token' => $request->token,
            'PayerID' => $request->PayerID,
        ])->send();

        if ($response->isSuccessful()) {
            // Payment was successful
            return redirect()->route('payment.success')->with('message', 'Payment successful!');
        } else {
            // Payment failed
            return redirect()->route('payment.failed')->with('message', 'Payment failed!');
        }
    }

    // Cancel page for PayPal
    public function paymentCancel()
    {
        return view('payment.cancel');
    }

    // Success page for PayPal
    public function paymentSuccess()
    {
        return view('payment.success');
    }

    // Failed page for PayPal
    public function paymentFailed()
    {
        return view('payment.failed');
    }
}
