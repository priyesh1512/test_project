<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Booking;

class UserController extends Controller
{
    public function index()
    {
        $bookings = Booking::where('user_id', auth()->id())->with('hotel')->get();
        return view('user.dashboard', compact('bookings'));
    }
}
