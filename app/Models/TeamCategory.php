<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class TeamCategory extends Model
{
    protected $fillable = [
        'team_id',
        'category_name',
        'age_group',
        'min_age',
        'max_age',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    public function team(): BelongsTo
    {
        return $this->belongsTo(Team::class);
    }

    public function players(): HasMany
    {
        return $this->hasMany(Player::class);
    }
    
    // Helper untuk display name lengkap
    public function getFullNameAttribute(): string
    {
        return $this->team->name . ' ' . $this->category_name;
    }
}