@extends('layouts.user')

@section('title', 'My Cart')

@section('content')
<div class="cart-container">
    <h1 class="page-title">My Cart</h1>

    @if(empty($cart))
        <div class="empty-cart">
            <p>Your cart is empty.</p>
            <a href="{{ route('products.index') }}" class="btn btn-primary">Browse Products</a>
        </div>
    @else
        <div class="cart-table-container">
            <table class="cart-table">
                <thead>
                    <tr>
                        <th>Product</th>
                        <th>Price</th>
                        <th>Discount</th>
                        <th>Final Price</th>
                        <th>Quantity</th>
                        <th>Total</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($cart as $id => $item)
                    <tr>
                        <td class="product-details">
                            <img src="{{ asset('images/' . $item['image']) }}" alt="{{ $item['name'] }}" class="product-image">
                            <div>
                                <strong>{{ $item['name'] }}</strong>
                            </div>
                        </td>
                        <td class="price">${{ number_format($item['price'], 2) }}</td>
                        <td class="discount">
                            {{ $item['discount'] ? $item['discount'] . '%' : 'No Discount' }}
                        </td>
                        
                        <td class="final-price">
                            ${{ number_format($item['price'] - ($item['price'] * ($item['discount'] / 100)), 2) }}
                        </td>
                        <td class="quantity">
                            <form action="{{ route('cart.update', $id) }}" method="POST">
                                @csrf
                                <input type="number" name="quantity" value="{{ $item['quantity'] }}" min="1" class="quantity-input">
                                <button type="submit" class="btn btn-update">Update</button>
                            </form>
                        </td>
                        <td class="total">
                            ${{ number_format(($item['price'] - ($item['price'] * ($item['discount'] / 100))) * $item['quantity'], 2) }}
                        </td>
                        <td class="actions">
                            <form action="{{ route('cart.remove', $id) }}" method="POST">
                                @csrf
                                <button type="submit" class="btn btn-remove">Remove</button>
                            </form>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>

            <div class="cart-summary">
                <h3>Total Price: 
                    <span>
                        ${{ number_format($totalPriceWithDiscount, 2) }}
                    </span>
                </h3>
            </div>

            <div class="cart-actions">
                <a href="{{ route('products.index') }}" class="btn btn-secondary">Continue Shopping</a>
                <a href="{{ route('checkout') }}" class="btn btn-primary">Proceed to Checkout</a>
            </div>
        </div>
    @endif
</div>

<link rel="stylesheet" href="{{ asset('css/cart.css') }}">
@endsection
