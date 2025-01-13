<?php

return [
    'mode' => env('PAYPAL_MODE', 'sandbox'),
    'sandbox' => [
        'client_id' => env('AcgqSlfOPfNpTDyGiE6w2Fd2_z12rbIxZiH4bU2HiiJX6SyNzgUil9ejgtTXsUC6FWLGyOhHKzv77wZX'),
        'client_secret' => env('EDo6SGwv_aKZrTeGmHyoUIQ tPTwgTobBq5pe6wy5wD_eBCO_FXe5L8qpY40Or5vt-kDeriwHnBb_wjDW'),
    ],
    'live' => [
        'client_id' => env('PAYPAL_LIVE_CLIENT_ID'),
        'client_secret' => env('PAYPAL_LIVE_SECRET'),
    ],
    'currency' => env('PAYPAL_CURRENCY', 'USD'),
    'locale' => 'en_US',
    'validate_ssl' => true,
];
