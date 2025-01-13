<?php

return [
    'paypal' => [
        'username' => env('OMNIPAY_PAYPAL_API_USERNAME'),
        'password' => env('OMNIPAY_PAYPAL_API_PASSWORD'),
        'signature' => env('OMNIPAY_PAYPAL_API_SIGNATURE'),
        'test_mode' => env('OMNIPAY_PAYPAL_MODE') === 'sandbox',  // Use sandbox for testing
    ],
];
