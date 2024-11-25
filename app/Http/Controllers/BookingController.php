<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\Hotel;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use App\Mail\BookingConfirmation;

class BookingController extends Controller
{
    /**
     * Display a listing of the bookings (admin).
     */
    public function index()
    {   
        $bookings = Booking::with(['hotel', 'user'])->get();

        return view('admin.bookings.index', compact('bookings'));
    }

    /**
     * Show the form for creating a new booking (user).
     */
    public function create()
    {   
        $hotels = Hotel::all();

        return view('user.bookings.create', compact('hotels'));
    }

    /**
     * Store a newly created booking in storage (user).
     */
    public function store(Request $request)
    {   
        $request->validate([
            'hotel_id' => 'required|exists:hotels,id',
            'check_in' => 'required|date',
            'check_out' => 'required|date|after:check_in',
            'guests' => 'required|integer|min:1',
        ], [
            'hotel_id.required' => 'Please select a hotel.',
            'hotel_id.exists' => 'Selected hotel does not exist.',
            'check_in.required' => 'Please select a check-in date.',
            'check_in.date' => 'Check-in must be a valid date.',
            'check_out.required' => 'Please select a check-out date.',
            'check_out.date' => 'Check-out must be a valid date.',
            'check_out.after' => 'Check-out must be after check-in.',
            'guests.required' => 'Please specify the number of guests.',
            'guests.integer' => 'Number of guests must be an integer.',
            'guests.min' => 'At least one guest is required.',
        ]);

        $hotel = Hotel::find($request->hotel_id);

        // Optional: Check availability again before booking
        $isAvailable = !$hotel->bookings()
            ->where(function($query) use ($request) {
                $query->whereBetween('check_in', [$request->check_in, $request->check_out])
                      ->orWhereBetween('check_out', [$request->check_in, $request->check_out])
                      ->orWhere(function($q) use ($request) {
                          $q->where('check_in', '<=', $request->check_in)
                            ->where('check_out', '>=', $request->check_out);
                      });
            })
            ->exists();

        if (!$isAvailable) {
            return back()->withErrors(['availability' => 'No rooms available for the selected dates.']);
        }

        $booking = Booking::create([
            'user_id'   => Auth::id(),
            'hotel_id'  => $request->hotel_id,
            'check_in'  => $request->check_in,
            'check_out' => $request->check_out,
            'guests'    => $request->guests,
        ]);

        // Send confirmation email
        Mail::to(Auth::user()->email)->send(new BookingConfirmation($booking));

        return redirect()->route('user.bookings.index')->with('success', 'Booking created successfully. A confirmation email has been sent.');
    }

    /**
     * Display the specified booking.
     */
    public function show(Booking $booking)
    {   
        // For admin or the user who owns the booking
        if (Auth::user()->role === 'admin' || Auth::id() === $booking->user_id) {
            return view('user.bookings.show', compact('booking'));
        }

        abort(403, 'Unauthorized action.');
    }

    /**
     * Show the form for editing the specified booking (admin).
     */
    public function edit(Booking $booking)
    {   
        $hotels = Hotel::all();
        $users = User::all(); // Admin can change user associated

        return view('admin.bookings.edit', compact('booking', 'hotels', 'users'));
    }

    /**
     * Update the specified booking in storage (admin).
     */
    public function update(Request $request, Booking $booking)
    {   
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'hotel_id' => 'required|exists:hotels,id',
            'check_in' => 'required|date',
            'check_out' => 'required|date|after:check_in',
            'guests' => 'required|integer|min:1',
        ], [
            'user_id.required' => 'User is required.',
            'user_id.exists' => 'Selected user does not exist.',
            'hotel_id.required' => 'Hotel is required.',
            'hotel_id.exists' => 'Selected hotel does not exist.',
            'check_in.required' => 'Check-in date is required.',
            'check_in.date' => 'Check-in must be a valid date.',
            'check_out.required' => 'Check-out date is required.',
            'check_out.date' => 'Check-out must be a valid date.',
            'check_out.after' => 'Check-out must be after check-in.',
            'guests.required' => 'Number of guests is required.',
            'guests.integer' => 'Number of guests must be an integer.',
            'guests.min' => 'At least one guest is required.',
        ]);

        $hotel = Hotel::find($request->hotel_id);

        $isAvailable = !$hotel->bookings()
            ->where('id', '!=', $booking->id)
            ->where(function($query) use ($request) {
                $query->whereBetween('check_in', [$request->check_in, $request->check_out])
                      ->orWhereBetween('check_out', [$request->check_in, $request->check_out])
                      ->orWhere(function($q) use ($request) {
                          $q->where('check_in', '<=', $request->check_in)
                            ->where('check_out', '>=', $request->check_out);
                      });
            })
            ->exists();

        if (!$isAvailable) {
            return back()->withErrors(['availability' => 'No rooms available for the selected dates.']);
        }

        $booking->update([
            'user_id'   => $request->user_id,
            'hotel_id'  => $request->hotel_id,
            'check_in'  => $request->check_in,
            'check_out' => $request->check_out,
            'guests'    => $request->guests,
        ]);

        return redirect()->route('admin.bookings.index')->with('success', 'Booking updated successfully.');
    }

    /**
     * Remove the specified booking from storage (admin).
     */
    public function destroy(Booking $booking)
    {   
        $booking->delete();

        return redirect()->route('admin.bookings.index')->with('success', 'Booking deleted successfully.');
    }

    /**
     * Display booking index for user.
     */
    public function indexUserBookings()
    {   
        $bookings = Booking::where('user_id', Auth::id())->with('hotel')->get();

        return view('user.bookings.index', compact('bookings'));
    }

    /**
     * Display user dashboard with bookings
     */
    public function userDashboard()
    {   
        $bookings = Booking::where('user_id', Auth::id())->with('hotel')->get();

        return view('user.dashboard', compact('bookings'));
    }
}
