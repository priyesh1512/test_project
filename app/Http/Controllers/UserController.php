<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Booking;
use App\Models\Hotel;

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
            'guests' => 'required|integer|min:1'
        ]);

        $booking = Booking::create([
            'user_id' => auth()->id(),
            'hotel_id' => $validated['hotel_id'],
            'check_in' => $validated['check_in'],
            'check_out' => $validated['check_out'],
            'guests' => $validated['guests']
        ]);

        return redirect()->route('user.bookings.show', $booking)
            ->with('success', 'Booking created successfully!');
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
}
