<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Booking;
use App\Models\Hotel;
use Stripe\Stripe;
use Stripe\Charge;
use Carbon\Carbon;

class UserController extends Controller
{
    public function dashboard()
    {
        $bookings = Booking::where('user_id', auth()->id())
                          ->with('hotel')
                          ->get();
        return view('user.dashboard', compact('bookings'));
    }

    public function index()
    {
        $bookings = Booking::where('user_id', auth()->id())->with('hotel')->get();
        return view('user.bookings.index', compact('bookings'));
    }

    public function create()
    {
        $hotels = Hotel::all();
        return view('user.bookings.create', compact('hotels'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'hotel_id' => 'required|exists:hotels,id',
            'check_in' => 'required|date',
            'check_out' => 'required|date|after:check_in',
            'guests' => 'required|integer|min:1',
            'stripeToken' => 'required'
        ]);

        // Calculate number of nights
        $checkIn = Carbon::parse($validated['check_in']);
        $checkOut = Carbon::parse($validated['check_out']);
        $numberOfNights = $checkIn->diffInDays($checkOut);

        // Retrieve hotel price per night
        $hotel = Hotel::find($validated['hotel_id']);
        $pricePerNight = $hotel->price;

        // Calculate total amount (in dollars)
        $totalAmount = $numberOfNights * $pricePerNight;

        // Convert to cents for Stripe
        $amountInCents = $totalAmount * 100;

        Stripe::setApiKey(env('STRIPE_SECRET'));

        try {
            $charge = Charge::create([
                "amount" => $amountInCents, // calculated amount in cents
                "currency" => "usd",
                "source" => $validated['stripeToken'],
                "description" => "Payment for booking",
            ]);

            $booking = Booking::create([
                'user_id' => auth()->id(),
                'hotel_id' => $validated['hotel_id'],
                'check_in' => $validated['check_in'],
                'check_out' => $validated['check_out'],
                'guests' => $validated['guests'],
                'payment_id' => $charge->id,
                'payment_amount' => $charge->amount,
                'payment_currency' => $charge->currency,
                'payment_status' => $charge->status,
            ]);

            return redirect()->route('user.bookings.show', $booking)
                ->with('success', 'Booking created and payment successful!');
        } catch (\Exception $e) {
            return back()->withErrors(['payment' => 'Payment failed: ' . $e->getMessage()]);
        }
    }

    public function show(Booking $booking)
    {
        if ($booking->user_id !== auth()->id()) {
            abort(403);
        }
        return view('user.bookings.show', compact('booking'));
    }

    public function checkAvailability(Request $request)
    {
        $request->validate([
            'hotel_id' => 'required|exists:hotels,id',
            'check_in' => 'required|date',
            'check_out' => 'required|date|after:check_in'
        ]);

        $hotel = Hotel::find($request->hotel_id);
        
        // Check if there are any overlapping bookings
        $existingBookings = Booking::where('hotel_id', $request->hotel_id)
            ->where(function($query) use ($request) {
                $query->whereBetween('check_in', [$request->check_in, $request->check_out])
                      ->orWhereBetween('check_out', [$request->check_in, $request->check_out]);
            })->count();

        $available = $existingBookings < $hotel->available_rooms;

        return response()->json([
            'available' => $available,
            'message' => $available ? 'Rooms available' : 'No rooms available for selected dates'
        ]);
    }

    public function edit(Booking $booking)
    {
        if ($booking->user_id !== auth()->id()) {
            abort(403);
        }

        $hotels = Hotel::all();
        return view('user.bookings.edit', compact('booking', 'hotels'));
    }

    public function update(Request $request, Booking $booking)
    {
        if ($booking->user_id !== auth()->id()) {
            abort(403);
        }

        $validated = $request->validate([
            'hotel_id' => 'required|exists:hotels,id',
            'check_in' => 'required|date',
            'check_out' => 'required|date|after:check_in',
            'guests' => 'required|integer|min:1'
        ]);

        $booking->update($validated);

        return redirect()->route('user.bookings.show', $booking)
            ->with('success', 'Booking updated successfully!');
    }

    public function destroy(Booking $booking)
    {
        if ($booking->user_id !== auth()->id()) {
            abort(403);
        }

        $booking->delete();

        return redirect()->route('user.bookings.index')
            ->with('success', 'Booking deleted successfully!');
    }

    /**
     * Show the payment form for an existing booking.
     */
    public function showPaymentForm(Booking $booking)
    {
        if ($booking->user_id !== auth()->id() || $booking->payment_status === 'succeeded') {
            abort(403, 'Unauthorized action.');
        }

        return view('user.bookings.pay', compact('booking'));
    }

    /**
     * Process the payment for an existing booking.
     */
    public function processPayment(Request $request, Booking $booking)
    {
        if ($booking->user_id !== auth()->id() || $booking->payment_status === 'succeeded') {
            abort(403, 'Unauthorized action.');
        }

        $request->validate([
            'stripeToken' => 'required',
        ]);

        Stripe::setApiKey(env('STRIPE_SECRET'));

        try {
            $charge = Charge::create([
                "amount" => $booking->payment_amount, // amount in cents
                "currency" => $booking->payment_currency,
                "source" => $request->stripeToken,
                "description" => "Payment for booking ID: {$booking->id}",
            ]);

            $booking->update([
                'payment_id' => $charge->id,
                'payment_status' => $charge->status,
            ]);

            return redirect()->route('user.bookings.show', $booking)
                ->with('success', 'Payment successful!');
        } catch (\Exception $e) {
            return back()->withErrors(['payment' => 'Payment failed: ' . $e->getMessage()]);
        }
    }
}
