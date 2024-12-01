<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Booking;
use App\Models\Hotel;

class AdminProfileController extends Controller
{

    public function show()
    {
        $admin = Auth::user();
        $bookings = Booking::with(['user', 'hotel'])->where('user_id', $admin->id)->get(); // Adjust as needed
        return view('admin.profile', compact('admin', 'bookings'));
    }

    public function edit()
    {
        $admin = Auth::user();
        return view('admin.profile.edit', compact('admin'));
    }

    public function update(Request $request)
    {
        $admin = Auth::user();
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $admin->id,
            'password' => 'nullable|string|min:8|confirmed',
        ]);

        if (!empty($data['password'])) {
            $data['password'] = bcrypt($data['password']);
        } else {
            unset($data['password']);
        }

        $admin->update($data);

        return redirect()->route('admin.profile')->with('success', 'Profile updated successfully.');
    }
}