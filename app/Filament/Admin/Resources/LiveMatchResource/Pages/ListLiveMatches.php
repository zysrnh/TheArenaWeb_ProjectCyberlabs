<?php

namespace App\Filament\Admin\Resources\LiveMatchResource\Pages;

use App\Filament\Admin\Resources\LiveMatchResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListLiveMatches extends ListRecords
{
    protected static string $resource = LiveMatchResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}