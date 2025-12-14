<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class LiveMatch extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'team_home',
        'team_away',
        'category',
        'venue',
        'court',
        'time',
        'match_date',
        'status',
        'thumbnail',
        'stream_url',
        'series',
        'description',
        'is_active'
    ];

    protected $casts = [
        'match_date' => 'date',
        'is_active' => 'boolean'
    ];

    // Accessor untuk URL thumbnail
    public function getThumbnailUrlAttribute()
    {
        if ($this->thumbnail) {
            return Storage::url($this->thumbnail);
        }
        return asset('images/comingsoon.png');
    }

    // Scope untuk filter matches yang aktif
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    // Scope untuk filter berdasarkan status
    public function scopeByStatus($query, $status)
    {
        if ($status !== 'all') {
            return $query->where('status', $status);
        }
        return $query;
    }

    // Scope untuk filter berdasarkan series
    public function scopeBySeries($query, $series)
    {
        if ($series !== 'all') {
            return $query->where('series', $series);
        }
        return $query;
    }

    // Scope untuk filter berdasarkan waktu
    public function scopeByTimeRange($query, $timeRange)
    {
        if ($timeRange === 'all') {
            return $query;
        }

        $timeRanges = [
            'morning' => ['08:00', '12:00'],
            'afternoon' => ['12:00', '16:00'],
            'evening' => ['16:00', '20:00'],
            'night' => ['20:00', '23:59'],
        ];

        if (isset($timeRanges[$timeRange])) {
            [$start, $end] = $timeRanges[$timeRange];
            return $query->whereRaw("STR_TO_DATE(SUBSTRING_INDEX(time, ' ', 1), '%H:%i') BETWEEN ? AND ?", [$start, $end]);
        }

        return $query;
    }

    // Scope untuk search
    public function scopeSearch($query, $searchTerm)
    {
        if (empty($searchTerm)) {
            return $query;
        }

        return $query->where(function ($q) use ($searchTerm) {
            $q->where('title', 'like', "%{$searchTerm}%")
              ->orWhere('team_home', 'like', "%{$searchTerm}%")
              ->orWhere('team_away', 'like', "%{$searchTerm}%")
              ->orWhere('category', 'like', "%{$searchTerm}%")
              ->orWhere('venue', 'like', "%{$searchTerm}%");
        });
    }
}                                                                                                                         