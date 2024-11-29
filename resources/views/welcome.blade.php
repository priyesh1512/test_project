<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hotel Booking System</title>

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">

    <!-- Custom CSS -->
    <link href="{{ asset('css/style.css') }}" rel="stylesheet">
</head>

<body>

    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg shadow" style="background-color: #add8e6;">
        <div class="container">
            <a class="navbar-brand" href="{{ url('/') }}" style="color: #00264d;">
                Hotel Booking System
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
                aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a class="nav-link btn btn-primary text-white me-2" href="{{ route('login') }}">Login</a>
                    </li>
                    @if (Route::has('register'))
                        <li class="nav-item">
                            <a class="nav-link btn btn-primary text-white" href="{{ route('register') }}">Sign Up</a>
                        </li>
                    @endif
                </ul>
            </div>
        </div>
    </nav>

    <!-- Hero Section -->
    <header class="hero-section py-5 text-center"
        style="background-color: #004080; background-size: cover; background-position: center; color: white;">
        <div class="container">
            <h1 class="display-4 fw-bold">Welcome to Hotel Booking System</h1>
            <p class="lead">Find the best deals on hotels and book your perfect stay in just a few clicks</p>
            <a href="{{ route('register') }}" class="btn btn-light btn-lg">Book Now</a>
        </div>
    </header>

    <!-- About Section -->
    <section class="py-5">
        <div class="container">
            <h2 class="text-center mb-4">About Us</h2>
            <p class="text-center">Our Hotel Booking System makes it easy to search, compare, and book hotels worldwide.
                Whether it's a weekend getaway or a business trip, we make finding the perfect stay effortless.</p>
        </div>
    </section>

    <!-- Features Section -->
    <section class="bg-light py-5">
        <div class="container">
            <h2 class="text-center mb-4">Our Features</h2>
            <div class="row text-center">
                <div class="col-md-4">
                    <div class="card mb-4 shadow-sm">
                        <div class="card-body">
                            <h4>Wide Hotel Selection</h4>
                            <p>Access thousands of hotels from luxury resorts to budget-friendly stays.</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card mb-4 shadow-sm">
                        <div class="card-body">
                            <h4>Easy Booking Process</h4>
                            <p>Enjoy a seamless booking experience with secure payments and instant confirmations.</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card mb-4 shadow-sm">
                        <div class="card-body">
                            <h4>Customer Support</h4>
                            <p>24/7 support to assist you with any questions or concerns during your stay.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Discount Offers Section -->
    <section class="py-5">
        <div class="container">
            <h2 class="text-center mb-4">Exclusive Offers</h2>
            <p class="text-center">Save big with our exclusive discounts and deals on top hotels around the world.</p>
        </div>
    </section>

    <!-- Testimonials Section -->
    <section class="py-5">
        <div class="container">
            <h2 class="text-center mb-4">What Our Customers Say</h2>
            <div class="row">
                <div class="col-md-6 mx-auto">
                    <div class="blockquote text-center p-4 border rounded shadow-sm" style="background-color: #f8f9fa;">
                        <p class="mb-0">"Booking our vacation was a breeze. Highly recommend this platform!"</p>
                        <footer class="blockquote-footer mt-3">Enowell Daniel, Satisfied Customer</footer>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="bg-primary text-white py-4">
        <div class="container text-center">
            <p>&copy; 2024 Hotel Booking System. All rights reserved.</p>
        </div>
    </footer>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous">
    </script>

</body>

</html>
