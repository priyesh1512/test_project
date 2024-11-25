@extends('layouts.app')

@section('content')
<div class="container">
    <h1>User Dashboard</h1>
    <div class="mb-3">
        <a href="{{ route('user.bookings.create') }}" class="btn btn-primary">Book a Hotel</a>
    </div>
    <h2>Your Bookings</h2>
    @if($bookings->count())
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
        <p>You have no bookings.</p>
    @endif
</div>
@endsection