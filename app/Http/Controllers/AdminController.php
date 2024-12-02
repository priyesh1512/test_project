<?php

namespace App\Http\Controllers;

use App\Models\Hotel;
use App\Models\Booking;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminController extends Controller
{
    // Show the admin dashboard
    public function dashboard()
    {
        return view('admin.dashboard');
    }

    // Hotel management methods
    public function index(Request $request)
    {
        // Get hotels with pagination
        $query = Hotel::query();

        // Apply search filters if provided
        if ($request->filled('location')) {
            $query->where('location', 'like', '%' . $request->location . '%');
        }

        if ($request->filled('price_min')) {
            $query->where('price', '>=', $request->price_min);
        }

        if ($request->filled('price_max')) {
            $query->where('price', '<=', $request->price_max);
        }

        // Paginate results
        $hotels = $query->paginate(10); // Change the number to set how many items per page

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
    public function bookingsIndex(Request $request)
    {
        // Get bookings with pagination without payment details
        $query = Booking::with(['user', 'hotel']); // Removed 'payment'

        // Apply search filters if provided
        if ($request->filled('user')) {
            $query->whereHas('user', function($q) use ($request) {
                $q->where('name', 'like', '%' . $request->user . '%');
            });
        }

        if ($request->filled('hotel')) {
            $query->whereHas('hotel', function($q) use ($request) {
                $q->where('name', 'like', '%' . $request->hotel . '%');
            });
        }

        if ($request->filled('check_in')) {
            $query->whereDate('check_in', '>=', $request->check_in);
        }

        if ($request->filled('check_out')) {
            $query->whereDate('check_out', '<=', $request->check_out);
        }

        // Paginate results
        $bookings = $query->paginate(10)->appends($request->query()); // Change the number to set how many items per page

        return view('admin.bookings.index', compact('bookings'));
    }

    public function bookingsShow(Booking $booking)
    {
        // No need to load 'payment' relationship
        return view('admin.bookings.show', compact('booking'));
    }

    public function bookingsEdit(Booking $booking)
    {
        // Retrieve all users and hotels to populate the dropdowns
        $users = User::all(); // Get all users
        $hotels = Hotel::all(); // Get all hotels

        return view('admin.bookings.edit', compact('booking', 'users', 'hotels'));
    }

    public function bookingsUpdate(Request $request, Booking $booking)
    {
        // Validate and update booking
        $request->validate([
            'user_id' => 'required|exists:users,id',
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