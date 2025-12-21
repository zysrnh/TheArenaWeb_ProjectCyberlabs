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
        'rating_facilities',    // ✅ Rating Fasilitas
        'rating_hospitality',   // ✅ Rating Keramahan
        'rating_cleanliness',   // ✅ Rating Kebersihan
        'comment',
    ];

    /**
     * Casting tipe data
     */
    protected $casts = [
        'rating' => 'integer',
        'rating_facilities' => 'integer',
        'rating_hospitality' => 'integer',
        'rating_cleanliness' => 'integer',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    /**
     * ✅ Get average rating dari 3 aspek
     */
    public function getAverageRatingAttribute()
    {
        return round(($this->rating_facilities + $this->rating_hospitality + $this->rating_cleanliness) / 3, 1);
    }

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