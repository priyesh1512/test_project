@extends('layouts.app')

@section('content')
<div class="container" style="padding: 2rem 0;">
    <h1 style="color: #2c3e50; margin-bottom: 1.5rem; font-size: 2rem;">Your Bookings</h1>
    @if($bookings->count())
        <div style="overflow-x: auto;">
            <table class="table table-bordered" style="width: 100%; border-collapse: collapse; background: white; box-shadow: 0 0 15px rgba(0,0,0,0.1); border-radius: 8px; overflow: hidden;">
                <thead>
                    <tr style="background-color: #34495e; color: white;">
                        <th style="padding: 1rem; text-align: left;">ID</th>
                        <th style="padding: 1rem; text-align: left;">Hotel</th>
                        <th style="padding: 1rem; text-align: left;">Location</th>
                        <th style="padding: 1rem; text-align: left;">Check-In</th>
                        <th style="padding: 1rem; text-align: left;">Check-Out</th>
                        <th style="padding: 1rem; text-align: left;">Guests</th>
                        <th style="padding: 1rem; text-align: center;">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($bookings as $booking)
                        <tr style="transition: background-color 0.3s; border-bottom: 1px solid #eee;">
                            <td style="padding: 1rem;">{{ $booking->id }}</td>
                            <td style="padding: 1rem;">{{ $booking->hotel->name }}</td>
                            <td style="padding: 1rem;">{{ $booking->hotel->location }}</td>
                            <td style="padding: 1rem;">{{ $booking->check_in }}</td>
                            <td style="padding: 1rem;">{{ $booking->check_out }}</td>
                            <td style="padding: 1rem;">{{ $booking->guests }}</td>
                            <td style="padding: 1rem; text-align: center;">
                                <a href="{{ route('user.bookings.show', $booking) }}" class="btn btn-sm btn-info" style="background-color: #3498db; color: white; padding: 0.5rem 1rem; text-decoration: none; border-radius: 4px; border: none;">View</a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @else
        <p style="text-align: center; padding: 2rem; background: white; border-radius: 8px; box-shadow: 0 0 15px rgba(0,0,0,0.1);">You have no bookings.</p>
    @endif
</div>
@endsection