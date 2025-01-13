    <!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Checkout</title>
        <!-- Linking Stylesheets -->
        <link rel="stylesheet" href="{{ asset('css/app.css') }}">
        <link rel="stylesheet" href="{{ asset('css/checkout.css') }}">
    </head>
    <body>
        <div class="container mt-5">
            <!-- Page Title -->
            <h1>Checkout</h1>

            <!-- Success Message -->
            @if (session('success'))
                <div class="alert alert-success">
                    {{ session('success') }}
                </div>
            @endif

            <!-- Error Message -->
            @if (session('error'))
                <div class="alert alert-danger">
                    {{ session('error') }}
                </div>
            @endif

         

            <!-- Checkout Form -->
            <form action="{{ route('checkout.process') }}" method="POST" id="checkoutForm">
                @csrf

                <!-- Name Field -->
                <div class="mb-3">
                    <label for="name" class="form-label">Name</label>
                    <input type="text" name="name" id="name" class="form-control" value="{{ old('name') }}" required>
                    @error('name')
                        <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Email Field -->
                <div class="mb-3">
                    <label for="email" class="form-label">Email</label>
                    <input type="email" name="email" id="email" class="form-control" value="{{ old('email') }}" required>
                    @error('email')
                        <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Address Field -->
                <div class="mb-3">
                    <label for="address" class="form-label">Address</label>
                    <textarea name="address" id="address" class="form-control" required>{{ old('address') }}</textarea>
                    @error('address')
                        <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Payment Method Field -->
                <div class="mb-3">
                    <label for="payment_method" class="form-label">Payment Method</label>
                    <select name="payment_method" id="payment_method" class="form-control" required>
                        <option value="">Select a payment method</option>
                        <option value="mock" {{ old('payment_method') == 'mock' ? 'selected' : '' }}>Mock Payment</option>
                        <option value="paypal" {{ old('payment_method') == 'paypal' ? 'selected' : '' }}>PayPal</option>
                        <option value="stripe" {{ old('payment_method') == 'stripe' ? 'selected' : '' }}>Stripe</option>
                    </select>
                    @error('payment_method')
                        <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Stripe Payment Fields (hidden initially) -->
                <div id="stripePaymentFields" style="display: none;">
                    <div class="mb-3">
                        <label for="card-element" class="form-label">Credit or Debit Card</label>
                        <div id="card-element">
                            <!-- A Stripe Element will be inserted here. -->
                        </div>
                        <!-- Used to display form errors. -->
                        <div id="card-errors" role="alert"></div>
                    </div>
                </div>

                <!-- Submit Button -->
                <button type="submit" class="btn btn-primary" id="submitBtn">Proceed to Payment</button>
            </form>
        </div>

        <!-- Stripe JS Script -->
        <script src="https://js.stripe.com/v3/"></script>
        <script>
            // Handle Payment Method Change (show Stripe fields when selected)
            const paymentMethodSelect = document.getElementById('payment_method');
            const stripePaymentFields = document.getElementById('stripePaymentFields');
            const submitButton = document.getElementById('submitBtn');

            paymentMethodSelect.addEventListener('change', function() {
                if (paymentMethodSelect.value === 'stripe') {
                    stripePaymentFields.style.display = 'block';
                } else {
                    stripePaymentFields.style.display = 'none';
                }
            });

            // Set up Stripe.js and Elements
            var stripe = Stripe('your-publishable-key'); // Replace with your actual Stripe publishable key
            var elements = stripe.elements();
            var card = elements.create('card');
            card.mount('#card-element');

            // Handle form submission
            const form = document.getElementById('checkoutForm');
            form.addEventListener('submit', function(event) {
                event.preventDefault();

                if (paymentMethodSelect.value === 'stripe') {
                    stripe.createToken(card).then(function(result) {
                        if (result.error) {
                            // Inform the user if there was an error
                            document.getElementById('card-errors').textContent = result.error.message;
                        } else {
                            // Add the token to the form and submit it
                            var tokenInput = document.createElement('input');
                            tokenInput.setAttribute('type', 'hidden');
                            tokenInput.setAttribute('name', 'stripeToken');
                            tokenInput.setAttribute('value', result.token.id);
                            form.appendChild(tokenInput);
                            form.submit();
                        }
                    });
                } else {
                    // Submit form for PayPal or mock payment
                    form.submit();
                }
            });
        </script>
    </body>
    </html>
