<?php

namespace App\Filament\Admin\Resources\MatchHighlightResource\Pages;

use App\Filament\Admin\Resources\MatchHighlightResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListMatchHighlights extends ListRecords
{
    protected static string $resource = MatchHighlightResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}