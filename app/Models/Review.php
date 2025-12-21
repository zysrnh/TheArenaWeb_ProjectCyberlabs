<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Review extends Model
{
    use HasFactory;

    protected $fillable = [
        'client_id',
        'booking_id',
        'rating',
        'rating_facilities',
        'rating_hospitality',
        'rating_cleanliness',
        'comment',
        'is_approved',        // ✅ TAMBAHAN
        'approved_at',        // ✅ TAMBAHAN
        'approved_by',        // ✅ TAMBAHAN
    ];

    protected $casts = [
        'rating' => 'integer',
        'rating_facilities' => 'integer',
        'rating_hospitality' => 'integer',
        'rating_cleanliness' => 'integer',
        'is_approved' => 'boolean',          // ✅ TAMBAHAN
        'approved_at' => 'datetime',         // ✅ TAMBAHAN
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
     * ✅ Scope untuk hanya ambil review yang sudah di-approve
     */
    public function scopeApproved($query)
    {
        return $query->where('is_approved', true);
    }

    /**
     * ✅ Scope untuk review yang masih pending
     */
    public function scopePending($query)
    {
        return $query->where('is_approved', false);
    }

    public function client()
    {
        return $this->belongsTo(Client::class);
    }

    public function booking()
    {
        return $this->belongsTo(Booking::class);
    }

    /**
     * ✅ Relasi ke admin yang approve (optional)
     */
    public function approvedBy()
    {
        return $this->belongsTo(\App\Models\User::class, 'approved_by');
    }
}