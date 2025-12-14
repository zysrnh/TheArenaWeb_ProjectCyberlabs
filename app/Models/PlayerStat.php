<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PlayerStat extends Model
{
    use HasFactory;

    protected $fillable = [
        'game_id',
        'player_id',
        'team_id',
        'minutes',
        'points',
        'assists',
        'rebounds',
        'steals',
        'blocks',
        'turnovers',
        'fouls',
        'field_goals_made',
        'field_goals_attempted',
        'three_points_made',
        'three_points_attempted',
        'free_throws_made',
        'free_throws_attempted',
        'is_mvp',
    ];

    protected $casts = [
        'is_mvp' => 'boolean',
    ];

    public function game(): BelongsTo
    {
        return $this->belongsTo(Game::class);
    }

    public function player(): BelongsTo
    {
        return $this->belongsTo(Player::class);
    }

    public function team(): BelongsTo
    {
        return $this->belongsTo(Team::class);
    }

    public function getFieldGoalPercentageAttribute()
    {
        if ($this->field_goals_attempted == 0) return 0;
        return round(($this->field_goals_made / $this->field_goals_attempted) * 100, 1);
    }

    public function getThreePointPercentageAttribute()
    {
        if ($this->three_points_attempted == 0) return 0;
        return round(($this->three_points_made / $this->three_points_attempted) * 100, 1);
    }

    public function getFreeThrowPercentageAttribute()
    {
        if ($this->free_throws_attempted == 0) return 0;
        return round(($this->free_throws_made / $this->free_throws_attempted) * 100, 1);
    }
}