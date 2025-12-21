<?php

namespace App\Filament\Admin\Resources\PageVisitResource\Pages;

use App\Filament\Admin\Resources\PageVisitResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListPageVisits extends ListRecords
{
    protected static string $resource = PageVisitResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
