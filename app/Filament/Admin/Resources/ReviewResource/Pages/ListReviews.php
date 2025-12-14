<?php

namespace App\Filament\Admin\Resources\ReviewResource\Pages;

use App\Filament\Admin\Resources\ReviewResource;
use Filament\Resources\Pages\ListRecords;
use Filament\Resources\Components\Tab;
use Illuminate\Database\Eloquent\Builder;

class ListReviews extends ListRecords
{
    protected static string $resource = ReviewResource::class;

    // Tidak ada header actions karena view only
    protected function getHeaderActions(): array
    {
        return [];
    }

    public function getTabs(): array
    {
        return [
            'all' => Tab::make('Semua Review'),
            
            '5_stars' => Tab::make('5 Stars')
                ->modifyQueryUsing(fn (Builder $query) => $query->where('rating', 5))
                ->badge(fn () => \App\Models\Review::where('rating', 5)->count())
                ->badgeColor('success'),
            
            '4_stars' => Tab::make('4 Stars')
                ->modifyQueryUsing(fn (Builder $query) => $query->where('rating', 4))
                ->badge(fn () => \App\Models\Review::where('rating', 4)->count())
                ->badgeColor('info'),
            
            '3_stars' => Tab::make('3 Stars')
                ->modifyQueryUsing(fn (Builder $query) => $query->where('rating', 3))
                ->badge(fn () => \App\Models\Review::where('rating', 3)->count())
                ->badgeColor('warning'),
            
            'low_ratings' => Tab::make('Low Ratings (1-2)')
                ->modifyQueryUsing(fn (Builder $query) => $query->whereIn('rating', [1, 2]))
                ->badge(fn () => \App\Models\Review::whereIn('rating', [1, 2])->count())
                ->badgeColor('danger'),
        ];
    }
}