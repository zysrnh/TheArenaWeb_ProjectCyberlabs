<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;

class Seat extends Model
{
    protected $fillable = [
        'label',
        'type',
        'group_name',
        'row',
        'column',
        'registration_id',
    ];

    protected $appends = [
        'is_available',
    ];

    protected function isAvailable(): Attribute
    {
        return Attribute::make(
            get: fn() => empty($this->registration_id),
        );
    }

    public function registration()
    {
        return $this->belongsTo(Registration::class);
    }

    public function event()
    {
        return $this->belongsTo(Event::class);
    }
}
