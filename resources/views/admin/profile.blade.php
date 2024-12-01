@extends('layouts.app')

@section('content')
<div class="container">
    <h1>{{ $admin->name }}'s Profile</h1>
    <h2>Booking Management</h2>
    <table class="table">
        <thead>
            <tr>
                <th>User Name</th>
                <th>Hotel Name</th>
                <th>Check-in Date</th>
                <th>Check-out Date</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            @foreach($bookings as $booking)
                <tr>
                    <td>{{ $booking->user->name }}</td>
                    <td>{{ $booking->hotel->name }}</td>
                    <td>{{ $booking->check_in }}</td>
                    <td>{{ $booking->check_out }}</td>
                    <td>{{ $booking->status }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection