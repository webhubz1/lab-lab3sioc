<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title', 'Admin Dashboard')</title> <!-- Dynamic title -->

    <!-- Admin Dashboard CSS for black-and-white theme -->
    <link rel="stylesheet" href="{{ asset('css/admin-dashboard.css') }}"> 

    <!-- Bootstrap or other frameworks -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    @stack('styles') <!-- For any page-specific CSS -->
</head>
<body>
    <!-- Main Admin Wrapper -->
    <div id="admin-dashboard" class="d-flex flex-column min-vh-100">

        <!-- Admin Navbar -->
        <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
            <div class="container-fluid">
                <a class="navbar-brand" href="{{ url('/admin') }}">
                    {{ config('app.name', 'NEXTGEN Admin') }}
                </a>

                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarAdmin" aria-controls="navbarAdmin" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarAdmin">
                    <ul class="navbar-nav ms-auto">
                        <!-- Links for admin sections -->
                       
                        <!-- Logout -->
                        <li class="nav-item dropdown">
                            <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                {{ Auth::user()->name }}
                            </a>
                            <div class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                                <a class="dropdown-item" href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                    {{ __('Logout') }}
                                </a>
                                <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                    @csrf
                                </form>
                            </div>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>

        <!-- Admin Content -->
        <main class="container-fluid flex-fill py-4">
            <div class="row">
                <!-- Optional Sidebar -->
                <div class="col-md-2">
                    <div class="sidebar bg-light p-3">
                        <h5>Admin Menu</h5>
                        <ul class="nav flex-column">
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('admin.dashboard') }}">Dashboard</a>
                            </li>
                            <li class="nav-item">
                    <a class="nav-link" href="{{ route('admin.users.index') }}">User Management</a>
                </li>
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('admin.products.index') }}">Product Management</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('admin.orders.index') }}">Orders</a>
                            </li>

                            <li class="nav-item">
                    <a class="nav-link" href="{{ route('inventory.index') }}">Inventory Management</a>
                </li>
                        </ul>
                    </div>
                </div>

                <!-- Main Content Area -->
                <div class="col-md-10">
                    @yield('content') <!-- Dynamic content -->
                </div>
            </div>
        </main>

        <!-- Footer (optional) -->
        <footer class="bg-dark text-white text-center py-2">
            <small>&copy; 2024 NEXTGEN Admin Panel</small>
        </footer>

    </div>

    <!-- Bootstrap JS for responsive features -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    @stack('scripts') <!-- For page-specific scripts -->
</body>
</html>
