<!-- resources/views/checkout/error.blade.php -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Error</title>
</head>
<body>
    <h1>Payment Error</h1>
    <p>There was an error processing your payment. Please try again.</p>
    <a href="{{ route('checkout') }}">Go Back to Checkout</a>
</body>
</html>
