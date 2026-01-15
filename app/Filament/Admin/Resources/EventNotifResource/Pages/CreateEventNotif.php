<?php

namespace App\Filament\Admin\Resources\EventNotifResource\Pages;

use App\Filament\Admin\Resources\EventNotifResource;
use Filament\Resources\Pages\CreateRecord;
use Filament\Notifications\Notification;

class CreateEventNotif extends CreateRecord
{
    protected static string $resource = EventNotifResource::class;
    
    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
    
    protected function getCreatedNotification(): ?Notification
    {
        return Notification::make()
            ->success()
            ->title('Event Notification Berhasil Dibuat')
            ->body('Event notification telah dibuat. Aktifkan untuk menampilkannya di homepage.');
    }
    
    public function getTitle(): string
    {
        return 'Buat Event Notification';
    }
    
    public function getHeading(): string
    {
        return 'Buat Event Notification Baru';
    }
    
    public function getSubheading(): ?string
    {
        return 'Buat popup event notification yang akan ditampilkan di homepage';
    }
}