<h1>Update Stock for {{ $product->product_name }}</h1>

<form action="{{ route('inventory.update', $product->id) }}" method="POST">
    @csrf

    <label for="quantity_available">Quantity Available:</label>
    <input type="number" name="quantity_available" value="{{ old('quantity_available', $product->stock->quantity_available) }}" required>

    <label for="reorder_level">Reorder Level:</label>
    <input type="number" name="reorder_level" value="{{ old('reorder_level', $product->stock->reorder_level) }}" required>

    <button type="submit">Update Stock</button>
</form>
