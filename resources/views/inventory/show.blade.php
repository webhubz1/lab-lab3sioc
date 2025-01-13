<h1>{{ $product->product_name }} - Stock Management</h1>

<p>Current Stock: {{ $stock->quantity_available }}</p>
<p>Reorder Level: {{ $stock->reorder_level }}</p>

<form action="{{ route('inventory.adjust', $product->id) }}" method="POST">
    @csrf
    <label for="quantity">Quantity to Adjust:</label>
    <input type="number" name="quantity" required>
    
    <label for="action">Action:</label>
    <select name="action" required>
        <option value="add">Add Stock</option>
        <option value="subtract">Remove Stock</option>
    </select>

    <button type="submit">Adjust Stock</button>
</form>
