<?php

namespace App\Http\Controllers;

use App\Models\Hotel;
use App\Models\Booking;
use App\Models\User;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    // Show the admin dashboard
    public function dashboard()
    {
        return view('admin.dashboard');
    }

    // Hotel management methods
    public function index()
    {
        $hotels = Hotel::all();
        return view('admin.hotels.index', compact('hotels'));
    }

    public function create()
    {
        return view('admin.hotels.create');
    }

    public function store(Request $request)
    {
        // Validate and create hotel
        $request->validate([
            'name' => 'required|string|max:255',
            'location' => 'required|string|max:255',
            // Add other validations as needed
        ]);

        Hotel::create($request->all());
        return redirect()->route('admin.hotels.index')->with('success', 'Hotel created successfully.');
    }

    public function show(Hotel $hotel)
    {
        return view('admin.hotels.show', compact('hotel'));
    }

    public function edit(Hotel $hotel)
    {
        return view('admin.hotels.edit', compact('hotel'));
    }

    public function update(Request $request, Hotel $hotel)
    {
        // Validate and update hotel
        $request->validate([
            'name' => 'required|string|max:255',
            'location' => 'required|string|max:255',
            // Add other validations as needed
        ]);

        $hotel->update($request->all());
        return redirect()->route('admin.hotels.index')->with('success', 'Hotel updated successfully.');
    }

    public function destroy(Hotel $hotel)
    {
        $hotel->delete();
        return redirect()->route('admin.hotels.index')->with('success', 'Hotel deleted successfully.');
    }

    // Booking management methods
    public function bookingsIndex()
    {
        $bookings = Booking::all();
        return view('admin.bookings.index', compact('bookings'));
    }

    public function bookingsShow(Booking $booking)
    {
        return view('admin.bookings.show', compact('booking'));
    }

    public function bookingsEdit(Booking $booking)
    {
        return view('admin.bookings.edit', compact('booking'));
    }

    public function bookingsUpdate(Request $request, Booking $booking)
    {
        // Validate and update booking
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'hotel_id' => 'required|exists:hotels,id',
            // Add other validations as needed
        ]);

        $booking->update($request->all());
        return redirect()->route('admin.bookings.index')->with('success', 'Booking updated successfully.');
    }

    public function bookingsDestroy(Booking $booking)
    {
        $booking->delete();
        return redirect()->route('admin.bookings.index')->with('success', 'Booking deleted successfully.');
    }
}