@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Inventory</h1>
    <a href="{{ route('inventory.create') }}" class="btn btn-primary">Add Stock</a>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <table classA\="table">
        <thead>
            <tr>
                <th>Product Name</th>
                <th>Quantity Available</th>
                <th>Reorder Level</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($stocks as $stock)
                <tr>
                    <td>{{ $stock->product->product_name }}</td>
                    <td>{{ $stock->quantity_available }}</td>
                    <td>{{ $stock->reorder_level }}</td>
                    <td>
                        <a href="{{ route('inventory.edit', $stock->id) }}" class="btn btn-warning">Edit</a>
                        <form action="{{ route('inventory.destroy', $stock->id) }}" method="POST" style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger">Delete</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection