@extends('layouts.admin')
<link rel="stylesheet" href="{{ asset('css/admin_dashboard.css') }}">

@section('content')

    <div class="container">
        <h1 class="page-title">Add User</h1>

        <form action="{{ route('admin.users.store') }}" method="POST" class="form-create-user">
            @csrf

            <div class="form-group">
                <label for="name" class="form-label">Name:</label>
                <input type="text" name="name" id="name" class="form-input" required>
            </div>

            <div class="form-group">
                <label for="email" class="form-label">Email:</label>
                <input type="email" name="email" id="email" class="form-input" required>
            </div>

            <div class="form-group">
                <label for="password" class="form-label">Password:</label>
                <input type="password" name="password" id="password" class="form-input" required>
            </div>

            <div class="form-group">
                <label for="password_confirmation" class="form-label">Confirm Password:</label>
                <input type="password" name="password_confirmation" id="password_confirmation" class="form-input" required>
            </div>

            <div class="form-group">
                <label for="role" class="form-label">Role:</label>
                <select name="role" id="role" class="form-select">
                    <option value="user">User</option>
                    <option value="admin">Admin</option>
                </select>
            </div>

            <div class="form-actions">
                <button type="submit" class="btn btn-primary">Create User</button>
                <a href="{{ route('admin.users.index') }}" class="btn btn-secondary">Cancel</a>
            </div>
        </form>
    </div>
@endsection