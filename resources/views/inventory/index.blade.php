@extends('layouts.admin')

@section('content')

<div class="container">
    <h1>Inventory List</h1>


    <!-- Search bar for filtering products -->
    <form method="GET" action="{{ route('inventory.index') }}" class="mb-3">
        <div class="input-group">
            <input type="text" class="form-control" name="search" placeholder="Search by product name" value="{{ request()->input('search') }}">
            <button type="submit" class="btn btn-primary">Search</button>
        </div>
    </form>

    <!-- Table displaying the product details -->
    <table class="table">
        <thead>
            <tr>
                <th>Image</th> <!-- New column for product image -->
                <th>Product Name</th>
                <th>Quantity Available</th>
                <th>Reorder Level</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($products as $product)
                <tr>
                    <td>
                        <!-- Display product image -->
                        @if($product->image && file_exists(public_path('images/' . $product->image)))
                            <img src="{{ asset('images/' . $product->image) }}" alt="{{ $product->product_name }}" class="product-image">
                        @else
                            <span>No Image</span>
                        @endif
                    </td>
                    <td>{{ $product->product_name }}</td>
                    <td>
                        {{-- Check if stock exists and display quantity_available --}}
                        @if($product->stock)
                        <span>-  {{ $product->stock }}</span>
                        @else
                            Not available
                        @endif
                    </td>
                    <td>{{ $product->reorder_level }}</td>
                    <td>
                        {{-- Links to view, update, and delete the product --}}
                        <a href="{{ route('products.store', $product->id) }}" class="btn btn-info">View</a>
                        <a href="{{ route('products.edit', $product->id) }}" class="btn btn-warning">Update</a>
                        <form action="{{ route('products.destroy', $product->id) }}" method="POST" style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger">Delete</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <!-- Pagination links -->
    <div class="d-flex justify-content-center">
        {{ $products->links() }}  <!-- Pagination controls -->
    </div>
</div>

@endsection
