@extends('layouts.app')

@section('content')
<div class="container">
    <h1>{{ $user->name }}'s Profile</h1>
    <h2>Booking History</h2>
    <table class="table">
        <thead>
            <tr>
                <th>Hotel Name</th>
                <th>Check-in Date</th>
                <th>Check-out Date</th>
            </tr>
        </thead>
        <tbody>
            @foreach($bookings as $booking)
                <tr>
                    <td>{{ $booking->hotel->name }}</td> <!-- Assuming a relationship exists -->
                    <td>{{ $booking->check_in }}</td>
                    <td>{{ $booking->check_out }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection