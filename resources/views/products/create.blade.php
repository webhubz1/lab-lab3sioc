</head>
<body>
    <div class="hero">
        <!-- Adding a video background -->
        <video autoplay loop muted playsinline class="video">
            <source src="{{ asset('webpic/nbg.mp4') }}" type="video/mp4">
            Your browser does not support the video tag.
        </video>
        <link rel="stylesheet" href="{{ asset('sc3.css') }}">
        <nav>
          
            <ul>
            <li><a href="{{ route('admin.dashboard') }}" class="nav-link">Admin Dashboard</a></li>

            </ul>
        </nav>

        <!-- Main content container -->
        <div class="content-container">
            <main class="content">
                <h1>Create New Product</h1>
                <form action="{{ route('products.store') }}" method="POST" enctype="multipart/form-data" class="product-form">
                    @csrf

                    <!-- Display Validation Errors -->
                    @if ($errors->any())
                        <div class="error-messages">
                                <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <label for="product_name">Product Name:</label>
                    <input type="text" id="product_name" name="product_name" value="{{ old('product_name') }}" required>

                    <label for="description">Description:</label>
                    <textarea id="description" name="description">{{ old('description') }}</textarea>

                    <label for="price">Price:</label>
                    <input type="number" id="price" name="price" step="0.01" value="{{ old('price') }}" required>

                    <label for="stock">Stock:</label>
                    <input type="number" id="stock" name="stock" value="{{ old('stock') }}" required>
                    
                    <label for="image">Image:</label>
                    <input type="file" id="image" name="image">

                    <button type="submit">Create Product</button>
                </form>

                <a href="{{ route('products.index') }}" class="back-link">Back to Product List</a>
            </main>
        </div>
    </div>
</body>
</html>