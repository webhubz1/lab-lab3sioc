@extends('layouts.admin')

@section('content')
    <!-- Include the stylesheet properly -->
    <link rel="stylesheet" href="{{ asset('admin_dashboard.css') }}">

    <div class="container">
        <div class="edit-user-form">
            <h1>Edit User</h1>
    
            <form action="{{ route('admin.users.update', $user) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="form-group">
                    <label for="name">Name:</label>
                    <input type="text" id="name" name="name" value="{{ $user->name }}" required class="form-control">
                </div>

                <div class="form-group">
                    <label for="email">Email:</label>
                    <input type="email" id="email" name="email" value="{{ $user->email }}" required class="form-control">
                </div>

                <div class="form-group">
                    <label for="password">Password (leave blank to keep current password):</label>
                    <input type="password" id="password" name="password" class="form-control">
                </div>

                <div class="form-group">
                    <label for="password_confirmation">Confirm Password:</label>
                    <input type="password" id="password_confirmation" name="password_confirmation" class="form-control">
                </div>

                <!-- Add a dropdown for role selection -->
                <div class="form-group">
                    <label for="role">Role:</label>
                    <select id="role" name="role" required class="form-control">
                        <option value="user" {{ $user->role == 'user' ? 'selected' : '' }}>User</option>
                        <option value="admin" {{ $user->role == 'admin' ? 'selected' : '' }}>Admin</option>
                    </select>
                </div>

                <button type="submit" class="btn btn-primary">Update User</button>
            </form>
        </div>
    </div>
@endsection
