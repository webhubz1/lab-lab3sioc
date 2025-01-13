<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'User Dashboard')</title>
    <link rel="stylesheet" href="{{ asset('css/app.css') }}"> <!-- Main CSS file -->
    <link rel="stylesheet" href="{{ asset('css/dashboard.css') }}"> <!-- Dashboard-specific styles -->
    @stack('styles') <!-- Allows additional styles to be pushed from child views -->
</head>
<body>
    <header>
        <div class="container">
           
            <nav>
                <ul>
                    <li><a href="{{ route('user.dashboard') }}">Dashboard</a></li>
                    <li><a href="{{ route('user.profile') }}">Profile</a></li>
                    <li><a href="{{ route('user.products.index') }}">Product List</a></li>
                    <li><a href="{{ route('user.cart.view') }}">My Cart</a></li> <!-- Link to the user's cart -->
                    <li><a href="{{ route('my.orders') }}">My Orders</a></li> <!-- Link to the user's orders -->
                    <li>
                        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: inline;">
                            @csrf
                            <button type="submit" style="background: none; border: none; color: inherit; cursor: pointer;">
                                Logout
                            </button>
                        </form>
                    </li>
                </ul>
            </nav>
        </div>
    </header>

    <main class="container">
        @yield('content') <!-- This is where the content of child views will be injected -->
    </main>

    <footer>
        <div class="container">
            <p>&copy; {{ date('Y') }} NEXTGEN SHOES. All rights reserved.</p>
        </div>
    </footer>

    <script src="{{ asset('js/app.js') }}"></script> <!-- Main JavaScript file -->
    @stack('scripts') <!-- Allows additional scripts to be pushed from child views -->
</body>
</html>
