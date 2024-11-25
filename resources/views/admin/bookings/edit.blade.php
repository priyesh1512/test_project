@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Edit Booking</h1>
    <form action="{{ route('admin.bookings.update', $booking) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="mb-3">
            <label for="user_id" class="form-label">User</label>
            <select class="form-select" id="user_id" name="user_id" required>
                @foreach($users as $user)
                    <option value="{{ $user->id }}" {{ $booking->user_id == $user->id ? 'selected' : '' }}>
                        {{ $user->name }} ({{ $user->email }})
                    </option>
                @endforeach
            </select>
            @error('user_id')
                <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>
        <div class="mb-3">
            <label for="hotel_id" class="form-label">Hotel</label>
            <select class="form-select" id="hotel_id" name="hotel_id" required>
                @foreach($hotels as $hotel)
                    <option value="{{ $hotel->id }}" {{ $booking->hotel_id == $hotel->id ? 'selected' : '' }}>
                        {{ $hotel->name }} - ${{ number_format($hotel->price, 2) }}
                    </option>
                @endforeach
            </select>
            @error('hotel_id')
                <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>
        <div class="mb-3">
            <label for="check_in" class="form-label">Check-In Date</label>
            <input type="date" class="form-control" id="check_in" name="check_in" value="{{ old('check_in', $booking->check_in) }}" required>
            @error('check_in')
                <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>
        <div class="mb-3">
            <label for="check_out" class="form-label">Check-Out Date</label>
            <input type="date" class="form-control" id="check_out" name="check_out" value="{{ old('check_out', $booking->check_out) }}" required>
            @error('check_out')
                <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>
        <div class="mb-3">
            <label for="guests" class="form-label">Number of Guests</label>
            <input type="number" class="form-control" id="guests" name="guests" value="{{ old('guests', $booking->guests) }}" min="1" required>
            @error('guests')
                <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>
        <button type="submit" class="btn btn-primary">Update Booking</button>
    </form>
</div>
@endsection