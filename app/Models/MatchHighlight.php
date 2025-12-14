<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class MatchHighlight extends Model
{
    protected $fillable = [
        'game_id',
        'title',
        'description',
        'thumbnail',
        'video_url',
        'quarter',
        'duration',
        'views',
        'is_featured',
        'status',
    ];

    protected $casts = [
        'is_featured' => 'boolean',
        'views' => 'integer',
    ];

    public function game(): BelongsTo
    {
        return $this->belongsTo(Game::class);
    }

    // Accessor untuk thumbnail URL
    public function getThumbnailUrlAttribute()
    {
        if (!$this->thumbnail) {
            return 'https://images.unsplash.com/photo-1546519638-68e109498ffc?w=800';
        }

        if (str_starts_with($this->thumbnail, 'http')) {
            return $this->thumbnail;
        }

        return asset('storage/' . $this->thumbnail);
    }

    // Accessor untuk format views
    public function getFormattedViewsAttribute()
    {
        if ($this->views >= 1000000) {
            return number_format($this->views / 1000000, 1) . 'M';
        }
        if ($this->views >= 1000) {
            return number_format($this->views / 1000, 1) . 'K';
        }
        return (string) $this->views;
    }

    // Scope untuk active highlights
    public function scopeActive($query)
    {
        return $query->where('status', 'active');
    }

    // Scope untuk featured highlights
    public function scopeFeatured($query)
    {
        return $query->where('is_featured', true);
    }
}