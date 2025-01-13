@extends('layouts.user')

@section('content') <!-- Start of the content section -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Products List</title>
    <link rel="stylesheet" href="{{ asset('css/products.css') }}"> <!-- Updated path to CSS -->
</head>
<body>

    <div class="content-container">
        <main class="content">
            <h1 class="page-title">Available Products</h1>

            @if (session('success'))
                <div class="message">
                    {{ session('success') }}
                </div>
            @endif

            <!-- Search Form -->
            <form action="{{ route('user.products.index') }}" method="GET" class="search-form">
                <input type="text" name="search" value="{{ request('search') }}" placeholder="Search products...">
                <button type="submit">Search</button>
            </form>

<!-- List of products -->
<ul class="products-list">
    @foreach ($products as $product)
        <li class="product-item">
            <strong>{{ $product->product_name }}</strong>
            <span>- ${{ number_format($product->price, 2) }}</span>
            @if ($product->discount > 0)
                <span class="discounted-price">
                    Discounted Price: ${{ number_format($product->price * (1 - $product->discount / 100), 2) }}
                </span>
                <span class="discount-percentage">
                    ({{ $product->discount }}% Off)
                </span>
            @endif
            <span>- Stock: {{ $product->stock }}</span>

            <span>- Available size: 
                            {{ $product->size ? implode(', ', explode(',', $product->size)) : 'Not specified' }}
                        </span>

            @if ($product->image)
                <img src="{{ asset('images/' . $product->image) }}" alt="{{ $product->product_name }}" class="product-image">
            @endif
            <form action="{{ route('user.cart.add', $product->id) }}" method="POST" style="display:inline;">
                @csrf
                <input type="hidden" name="quantity" value="1">
                <button type="submit" class="add-to-cart-button" {{ $product->stock > 0 ? '' : 'disabled' }}>
                    {{ $product->stock > 0 ? 'Add to Cart' : 'Out of Stock' }}
                </button>
            </form>
            <a href="#" class="description-button" data-description="{{ $product->description }}">View Description</a>
        </li>
    @endforeach
</ul>


            <!-- Modal for displaying descriptions -->
            <div class="popup-content" style="display: none;">
                <span class="close">&times;</span>
                <h2>Product Description</h2>
                <p class="description-text"></p>
            </div>

            <!-- Pagination Links -->
            <div class="pagination">
                {{ $products->links() }} <!-- Use pagination links if you're paginating the products -->
            </div>
        </main>
    </div>

    <script>
        // JavaScript to handle the popup for product descriptions
        const descriptionButtons = document.querySelectorAll('.description-button');
        const popupContent = document.querySelector('.popup-content');
        const closeButton = document.querySelector('.close');

        descriptionButtons.forEach(button => {
            button.addEventListener('click', (e) => {
                e.preventDefault();
                const description = button.getAttribute('data-description');
                popupContent.querySelector('.description-text').textContent = description;
                popupContent.style.display = 'block';
            });
        });

        closeButton.addEventListener('click', () => {
            popupContent.style.display = 'none';
        });

        // Close the popup if clicking outside of it
        window.addEventListener('click', (event) => {
            if (event.target === popupContent) {
                popupContent.style.display = 'none';
            }
        });
    </script>
</body>
</html>
@endsection <!-- End of the content section -->
