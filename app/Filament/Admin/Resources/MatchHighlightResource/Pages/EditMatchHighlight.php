<?php

namespace App\Filament\Admin\Resources\MatchHighlightResource\Pages;

use App\Filament\Admin\Resources\MatchHighlightResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditMatchHighlight extends EditRecord
{
    protected static string $resource = MatchHighlightResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\ViewAction::make(),
            Actions\DeleteAction::make(),
        ];
    }

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }

    protected function getSavedNotificationTitle(): ?string
    {
        return 'Match highlight updated successfully!';
    }
}