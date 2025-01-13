@extends('layouts.admin') <!-- Extend from the layout -->

@section('content')
<link rel="stylesheet" href="{{ asset('css/admin_dashboard.css') }}">
<div class="container-fluid">
    <div class="row">
        <!-- Sidebar -->
        <aside class="col-md-2 bg-light sidebar">
            <h4 class="text-center">Admin Menu</h4>
            <ul class="nav flex-column">
                <li class="nav-item">
                    <a class="nav-link active" href="{{ route('admin.dashboard') }}">Dashboard</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('admin.users.index') }}">User Management</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('admin.products.index') }}">Product Management</a> <!-- Product Management Link -->
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('admin.orders.index') }}">Orders</a> <!-- Orders Link -->
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('inventory.index') }}">Inventory Management</a>
                </li>
                <!-- Add more navigation links as needed -->
            </ul>
        </aside>

        <!-- Main Content -->
        <main class="col-md-10 ml-sm-auto col-lg-10 px-4">
            <h1>Admin Dashboard</h1>
            <p>Welcome, {{ Auth::user()->name }}!</p>

            
           
@endsection