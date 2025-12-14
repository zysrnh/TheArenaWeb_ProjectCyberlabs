<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class Client extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
        'province',          // TAMBAHKAN
        'city',              // TAMBAHKAN
        'address',           // TAMBAHKAN
        'phone',             // TAMBAHKAN
        'gender',            // TAMBAHKAN
        'birth_date',        // TAMBAHKAN
        'profile_image',     // TAMBAHKAN
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'birth_date' => 'date', // TAMBAHKAN untuk casting tanggal
        ];
    }
    public function bookings()
{
    return $this->hasMany(Booking::class);

}
/**
 * Relasi ke Reviews
 */
public function reviews()
{
    return $this->hasMany(Review::class);
}
}