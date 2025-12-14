<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BookedTimeSlot extends Model
{
    use HasFactory;

    protected $fillable = [
        'booking_id',
        'date',
        'time_slot',
        'venue_type',
    ];

    protected $casts = [
        'date' => 'date',
    ];

    public function booking()
    {
        return $this->belongsTo(Booking::class);
    }
}