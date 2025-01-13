<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Create Product</title>
    <link rel="stylesheet" href="{{ asset('sc4.css') }}">
</head>
<body>
    <div class="container">
        
        <!-- Main content -->
        <main>
            <h1>Create New Product</h1>

            <!-- Form -->
            <form action="{{ route('admin.products.store') }}" method="POST" enctype="multipart/form-data" role="form" aria-labelledby="create-product-form">
                @csrf

                <!-- Display Validation Errors -->
                @if ($errors->any())
                    <div class="error-messages" aria-live="polite">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <!-- Product Name -->
                <div class="form-group">
                    <label for="product_name">Product Name <span aria-hidden="true">*</span></label>
                    <input 
                        type="text" 
                        id="product_name" 
                        name="product_name" 
                        value="{{ old('product_name') }}" 
                        placeholder="Enter the product name" 
                        required>
                </div>

                <!-- Description -->
                <div class="form-group">
                    <label for="description">Description</label>
                    <textarea 
                        id="description" 
                        name="description" 
                        placeholder="Write a brief description of the product">{{ old('description') }}</textarea>
                </div>

                <!-- Price -->
                <div class="form-group">
                    <label for="price">Price <span aria-hidden="true">*</span></label>
                    <input 
                        type="number" 
                        id="price" 
                        name="price" 
                        step="0.01" 
                        value="{{ old('price') }}" 
                        placeholder="Enter the product price" 
                        required>
                </div>

                <!-- Discount -->
                <div class="form-group">
                    <label for="discount">Discount (%)</label>
                    <input 
                        type="number" 
                        id="discount" 
                        name="discount" 
                        step="0.01" 
                        value="{{ old('discount', 0) }}" 
                        placeholder="Enter a discount percentage (optional)">
                </div>
<!-- Size -->
<div class="form-group">
    <label for="size">Size <span aria-hidden="true">*</span></label>
    <input 
        type="text" 
        id="size" 
        name="size" 
        value="{{ old('size') }}" 
        placeholder="Enter the size" 
        required>
</div>

                

                <!-- Stock -->
                <div class="form-group">
                    <label for="stock">Stock <span aria-hidden="true">*</span></label>
                    <input 
                        type="number" 
                        id="stock" 
                        name="stock" 
                        value="{{ old('stock') }}" 
                        placeholder="Enter the stock quantity" 
                        required>
                </div>

                <!-- Image -->
                <div class="form-group">
                    <label for="image">Image</label>
                    <input 
                        type="file" 
                        id="image" 
                        name="image" 
                        aria-describedby="image-help">
                    <small id="image-help">Supported formats: JPEG, PNG, GIF. Max size: 2MB.</small>
                </div>

                <!-- Submit Button -->
                <button type="submit" class="submit-btn">Create Product</button>
            </form>

            <!-- Back Link -->
            <a href="{{ route('admin.products.index') }}" class="back-link">Back to Product List</a>
        </main>
    </div>
</body>
</html>
