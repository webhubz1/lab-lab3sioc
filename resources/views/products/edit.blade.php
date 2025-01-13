<!DOCTYPE html>
<html lang="en">
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Product</title>
    <link rel="stylesheet" href="{{ asset('sc3.css') }}">
</head>
<body>
    <div class="container">
        <!-- Main content -->
        <div class="content">
            <h1>Edit Product</h1>

            <!-- Edit Product Form -->
            <form action="{{ route('products.update', $product->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <!-- Error Messages -->
                @if ($errors->any())
                    <div class="error-messages">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <!-- Product Name -->
                <div class="input-group">
                    <label for="product_name">Product Name:</label>
                    <input type="text" id="product_name" name="product_name" value="{{ old('product_name', $product->product_name) }}" required>
                </div>

                <!-- Description -->
                <div class="input-group">
                    <label for="description">Description:</label>
                    <textarea id="description" name="description">{{ old('description', $product->description) }}</textarea>
                </div>

                <!-- Price -->
                <div class="input-group">
                    <label for="price">Price:</label>
                    <input type="number" id="price" name="price" value="{{ old('price', $product->price) }}" step="0.01" required>
                </div>

                <!-- Stock -->
                <div class="input-group">
                    <label for="stock">Stock:</label>
                    <input type="number" id="stock" name="stock" value="{{ old('stock', $product->stock) }}" required>
                </div>

                <!-- Size -->
                <div class="input-group">
                    <label for="size">Size:</label>
                    <select id="size" name="size" required>
                    <option value="38" {{ old('size', $product->size) == '38' ? 'selected' : '' }}>39</option>
                        <option value="39" {{ old('size', $product->size) == '39' ? 'selected' : '' }}>39</option>
                        <option value="40" {{ old('size', $product->size) == '40' ? 'selected' : '' }}>40</option>
                        <option value="41" {{ old('size', $product->size) == '41' ? 'selected' : '' }}>41</option>
                    </select>
                </div>

                <!-- Discount -->
                <div class="input-group">
                    <label for="discount">Discount (%):</label>
                    <input type="number" name="discount" id="discount" value="{{ old('discount', $product->discount ?? 0) }}" step="0.01" min="0" max="100">
                </div>

                <!-- Image -->
                <div class="input-group">
                    <label for="image">Image:</label>
                    <input type="file" id="image" name="image">
                    @if ($product->image)
                        <div class="image-preview">
                            <img src="{{ asset('images/' . $product->image) }}" alt="{{ $product->product_name }}" width="100">
                        </div>
                    @endif
                </div>

                <!-- Submit Button -->
                <button type="submit" class="submit-btn">Update Product</button>
            </form>

            <!-- Back Link -->
            <a href="{{ route('products.index') }}" class="back-link">Back to Product List</a>
        </div>
    </div>
</body>
</html>
