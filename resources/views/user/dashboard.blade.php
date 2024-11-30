@extends('layouts.app')

@section('content')
<div class="container">
    <h1>User Dashboard</h1>
    <p class="mb-4">
        Welcome to your dashboard! Here, you can manage all your hotel bookings in one place. 
        Use the "Book a Hotel" button below to make a new reservation, or browse your existing bookings for details and updates. 
        We aim to make your travel planning seamless and efficient. Don’t forget to check out exclusive offers and discounts available for our members.
    </p>
    
    <div class="mb-3">
        <a href="{{ route('user.bookings.create') }}" class="btn btn-primary">Book a Hotel</a>
    </div>

    <p class="text-muted">
        Pro Tip: Booking early can help you secure the best rates and availability for your preferred hotels!
    </p>
    
    <h2>Your Bookings</h2>
    @if($bookings->count())
        <p class="mb-4">Here's a summary of all your reservations. Click on "View" to see more details or make changes to your booking.</p>
        <table class="table table-bordered">
            <thead>
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
        <div class="alert alert-info">
            <p>You have no bookings yet. Start planning your next trip today and explore a wide range of accommodations, from luxurious hotels to budget-friendly stays.</p>
            <p>Why wait? Adventure is just a click away!</p>
        </div>
    @endif
</div>
@endsection
