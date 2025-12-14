<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Review extends Model
{
    use HasFactory;

    /**
     * Kolom yang boleh di-mass assign
     */
    protected $fillable = [
        'client_id',
        'booking_id',
        'rating',
        'comment',
    ];

    /**
     * Casting tipe data
     */
    protected $casts = [
        'rating' => 'integer',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    /**
     * Relasi ke Client (user yang kasih review)
     */
    public function client()
    {
        return $this->belongsTo(Client::class);
    }

    /**
     * Relasi ke Booking (booking yang direview)
     */
    public function booking()
    {
        return $this->belongsTo(Booking::class);
    }
}