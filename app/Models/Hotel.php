<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Hotel extends Model
{
    use HasFactory;

    protected $fillable = ['id','name', 'location', 'price'];

    /**
     * Get the bookings for the hotel.
     */
    public function bookings()
    {
        return $this->hasMany(Booking::class);
    }
}
