@extends('layouts.app')

@section('content')
<div class="container">
    <div style="max-width: 800px; margin: 2rem auto; padding: 2rem; box-shadow: 0 0 15px rgba(0,0,0,0.1); border-radius: 8px;">
        <h1 style="color: #2c3e50; margin-bottom: 1.5rem; font-size: 2rem; border-bottom: 2px solid #eee; padding-bottom: 0.5rem;">Booking Details</h1>
        <div style="display: grid; gap: 1rem;">
            <p style="margin: 0.5rem 0; font-size: 1.1rem;"><strong style="color: #34495e; width: 150px; display: inline-block;">Hotel:</strong> {{ $booking->hotel->name }}</p>
            <p style="margin: 0.5rem 0; font-size: 1.1rem;"><strong style="color: #34495e; width: 150px; display: inline-block;">Location:</strong> {{ $booking->hotel->location }}</p>
            <p style="margin: 0.5rem 0; font-size: 1.1rem;"><strong style="color: #34495e; width: 150px; display: inline-block;">Price per Night:</strong> ${{ number_format($booking->hotel->price, 2) }}</p>
            <p style="margin: 0.5rem 0; font-size: 1.1rem;"><strong style="color: #34495e; width: 150px; display: inline-block;">Check-In:</strong> {{ $booking->check_in }}</p>
            <p style="margin: 0.5rem 0; font-size: 1.1rem;"><strong style="color: #34495e; width: 150px; display: inline-block;">Check-Out:</strong> {{ $booking->check_out }}</p>
            <p style="margin: 0.5rem 0; font-size: 1.1rem;"><strong style="color: #34495e; width: 150px; display: inline-block;">Guests:</strong> {{ $booking->guests }}</p>
        </div>
        <div style="margin-top: 2rem;">
            <a href="{{ route('user.bookings.index') }}" class="btn btn-secondary" style="background-color: #34495e; color: white; padding: 0.5rem 1rem; text-decoration: none; border-radius: 4px; transition: background-color 0.3s;">Back to Bookings</a>
        </div>
    </div>
</div>
@endsection