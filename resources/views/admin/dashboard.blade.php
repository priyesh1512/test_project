@extends('layouts.app')

@section('content')
<div class="container">
    <!-- Hero Section -->
    <header class="hero-section py-5 text-center" style="background-color: #b3e0ff; color: #003366;">
        <div class="container">
            <h1 class="display-4 fw-bold">Admin Dashboard</h1>
            <p class="lead">Manage hotels and bookings efficiently with our intuitive admin interface.</p>
        </div>
    </header>

    <p class="mb-4" style="color: #0056b3;">
        Welcome to the Admin Dashboard! This is your central hub for managing hotels and bookings in the system. 
        Use the tools provided below to add new hotels, manage existing properties, and oversee customer bookings. 
        Ensure everything runs smoothly to provide a great experience for our users.
    </p>

    @if (session('success'))
        <div class="alert alert-success" style="background-color: #c8e6c9; border-color: #a5d6a7;">
            {{ session('success') }}
        </div>
    @endif

    @if (session('error'))
        <div class="alert alert-danger" style="background-color: #ffccbc; border-color: #ffab91;">
            {{ session('error') }}
        </div>
    @endif

    <div class="mb-4 text-center">
        <div class="btn-group" role="group" aria-label="Admin Actions">
            <a href="{{ route('admin.hotels.index') }}" class="btn btn-primary mx-2">Manage Hotels</a>
            <a href="{{ route('admin.hotels.create') }}" class="btn btn-success mx-2">Add New Hotel</a>
            <a href="{{ route('admin.bookings.index') }}" class="btn btn-secondary mx-2">Manage Bookings</a>
        </div>
    </div>

    <!-- Features Section -->
    <section class="bg-light py-5">
        <div class="container">
            <h2 class="text-center mb-4" style="color: #003366;">Dashboard Features</h2>
            <div class="row text-center">
                <div class="col-md-4">
                    <div class="card mb-4 shadow-sm">
                        <div class="card-body">
                            <h4 style="color: #003366;">Manage Hotels</h4>
                            <p>Easily add, edit, or remove hotels from the system.</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card mb-4 shadow-sm">
                        <div class="card-body">
                            <h4 style="color: #003366;">View Bookings</h4>
                            <p>Monitor and manage all customer bookings in one place.</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card mb-4 shadow-sm">
                        <div class="card-body">
                            <h4 style="color: #003366;">Customer Support</h4>
                            <p>Provide assistance to users to enhance their experience.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

</div>
@endsection