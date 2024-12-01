@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Edit Booking</h2>

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('user.bookings.update', $booking) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="form-group">
            <label for="hotel_id">Hotel</label>
            <select name="hotel_id" id="hotel_id" class="form-control" required>
                @foreach($hotels as $hotel)
                    <option value="{{ $hotel->id }}" {{ $booking->hotel_id == $hotel->id ? 'selected' : '' }}>
                        {{ $hotel->name }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="form-group">
            <label for="check_in">Check-In</label>
            <input type="date" name="check_in" id="check_in" class="form-control" value="{{ old('check_in', $booking->check_in) }}" required>
        </div>

        <div class="form-group">
            <label for="check_out">Check-Out</label>
            <input type="date" name="check_out" id="check_out" class="form-control" value="{{ old('check_out', $booking->check_out) }}" required>
        </div>

        <div class="form-group">
            <label for="guests">Number of Guests</label>
            <input type="number" name="guests" id="guests" class="form-control" value="{{ old('guests', $booking->guests) }}" min="1" required>
        </div>

        <button type="submit" class="btn btn-primary">Update Booking</button>
    </form>

    <form action="{{ route('user.bookings.destroy', $booking) }}" method="POST" style="margin-top: 20px;">
        @csrf
        @method('DELETE')
        <button type="submit" class="btn btn-danger">Delete Booking</button>
    </form>
</div>
@endsection