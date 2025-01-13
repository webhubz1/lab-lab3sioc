@extends('layouts.app') <!-- Assuming you have a layout file -->

@section('content')
<!DOCTYPE html>
<html>
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home Page</title>
    
    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Archivo+Black&family=Manrope:wght@200..800&family=Noto+Serif:ital,wght@0,100..900;1,100..900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('sc.css') }}">
</head>  
<body>
    <div class="hero">
        <!-- Adding a video background -->
        <video autoplay loop muted playsinline class="video">
            <source src="{{ asset('webpic/nbg.mp4') }}" type="video/mp4">
            Your browser does not support the video tag.
        </video>
        
        <!-- Navigation Bar -->
        <nav class="bg-gray-800 p-4">
            <div class="container mx-auto flex justify-between">
                <div></div> <!-- Removed logo here -->
                <div class="flex space-x-4">
                    @if (Auth::check())
                        <a href="{{ route('dashboard') }}" class="text-white">Dashboard</a>
                        <form action="{{ route('logout') }}" method="POST" class="inline">
                            @csrf
                            <button type="submit" class="text-white">Logout</button>
                        </form>
                    @endif
                </div>
            </div>
        </nav>

        <!-- Removed the welcome message section -->
        <!-- Pop-up content for About section -->
        <div id="about" class="popup-content">
            <h2>About Us</h2>
            <p>Welcome to Bahay Store, your go-to place for amazing products. Our store is dedicated to bringing you quality and style in every item we offer. Explore our range and enjoy a unique shopping experience.</p>
            <button onclick="closePopup()">Close</button>
        </div>
    </div>

    <!-- New Section with Image -->
    <div class="image-section" style="padding: 50px 0; text-align: center; background-color: #f9f9f9;">
        <img src="{{ asset('images/nextgens.png') }}" alt="NextGen Nike Shoes" style="max-width: 100%; height: auto;">
    </div>

</body>
</html>
@endsection
