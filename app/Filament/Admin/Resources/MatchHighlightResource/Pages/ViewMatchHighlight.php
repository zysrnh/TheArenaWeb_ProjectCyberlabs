<?php

namespace App\Filament\Admin\Resources\MatchHighlightResource\Pages;

use App\Filament\Admin\Resources\MatchHighlightResource;
use Filament\Actions;
use Filament\Resources\Pages\ViewRecord;

class ViewMatchHighlight extends ViewRecord
{
    protected static string $resource = MatchHighlightResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\EditAction::make(),
            Actions\DeleteAction::make(),
        ];
    }
}