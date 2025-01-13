<!DOCTYPE html>
<html lang="en">
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Products List</title>
    <link rel="stylesheet" href="{{ asset('sc2.css') }}">
</head>
<body>
    <nav class="navbar">
        <ul class="nav-links">
            <li><a href="{{ route('admin.dashboard') }}" class="nav-link">Admin Dashboard</a></li>
        </ul>
    </nav>

    <div class="content-container">
        <main class="content">
            <h1 class="page-title">Product Management</h1>

            @if (session('success'))
                <div class="message">
                    {{ session('success') }}
                </div>
            @endif

            <!-- Search Form -->
            <form action="{{ route('products.index') }}" method="GET" class="search-form">
                <input type="text" name="search" value="{{ request('search') }}" placeholder="Search products...">
                <button type="submit">Search</button>
            </form>

            <!-- Add New Product Link -->
            <div class="add-product-link">
                <a href="{{ route('products.create') }}">Add New Product</a>
            </div>

            <!-- List of products -->
            <ul class="products-list">
                @foreach ($products as $product)
                    <li class="product-item">
                        <strong>{{ $product->product_name }}</strong>
                        <span>- ${{ number_format($product->price, 2) }}</span>
                        <span>- Discount: {{ $product->discount ? $product->discount . '%' : 'No discount' }}</span>
                        <span>- Stock: {{ $product->stock }}</span>
                        
                        <!-- Sizes -->
                        <span>- Available size: 
                            {{ $product->size ? implode(', ', explode(',', $product->size)) : 'Not specified' }}
                        </span>

                        @if ($product->image)
                            <img src="{{ asset('images/' . $product->image) }}" alt="{{ $product->product_name }}" class="product-image">
                        @endif
                        <a href="#" class="description-button" data-description="{{ $product->description }}">View Description</a>

                        <a href="{{ route('products.edit', $product->id) }}" class="edit-button">Edit</a>

                        <form action="{{ route('products.destroy', $product->id) }}" method="POST" style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="delete-button" onclick="return confirm('Are you sure you want to delete this product?');">Delete</button>
                        </form>
                    </li>
                @endforeach
            </ul>

            <!-- Modal for displaying descriptions -->
            <div class="popup-content" style="display: none;">
                <span class="close">&times;</span>
                <h2>Product Description</h2>
                <p class="description-text"></p>
            </div>
        </main>
    </div>

    <script>
        // Script to handle viewing the product description in a popup
        document.querySelectorAll('.description-button').forEach(button => {
            button.addEventListener('click', function(event) {
                event.preventDefault();
                const description = event.target.dataset.description;
                document.querySelector('.description-text').textContent = description;
                document.querySelector('.popup-content').style.display = 'block';
            });
        });

        document.querySelector('.popup-content .close').addEventListener('click', function() {
            document.querySelector('.popup-content').style.display = 'none';
        });
    </script>
</body>
</html>
