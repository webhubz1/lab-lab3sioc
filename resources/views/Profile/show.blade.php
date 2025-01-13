@extends('layouts.app')

@section('content')
    <h1>User Profile</h1>

    <p><strong>Name:</strong> {{ auth()->user()->name }}</p>
    <p><strong>Email:</strong> {{ auth()->user()->email }}</p>

    <!-- Add the Update Profile Button -->
    <a href="{{ route('profile.edit') }}" class="btn btn-primary">Update Profile</a>
@endsection