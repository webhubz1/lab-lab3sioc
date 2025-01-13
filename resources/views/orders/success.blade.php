@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="order-success">
            <h1>Thank You for Your Order!</h1>

            @if(session('success'))
                <div class="alert alert-success">
                    {{ session('success') }}
                </div>
            @endif

            <p>Your order has been placed successfully. You will receive a confirmation email shortly.</p>
            <p>Order details and status can be viewed in your <a href="{{ route('my-orders') }}">Order History</a>.</p>

            <a href="{{ route('shop') }}" class="btn btn-primary">Continue Shopping</a>
        </div>
    </div>
@endsection
