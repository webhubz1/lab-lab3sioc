@extends('layouts.user')

@section('content')
    <div class="cart-container">
        <h1 class="page-title">Your Shopping Cart</h1>

        {{-- Success Message --}}
        @if(session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        {{-- Check if the cart is empty --}}
        @if(empty($cart) || count($cart) == 0)
            <p class="empty-cart-message">
                Your cart is empty. 
                <a href="{{ route('user.products.index') }}" class="continue-shopping-link">Continue shopping</a>
            </p>
        @else
            <div class="cart-items">
                @php 
                    $total = 0;
                    $discountedTotal = 0;
                @endphp

                @foreach($cart as $productId => $item)
                    @php 
                        $product = \App\Models\Product::find($productId); // Fetch product details
                        $itemPrice = $item['price'];
                        $discount = $product ? $product->discount ?? 0 : 0; // Discount percentage
                        $finalPrice = $itemPrice - ($itemPrice * ($discount / 100));
                        $total += $itemPrice * $item['quantity'];
                        $discountedTotal += $finalPrice * $item['quantity'];
                    @endphp

                    <div class="cart-item">
                        <div class="cart-item-image">
                            @if($product && $product->image)
                                <img src="{{ asset('images/' . $product->image) }}" alt="{{ $product->name }}">
                            @else
                                <p>Image not available</p>
                            @endif
                        </div>

                        <div class="cart-item-details">
                            @if($product)
                                <h3>{{ $product->name }}</h3>
                                <p class="cart-item-price">Original Price: ${{ number_format($itemPrice, 2) }}</p>
                                <p class="cart-item-discount">Discount: {{ $discount }}%</p>
                                <p class="cart-item-final-price">Price After Discount: ${{ number_format($finalPrice, 2) }}</p>
                                <span>- size: 
                            {{ $product->size ? implode(', ', explode(',', $product->size)) : 'Not specified' }}
                        </span>

                            @else
                                <h3>Product not found</h3>
                            @endif

                            <p class="cart-item-quantity">
                                <form action="{{ route('cart.update') }}" method="POST" class="update-quantity-form">
                                    @csrf
                                    <input type="hidden" name="product_id" value="{{ $productId }}">
                                    <input type="number" name="quantity" value="{{ $item['quantity'] }}" min="1" class="quantity-input">
                                    <button type="submit" class="update-button">Update</button>
                                </form>
                            </p>
                        </div>

                        <div class="cart-item-total">
                            <p>Total: ${{ number_format($finalPrice * $item['quantity'], 2) }}</p>
                            <form action="{{ route('cart.update') }}" method="POST" class="remove-item-form">
                                @csrf
                                <input type="hidden" name="product_id" value="{{ $productId }}">
                                <input type="hidden" name="quantity" value="0">
                                <button type="submit" class="remove-button">Remove</button>
                            </form>
                        </div>
                    </div>
                @endforeach
            </div>

            {{-- Cart Summary --}}
            <div class="cart-summary">
                <h4>Original Total: ${{ number_format($total, 2) }}</h4>
                <h4>Total After Discounts: ${{ number_format($discountedTotal, 2) }}</h4>
                <a href="{{ route('checkout') }}" class="checkout-button">Proceed to Checkout</a>
            </div>
        @endif
    </div>
@endsection

{{-- Link to CSS file --}}
@push('styles')
<link rel="stylesheet" href="{{ asset('css/cart.css') }}">
@endpush
