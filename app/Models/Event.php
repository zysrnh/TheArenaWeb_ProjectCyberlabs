<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Event extends Model
{
    use SoftDeletes, HasFactory;

    protected $fillable = [
        'name',
        'slug',
    ];

    protected static function booted(): void
    {
        static::creating(function (Event $event) {
            $event->slug = str($event->name)->slug();
        });
    }

    public function registrations()
    {
        return $this->hasMany(Registration::class);
    }

    public function seats()
    {
        return $this->hasMany(Seat::class);
    }
}
