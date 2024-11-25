@extends('layouts.app')

@section('content')
<div class="container">
    <div style="max-width: 800px; margin: 2rem auto; padding: 2rem; box-shadow: 0 0 15px rgba(0,0,0,0.1); border-radius: 8px; background: white;">
        <h1 style="color: #2c3e50; margin-bottom: 1.5rem; font-size: 2rem; border-bottom: 2px solid #eee; padding-bottom: 0.5rem;">Create Booking</h1>
        <form id="booking-form" action="{{ route('user.bookings.store') }}" method="POST" style="display: grid; gap: 1.5rem;">
            @csrf
            <div class="mb-3">
                <label for="hotel_id" class="form-label" style="display: block; margin-bottom: 0.5rem; color: #34495e; font-weight: bold;">Select Hotel</label>
                <select class="form-select" id="hotel_id" name="hotel_id" required style="width: 100%; padding: 0.5rem; border: 1px solid #ddd; border-radius: 4px; font-size: 1rem;">
                    <option value="">Choose...</option>
                    @foreach($hotels as $hotel)
                        <option value="{{ $hotel->id }}" {{ old('hotel_id') == $hotel->id ? 'selected' : '' }}>
                            {{ $hotel->name }} - ${{ number_format($hotel->price, 2) }}
                        </option>
                    @endforeach
                </select>
                @error('hotel_id')
                    <div class="text-danger" style="color: #e74c3c; margin-top: 0.5rem; font-size: 0.9rem;">{{ $message }}</div>
                @enderror
            </div>

            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1rem;">
                <div class="mb-3">
                    <label for="check_in" class="form-label" style="display: block; margin-bottom: 0.5rem; color: #34495e; font-weight: bold;">Check-In Date</label>
                    <input type="date" class="form-control" id="check_in" name="check_in" value="{{ old('check_in') }}" required style="width: 100%; padding: 0.5rem; border: 1px solid #ddd; border-radius: 4px; font-size: 1rem;">
                    @error('check_in')
                        <div class="text-danger" style="color: #e74c3c; margin-top: 0.5rem; font-size: 0.9rem;">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="check_out" class="form-label" style="display: block; margin-bottom: 0.5rem; color: #34495e; font-weight: bold;">Check-Out Date</label>
                    <input type="date" class="form-control" id="check_out" name="check_out" value="{{ old('check_out') }}" required style="width: 100%; padding: 0.5rem; border: 1px solid #ddd; border-radius: 4px; font-size: 1rem;">
                    @error('check_out')
                        <div class="text-danger" style="color: #e74c3c; margin-top: 0.5rem; font-size: 0.9rem;">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <div class="mb-3">
                <label for="guests" class="form-label" style="display: block; margin-bottom: 0.5rem; color: #34495e; font-weight: bold;">Number of Guests</label>
                <input type="number" class="form-control" id="guests" name="guests" value="{{ old('guests') }}" min="1" required style="width: 100%; padding: 0.5rem; border: 1px solid #ddd; border-radius: 4px; font-size: 1rem;">
                @error('guests')
                    <div class="text-danger" style="color: #e74c3c; margin-top: 0.5rem; font-size: 0.9rem;">{{ $message }}</div>
                @enderror
            </div>

            <div id="availability-message" class="mb-3"></div>

            <button type="submit" class="btn btn-primary" style="background-color: #3498db; color: white; padding: 0.75rem 1.5rem; border: none; border-radius: 4px; font-size: 1rem; cursor: pointer; transition: background-color 0.3s;">Book Now</button>
        </form>
    </div>
</div>
@endsection

@section('scripts')
<script>
    const bookingForm = document.getElementById('booking-form');

    bookingForm.addEventListener('submit', function(e) {
        e.preventDefault();

        const hotelId = document.getElementById('hotel_id').value;
        const checkIn = document.getElementById('check_in').value;
        const checkOut = document.getElementById('check_out').value;

        if (!hotelId || !checkIn || !checkOut) {
            alert('Please fill all required fields.');
            return;
        }

        fetch(`{{ route('hotels.checkAvailability') }}?hotel_id=${hotelId}&check_in=${checkIn}&check_out=${checkOut}`)
            .then(response => response.json())
            .then(data => {
                const messageDiv = document.getElementById('availability-message');
                const submitButton = bookingForm.querySelector('button[type="submit"]');
                if (data.available) {
                    messageDiv.innerHTML = '<div class="alert alert-success">Rooms are available!</div>';
                    submitButton.disabled = false;
                    // Optionally proceed to submit
                    bookingForm.submit();
                } else {
                    messageDiv.innerHTML = '<div class="alert alert-danger">No rooms available for the selected dates.</div>';
                    submitButton.disabled = true;
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('An error occurred while checking availability.');
            });
    });
</script>
@endsection