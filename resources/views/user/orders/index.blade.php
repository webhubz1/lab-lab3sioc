@extends('layouts.user')

@section('content')
    <div class="orders">
        <h1>My Orders</h1>

        @if($orders->isEmpty())
            <p>You have no orders yet.</p>
        @else
            <table class="table">
                <thead>
                    <tr>
                        <th>Order ID</th>
                        <th>Total Amount</th>
                        <th>Payment Status</th>
                        <th>Shipping Status</th>
                        <th>Order Date</th>
                        <th>Details</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($orders as $order)
                        <tr>
                            <td>{{ $order->id }}</td>
                            <td>{{ $order->total_amount }}</td>
                            <td>{{ $order->payment_status }}</td>
                            <td>{{ $order->shipping_status }}</td>
                            <td>{{ $order->created_at->format('Y-m-d') }}</td>
                            <td>
                                <a href="{{ route('user.order.details', $order->id) }}" class="btn btn-info">View Details</a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @endif
    </div>
@endsection
