<?php

namespace App\Filament\Admin\Resources\MatchHighlightResource\Pages;

use App\Filament\Admin\Resources\MatchHighlightResource;
use Filament\Resources\Pages\CreateRecord;

class CreateMatchHighlight extends CreateRecord
{
    protected static string $resource = MatchHighlightResource::class;

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }

    protected function getCreatedNotificationTitle(): ?string
    {
        return 'Match highlight created successfully!';
    }
}