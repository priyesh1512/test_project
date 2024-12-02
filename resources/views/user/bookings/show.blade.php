@extends('layouts.app')

@section('content')
<div class="container">
    <div style="max-width: 800px; margin: 2rem auto; padding: 2rem; box-shadow: 0 0 15px rgba(0,0,0,0.1); border-radius: 8px;">
        <h1 style="color: #2c3e50; margin-bottom: 1.5rem; font-size: 2rem; border-bottom: 2px solid #eee; padding-bottom: 0.5rem;">Booking Details</h1>
        <div style="display: grid; gap: 1rem;">
            <p style="margin: 0.5rem 0; font-size: 1.1rem;"><strong style="color: #34495e; width: 150px; display: inline-block;">Hotel:</strong> {{ $booking->hotel->name }}</p>
            <p style="margin: 0.5rem 0; font-size: 1.1rem;"><strong style="color: #34495e; width: 150px; display: inline-block;">Location:</strong> {{ $booking->hotel->location }}</p>
            <p style="margin: 0.5rem 0; font-size: 1.1rem;"><strong style="color: #34495e; width: 150px; display: inline-block;">Price per Night:</strong> ${{ number_format($booking->hotel->price, 2) }}</p>
            <p style="margin: 0.5rem 0; font-size: 1.1rem;"><strong style="color: #34495e; width: 150px; display: inline-block;">Check-In Date:</strong> {{ $booking->check_in }}</p>
            <p style="margin: 0.5rem 0; font-size: 1.1rem;"><strong style="color: #34495e; width: 150px; display: inline-block;">Check-Out Date:</strong> {{ $booking->check_out }}</p>
            <p style="margin: 0.5rem 0; font-size: 1.1rem;"><strong style="color: #34495e; width: 150px; display: inline-block;">Number of Guests:</strong> {{ $booking->guests }}</p>
            <p style="margin: 0.5rem 0; font-size: 1.1rem;"><strong style="color: #34495e; width: 150px; display: inline-block;">Total Amount:</strong> ${{ number_format($booking->payment_amount / 100, 2) }}</p>
            <p style="margin: 0.5rem 0; font-size: 1.1rem;"><strong style="color: #34495e; width: 150px; display: inline-block;">Payment Status:</strong> {{ ucfirst($booking->payment_status) }}</p>
        </div>
        
        @if($booking->payment_status !== 'succeeded')
            <a href="{{ route('user.bookings.pay.form', $booking) }}" class="btn btn-success" style="background-color: #2ecc71; color: white; padding: 0.75rem 1.5rem; border: none; border-radius: 4px; font-size: 1rem; cursor: pointer; margin-top: 1.5rem;">Pay Now</a>
        @endif
    </div>
</div>
@endsection