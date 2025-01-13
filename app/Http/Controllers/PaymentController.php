<?php

namespace App\Http\Controllers;

use Omnipay\Omnipay;
use Illuminate\Http\Request;

class PaymentController extends Controller
{
    // Show PayPal payment form
    public function showPaymentForm()
    {
        return view('payment.paypal');
    }

    // Handle payment request
    public function handlePayment(Request $request)
    {
        $gateway = Omnipay::create('PayPal_Rest');
        
        // Set up the PayPal credentials from your environment or config file
        $gateway->setClientId(env('PAYPAL_CLIENT_ID'));
        $gateway->setSecret(env('PAYPAL_SECRET'));
        $gateway->setTestMode(env('PAYPAL_SANDBOX') === 'true'); // Set to false for live transactions

        $purchaseRequest = $gateway->purchase([
            'amount' => $request->amount,
            'currency' => 'USD',
            'returnUrl' => route('payment.success'),
            'cancelUrl' => route('payment.cancel'),
        ]);

        $response = $purchaseRequest->send();

        if ($response->isRedirect()) {
            // Redirect to PayPal for payment
            return $response->redirect();
        } else {
            // Payment failed
            return redirect()->route('payment.failed')->with('error', $response->getMessage());
        }
    }

    // Handle payment success
    public function paymentSuccess(Request $request)
    {
        $gateway = Omnipay::create('PayPal_Rest');
        $gateway->setClientId(env('PAYPAL_CLIENT_ID'));
        $gateway->setSecret(env('PAYPAL_SECRET'));
        $gateway->setTestMode(env('PAYPAL_SANDBOX') === 'true'); // Set to false for live transactions

        $completePurchase = $gateway->completePurchase([
            'amount' => $request->amount,
            'currency' => 'USD',
            'transactionReference' => $request->get('paymentId'),
        ]);

        $response = $completePurchase->send();

        if ($response->isSuccessful()) {
            // Payment successful
            return redirect()->route('payment.success')->with('message', 'Payment was successful!');
        } else {
            // Payment failed
            return redirect()->route('payment.failed')->with('error', $response->getMessage());
        }
    }

    // Handle payment failure
    public function paymentFailure()
    {
        return view('payment.failure')->with('error', 'Payment failed!');
    }

    // Handle payment cancellation
    public function paymentCancel()
    {
        return view('payment.cancel')->with('error', 'Payment was canceled.');
    }
}
