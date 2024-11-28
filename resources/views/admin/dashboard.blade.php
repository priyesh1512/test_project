@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Admin Dashboard</h1>
    <p class="mb-4">
        Welcome to the Admin Dashboard! This is your central hub for managing hotels and bookings in the system. 
        Use the tools provided below to add new hotels, manage existing properties, and oversee customer bookings. 
        Ensure everything runs smoothly to provide a great experience for our users.
    </p>

    @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    @if (session('error'))
        <div class="alert alert-danger">
            {{ session('error') }}
        </div>
    @endif

    <div class="mb-3">
        <a href="{{ route('admin.hotels.index') }}" class="btn btn-primary">Manage Hotels</a>
        <a href="{{ route('admin.hotels.create') }}" class="btn btn-success">Add New Hotel</a>
        <a href="{{ route('admin.bookings.index') }}" class="btn btn-secondary">Manage Bookings</a>
    </div>
</div>
@endsection
