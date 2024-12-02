@extends('layouts.app')

@section('content')
<div class="container">
    <div style="max-width: 600px; margin: 2rem auto; padding: 2rem; box-shadow: 0 0 15px rgba(0,0,0,0.1); border-radius: 8px; background: white;">
        <h2 style="color: #2c3e50; margin-bottom: 1.5rem;">Payment for Booking ID: {{ $booking->id }}</h2>
        <p style="font-size: 1.1rem; margin-bottom: 1rem;">
            <strong>Amount:</strong> ${{ number_format($booking->payment_amount / 100, 2) }}
        </p>
        <form action="{{ route('user.bookings.pay.process', $booking) }}" method="POST" id="payment-form" style="display: grid; gap: 1.5rem;">
            @csrf
            <div id="card-element"><!-- Stripe Card Element will be inserted here --></div>
            <div id="card-errors" role="alert" style="color: red;"></div>
            <button type="submit" class="btn btn-primary" style="background-color: #2ecc71; color: white; padding: 0.75rem 1.5rem; border: none; border-radius: 4px; font-size: 1rem; cursor: pointer; transition: background-color 0.3s;">Pay Now</button>
        </form>
    </div>
</div>

<script src="https://js.stripe.com/v3/"></script>
<script>
    const stripe = Stripe('{{ env('STRIPE_KEY') }}');
    const elements = stripe.elements();
    const card = elements.create('card');
    card.mount('#card-element');

    const form = document.getElementById('payment-form');
    form.addEventListener('submit', async (e) => {
        e.preventDefault();
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