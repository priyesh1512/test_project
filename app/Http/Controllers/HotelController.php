<?php

namespace App\Http\Controllers;

use App\Models\Hotel;
use Illuminate\Http\Request;

class HotelController extends Controller
{
    /**
     * Display a listing of the hotels.
     */
    public function index(Request $request)
    {   
        $query = Hotel::query();

        // Implement search and filtering
        if ($request->filled('location')) {
            $query->where('location', 'like', '%' . $request->location . '%');
        }

        if ($request->filled('price_min')) {
            $query->where('price', '>=', $request->price_min);
        }

        if ($request->filled('price_max')) {
            $query->where('price', '<=', $request->price_max);
        }

        $hotels = $query->get();

        return view('admin.hotels.index', compact('hotels'));
    }

    /**
     * Show the form for creating a new hotel.
     */
    public function create()
    {
        return view('admin.hotels.create');
    }

    /**
     * Store a newly created hotel in storage.
     */
    public function store(Request $request)
    {   
        $request->validate([
            'name' => 'required|string|max:255',
            'location' => 'required|string',
            'price' => 'required|numeric',
            // Add other validations as necessary
        ], [
            'name.required' => 'Hotel name is required.',
            'location.required' => 'Location is required.',
            'price.required' => 'Price is required.',
            'price.numeric' => 'Price must be a number.',
        ]);

        Hotel::create($request->all());

        return redirect()->route('admin.hotels.index')->with('success', 'Hotel created successfully.');
    }

    /**
     * Display the specified hotel.
     */
    public function show(Hotel $hotel)
    {
        return view('admin.hotels.show', compact('hotel'));
    }

    /**
     * Show the form for editing the specified hotel.
     */
    public function edit(Hotel $hotel)
    {
        return view('admin.hotels.edit', compact('hotel'));
    }

    /**
     * Update the specified hotel in storage.
     */
    public function update(Request $request, Hotel $hotel)
    {   
        $request->validate([
            'name' => 'required|string|max:255',
            'location' => 'required|string',
            'price' => 'required|numeric',
            // Add other validations
        ], [
            'name.required' => 'Hotel name is required.',
            'location.required' => 'Location is required.',
            'price.required' => 'Price is required.',
            'price.numeric' => 'Price must be a number.',
        ]);

        $hotel->update($request->all());

        return redirect()->route('admin.hotels.index')->with('success', 'Hotel updated successfully.');
    }

    /**
     * Remove the specified hotel from storage.
     */
    public function destroy(Hotel $hotel)
    {
        $hotel->delete();

        return redirect()->route('admin.hotels.index')->with('success', 'Hotel deleted successfully.');
    }

    /**
     * Check room availability via AJAX.
     */
    public function checkAvailability(Request $request)
    {   
        $request->validate([
            'hotel_id' => 'required|exists:hotels,id',
            'check_in' => 'required|date',
            'check_out' => 'required|date|after:check_in',
        ], [
            'hotel_id.required' => 'Hotel is required.',
            'hotel_id.exists' => 'Selected hotel does not exist.',
            'check_in.required' => 'Check-in date is required.',
            'check_in.date' => 'Check-in date is invalid.',
            'check_out.required' => 'Check-out date is required.',
            'check_out.date' => 'Check-out date is invalid.',
            'check_out.after' => 'Check-out date must be after check-in date.',
        ]);

        $hotel = Hotel::find($request->hotel_id);

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

        return response()->json(['available' => $isAvailable]);
    }
}
