@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Booking Details</h1>
    <p><strong>User:</strong> {{ $booking->user->name }} ({{ $booking->user->email }})</p>
    <p><strong>Hotel:</strong> {{ $booking->hotel->name }}</p>
    <p><strong>Location:</strong> {{ $booking->hotel->location }}</p>
    <p><strong>Price per Night:</strong> ${{ number_format($booking->hotel->price) }}</p>
    <p><strong>Check-In:</strong> {{ $booking->check_in }}</p>
    <p><strong>Check-Out:</strong> {{ $booking->check_out }}</p>
    <p><strong>Guests:</strong> {{ $booking->guests }}</p>

    <!-- Payment Details Section Removed -->
    <h2>Payment Details</h2>
    <p><strong>Payment Status:</strong> {{ $booking->payment_status }}</p>
    <p><strong>Amount:</strong> ${{ number_format($booking->payment_amount / 100, 2) }}</p>
    <p><strong>Currency:</strong> {{ strtoupper($booking->payment_currency) }}</p>
    <p><strong>Payment Date:</strong> {{ $booking->updated_at }}</p>

    <a href="{{ route('admin.bookings.edit', $booking) }}" class="btn btn-warning">Edit Booking</a>
    <form action="{{ route('admin.bookings.destroy', $booking) }}" method="POST" style="display: inline-block;">
        @csrf
        @method('DELETE')
        <button type="submit" class="btn btn-danger" onclick="return confirm('Are you sure you want to delete this booking?')">Delete</button>
    </form>
    <a href="{{ route('admin.bookings.index') }}" class="btn btn-secondary">Back to Bookings</a>
</div>
@endsection