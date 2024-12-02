@extends('layouts.app')

@section('content')
<div class="container">
    <div style="max-width: 800px; margin: 2rem auto; padding: 2rem; box-shadow: 0 0 15px rgba(0,0,0,0.1); border-radius: 8px; background: white;">
        <h1 style="color: #2c3e50; margin-bottom: 1.5rem; font-size: 2rem; border-bottom: 2px solid #eee; padding-bottom: 0.5rem;">Create Booking</h1>
        <form action="{{ route('user.bookings.store') }}" method="POST" id="booking-form" style="display: grid; gap: 1.5rem;">
            @csrf
            <div class="mb-3">
                <label for="hotel_id" class="form-label" style="display: block; margin-bottom: 0.5rem; color: #34495e; font-weight: bold;">Select Hotel</label>
                <select class="form-select" id="hotel_id" name="hotel_id" required style="width: 100%; padding: 0.5rem; border: 1px solid #ddd; border-radius: 4px; font-size: 1rem;">
                    <option value="">Choose...</option>
                    @foreach($hotels as $hotel)
                        <option value="{{ $hotel->id }}" data-price="{{ number_format($hotel->price, 2, '.', '') }}" {{ old('hotel_id') == $hotel->id ? 'selected' : '' }}>
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

            <div class="mb-3">
                <label for="total_amount" class="form-label" style="display: block; margin-bottom: 0.5rem; color: #34495e; font-weight: bold;">Total Amount:</label>
                <input type="text" id="total_amount" name="total_amount_display" readonly style="width: 100%; padding: 0.5rem; border: 1px solid #ddd; border-radius: 4px; font-size: 1rem; background-color: #f9f9f9;">
                <input type="hidden" id="payment_amount" name="payment_amount" value="0">
            </div>

            <div id="card-element"><!-- Stripe Card Element will be inserted here --></div>
            <div id="card-errors" role="alert" style="color: red;"></div>
            <button type="submit" class="btn btn-primary" style="background-color: #3498db; color: white; padding: 0.75rem 1.5rem; border: none; border-radius: 4px; font-size: 1rem; cursor: pointer; transition: background-color 0.3s;">Book Now</button>
        </form>
    </div>
</div>

<script src="https://js.stripe.com/v3/"></script>
<script>
    const stripe = Stripe('{{ env('STRIPE_KEY') }}');
    const elements = stripe.elements();
    const card = elements.create('card');
    card.mount('#card-element');

    const form = document.getElementById('booking-form');

    // Elements to calculate total amount
    const hotelSelect = document.getElementById('hotel_id');
    const checkInInput = document.getElementById('check_in');
    const checkOutInput = document.getElementById('check_out');
    const guestsInput = document.getElementById('guests');
    const totalAmountInput = document.getElementById('total_amount');

    function calculateTotal() {
        const selectedOption = hotelSelect.options[hotelSelect.selectedIndex];
        const pricePerNight = parseFloat(selectedOption.getAttribute('data-price')) || 0;
        console.log('Price per Night:', pricePerNight);

        const checkInDate = new Date(checkInInput.value);
        const checkOutDate = new Date(checkOutInput.value);
        const timeDiff = checkOutDate - checkInDate;
        let numberOfNights = Math.ceil(timeDiff / (1000 * 60 * 60 * 24));
        numberOfNights = numberOfNights > 0 ? numberOfNights : 1; // Ensure at least 1 night
        console.log('Number of Nights:', numberOfNights);

        const numberOfGuests = parseInt(guestsInput.value) || 1;
        console.log('Number of Guests:', numberOfGuests);

        const total = pricePerNight * numberOfNights * numberOfGuests;
        console.log('Total Amount:', total);

        totalAmountInput.value = isNaN(total) || total <= 0 ? '$0.00' : `$${total.toFixed(2)}`;
        document.getElementById('payment_amount').value = isNaN(total) || total <= 0 ? '0' : Math.round(total * 100);
        console.log('Payment Amount (cents):', document.getElementById('payment_amount').value);
    }

    hotelSelect.addEventListener('change', calculateTotal);
    checkInInput.addEventListener('change', calculateTotal);
    checkOutInput.addEventListener('change', calculateTotal);
    guestsInput.addEventListener('input', calculateTotal);

    // Initial calculation
    calculateTotal();

    form.addEventListener('submit', async (e) => {
        // Prevent default form submission
        e.preventDefault();

        // Get the total amount in dollars
        const totalAmountText = totalAmountInput.value.replace('$', '');
        const totalAmount = Math.round(parseFloat(totalAmountText) * 100); // Convert to cents

        if (isNaN(totalAmount) || totalAmount <= 0) {
            alert('Please ensure all booking details are correctly filled.');
            return;
        }

        const {token, error} = await stripe.createToken(card);
        if (error) {
            document.getElementById('card-errors').textContent = error.message;
        } else {
            const hiddenInput = document.createElement('input');
            hiddenInput.setAttribute('type', 'hidden');
            hiddenInput.setAttribute('name', 'stripeToken');
            hiddenInput.setAttribute('value', token.id);
            form.appendChild(hiddenInput);
            form.submit();
        }
    });
</script>
@endsection