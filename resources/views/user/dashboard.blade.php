@extends('layouts.app')

@section('content')
<div class="container">
    <!-- Hero Section -->
    <header class="hero-section py-5 text-center" style="background-color: #b3d7ff; color: #003366;">
        <div class="container">
            <h1 class="display-4 fw-bold">User  Dashboard</h1>
            <p class="lead">Welcome to your personalized dashboard, where you can effortlessly manage all your hotel bookings.</p>
        </div>
    </header>

    <p class="mb-4 text-center" style="color: #0056b3;">
        To initiate a new reservation, simply click the "Book a Hotel" button below. You can also review your existing bookings for detailed information and updates. 
        Our goal is to streamline your travel planning, ensuring a seamless and efficient experience. Be sure to explore exclusive offers and discounts available exclusively for our valued members.
    </p>

    <div class="mb-4 text-center">
        <a href="{{ route('user.bookings.create') }}" class="btn btn-primary btn-lg">Book a Hotel</a>
    </div>

    <p class="text-muted text-center" style="color: #0056b3;">
        <strong>Pro Tip:</strong> Booking in advance can help you secure the best rates and availability for your preferred accommodations!
    </p>

    <h2 class="mt-5" style="color: #003366;">Your Bookings</h2>
    @if($bookings->count())
        <p class="mb-4">Below is a summary of all your reservations. Click on "View" to access more details or to make modifications to your booking.</p>
        <table class="table table-bordered" style="border-color: #b3d7ff;">
            <thead class="table-light" style="background-color: #e7f3ff;">
                <tr>
                    <th>ID</th>
                    <th>Hotel</th>
                    <th>Location</th>
                    <th>Check-In</th>
                    <th>Check-Out</th>
                    <th>Guests</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($bookings as $booking)
                    <tr>
                        <td>{{ $booking->id }}</td>
                        <td>{{ $booking->hotel->name }}</td>
                        <td>{{ $booking->hotel->location }}</td>
                        <td>{{ $booking->check_in }}</td>
                        <td>{{ $booking->check_out }}</td>
                        <td>{{ $booking->guests }}</td>
                        <td>
                            <a href="{{ route('user.bookings.show', $booking) }}" class="btn btn-sm btn-info">View</a>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @else
        <div class="alert alert-info" style="background-color: #e7f3ff; border-color: #b3d7ff;">
            <p>You currently have no bookings. Start planning your next adventure today and discover a diverse range of accommodations, from luxurious hotels to budget-friendly options.</p>
            <p>Why wait? Your next adventure is just a click away!</p>
        </div>
    @endif
</div>
@endsection