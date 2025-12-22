<?php

namespace App\Filament\Admin\Resources\SponsorResource\Pages;

use App\Filament\Admin\Resources\SponsorResource;
use Filament\Actions;
use Filament\Resources\Pages\ManageRecords;

class ManageSponsors extends ManageRecords
{
    protected static string $resource = SponsorResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
