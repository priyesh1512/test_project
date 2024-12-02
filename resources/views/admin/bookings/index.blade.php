@extends('layouts.app')

@section('content')
<div style="padding: 20px;">
    <div class="d-flex justify-content-between mb-3">
        <h1 style="color: #2c3e50;">All Bookings</h1>
        <a href="{{ route('admin.bookings.index') }}" class="btn btn-secondary" style="background-color: #95a5a6; border: none;">Refresh</a>
    </div>

    <form method="GET" action="{{ route('admin.bookings.index') }}" class="mb-3">
        <div class="row g-2">
            <div class="col-md-3">
                <input type="text" name="user" class="form-control" placeholder="User Name" value="{{ request('user') }}">
            </div>
            <div class="col-md-3">
                <input type="text" name="hotel" class="form-control" placeholder="Hotel Name" value="{{ request('hotel') }}">
            </div>
            <div class="col-md-2">
                <input type="date" name="check_in" class="form-control" placeholder="Check-In Date" value="{{ request('check_in') }}">
            </div>
            <div class="col-md-2">
                <input type="date" name="check_out" class="form-control" placeholder="Check-Out Date" value="{{ request('check_out') }}">
            </div>
            <div class="col-md-2">
                <button type="submit" class="btn btn-primary" style="background-color: #3498db; border: none;">Search</button>
            </div>
        </div>
    </form>

    <div style="background-color: #fff; padding: 20px; border-radius: 8px; box-shadow: 0 0 10px rgba(0,0,0,0.1);">
        @if($bookings->isEmpty())
            <p style="text-align: center; color: #7f8c8d;">No bookings found.</p>
        @else
            <table class="table table-bordered" style="background-color: #fff;">
                <thead style="background-color: #34495e; color: #fff;">
                    <tr>
                        <th>ID</th>
                        <th>User</th>
                        <th>Hotel</th>
                        <th>Check-In</th>
                        <th>Check-Out</th>
                        <th>Guests</th>
                        <th>Payment Status</th>
                        <th>Payment Amount</th>
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
                            <td>{{ $booking->payment_status }}</td>
                            <td>{{ number_format($booking->payment_amount / 100, 2) }}</td>
                            <td>
                                <a href="{{ route('admin.bookings.show', $booking) }}" class="btn btn-sm btn-info" style="margin-right: 5px;">View</a>
                                <a href="{{ route('admin.bookings.edit', $booking) }}" class="btn btn-sm btn-warning" style="margin-right: 5px;">Edit</a>
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

            {{-- Pagination --}}
            <div style="display: flex; justify-content: center; margin-top: 20px;">
                <ul class="pagination" style="list-style: none; display: flex; padding: 0; gap: 5px;">
                    @if ($bookings->onFirstPage())
                        <li style="padding: 8px 12px; border: 1px solid #ddd; border-radius: 5px; color: #7f8c8d;">&laquo;</li>
                    @else
                        <li><a href="{{ $bookings->previousPageUrl() }}" style="text-decoration: none; color: #3498db; padding: 8px 12px; border: 1px solid #ddd; border-radius: 5px;">&laquo;</a></li>
                    @endif

                    @foreach ($bookings->links()->elements[0] as $page => $url)
                        @if ($page == $bookings->currentPage())
                            <li style="background-color: #34495e; color: white; padding: 8px 12px; border: 1px solid #34495e; border-radius: 5px;">{{ $page }}</li>
                        @else
                            <li><a href="{{ $url }}" style="text-decoration: none; color: #3498db; padding: 8px 12px; border: 1px solid #ddd; border-radius: 5px;">{{ $page }}</a></li>
                        @endif
                    @endforeach

                    @if ($bookings->hasMorePages())
                        <li><a href="{{ $bookings->nextPageUrl() }}" style="text-decoration: none; color: #3498db; padding: 8px 12px; border: 1px solid #ddd; border-radius: 5px;">&raquo;</a></li>
                    @else
                        <li style="padding: 8px 12px; border: 1px solid #ddd; border-radius: 5px; color: #7f8c8d;">&raquo;</li>
                    @endif
                </ul>
            </div>
        @endif
    </div>
</div>
@endsection
