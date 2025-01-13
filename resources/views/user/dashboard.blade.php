@extends('layouts.user')

@section('title', 'HOME')

@section('content')
<!-- Welcome Section -->
<div class="welcome-section text-center">
    <h3>Welcome, {{ Auth::user()->name }}!</h3>
    <p class="intro-text">Explore our latest products and offers.</p>
</div>

<!-- Video Advertisement Section -->
<div class="video-ad-container">
    <video autoplay loop muted class="video-ad" width="100%" height="auto">
        <source src="{{ asset('videos/Nike Air Force One - Spec Spot - by Blackfox-Media (4k).mp4') }}" type="video/mp4">
        Your browser does not support the video tag.
    </video>
</div>

<!-- Quote Below the Video -->
<div class="video-quote">
    <p>Own your game.</p>
</div>

<!-- Photo Gallery Section -->
<div class="photo-gallery">
    <div class="photo-grid">
        <div class="photo-item">
            <img src="{{ asset('images/nike1.jpg') }}" alt="Product 1">
        </div>
        <div class="photo-item">
            <img src="{{ asset('images/nike3.jpg') }}" alt="Product 3">
        </div>
        <div class="photo-item">
            <img src="{{ asset('images/nike4.jpg') }}" alt="Product 4">
        </div>
        <div class="photo-item">
            <img src="{{ asset('images/nike2.jpg') }}" alt="Product 2">
        </div>
    </div>

    <!-- Shop Now Button -->
    <div class="shop-now-btn text-center">
        <a href="{{ route('user.products.index') }}" class="btn btn-primary">Shop Now</a>
    </div>
</div>

@endsection

@section('styles')
<link rel="stylesheet" href="{{ asset('css/dashboard.css') }}">
@endsection
