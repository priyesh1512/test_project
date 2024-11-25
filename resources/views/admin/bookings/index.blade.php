@extends('layouts.app')

@section('content')
<div style="padding: 20px;">
    <div class="d-flex justify-content-between mb-3">
        <h1 style="color: #2c3e50;">All Bookings</h1>
        <a href="{{ route('admin.bookings.index') }}" class="btn btn-secondary" style="background-color: #95a5a6; border: none;">Refresh</a>
    </div>

    <div style="background-color: #fff; padding: 20px; border-radius: 8px; box-shadow: 0 0 10px rgba(0,0,0,0.1);">
        @if($bookings->count())
            <table class="table table-bordered" style="background-color: #fff;">
                <thead style="background-color: #34495e; color: #fff;">
                    <tr>
                        <th>ID</th>
                        <th>User</th>
                        <th>Hotel</th>
                        <th>Check-In</th>
                        <th>Check-Out</th>
                        <th>Guests</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($bookings as $booking)
                        <tr style="transition: background-color 0.3s;">
                            <td>{{ $booking->id }}</td>
                            <td>{{ $booking->user->name }}</td>
                            <td>{{ $booking->hotel->name }}</td>
                            <td>{{ $booking->check_in }}</td>
                            <td>{{ $booking->check_out }}</td>
                            <td>{{ $booking->guests }}</td>
                            <td>
                                <a href="{{ route('admin.bookings.edit', $booking) }}" class="btn btn-sm btn-warning" style="margin-right: 5px;">Edit</a>
                                <a href="{{ route('admin.bookings.show', $booking) }}" class="btn btn-sm btn-info" style="margin-right: 5px;">View</a>
                                <form action="{{ route('admin.bookings.destroy', $booking) }}" method="POST" style="display: inline-block;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger" style="background-color: #e74c3c; border: none;" onclick="return confirm('Are you sure you want to delete this booking?')">Delete</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @else
            <p style="text-align: center; color: #7f8c8d;">No bookings found.</p>
        @endif
    </div>
</div>
@endsection