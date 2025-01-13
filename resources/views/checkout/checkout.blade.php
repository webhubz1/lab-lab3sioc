<form action="{{ route('checkout.process') }}" method="POST">
    @csrf
    <input type="text" name="name" placeholder="Name" required>
    <input type="email" name="email" placeholder="Email" required>
    <textarea name="address" placeholder="Address" required></textarea>
    <select name="payment_method" required>
        <option value="paypal">PayPal</option>
        <option value="stripe">Stripe</option>
    </select>
    <button type="submit">Place Order</button>
</form>
