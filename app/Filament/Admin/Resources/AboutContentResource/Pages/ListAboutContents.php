<?php

// File 1: ListAboutContents.php
namespace App\Filament\Admin\Resources\AboutContentResource\Pages;

use App\Filament\Admin\Resources\AboutContentResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListAboutContents extends ListRecords
{
    protected static string $resource = AboutContentResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}