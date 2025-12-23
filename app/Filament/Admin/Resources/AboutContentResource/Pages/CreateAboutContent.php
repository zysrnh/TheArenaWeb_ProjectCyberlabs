<?php

namespace App\Filament\Admin\Resources\AboutContentResource\Pages;

use App\Filament\Admin\Resources\AboutContentResource;
use Filament\Resources\Pages\CreateRecord;
use Filament\Notifications\Notification;

class CreateAboutContent extends CreateRecord
{
    protected static string $resource = AboutContentResource::class;

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }

    protected function getCreatedNotification(): ?Notification
    {
        return Notification::make()
            ->success()
            ->title('Konten Berhasil Dibuat')
            ->body('Data konten About baru telah berhasil ditambahkan.');
    }
}