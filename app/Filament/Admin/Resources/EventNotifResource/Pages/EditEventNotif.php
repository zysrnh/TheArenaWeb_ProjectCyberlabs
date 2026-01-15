<?php

namespace App\Filament\Admin\Resources\EventNotifResource\Pages;

use App\Filament\Admin\Resources\EventNotifResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;
use Filament\Notifications\Notification;

class EditEventNotif extends EditRecord
{
    protected static string $resource = EventNotifResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\ViewAction::make()
                ->label('Lihat')
                ->color('info'),
            
            Actions\DeleteAction::make()
                ->modalHeading('Hapus Event Notification')
                ->modalDescription('Apakah Anda yakin ingin menghapus event notification ini? Tindakan ini tidak dapat dibatalkan.')
                ->successNotificationTitle('Event notification berhasil dihapus'),
        ];
    }
    
    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
    
    protected function getSavedNotification(): ?Notification
    {
        return Notification::make()
            ->success()
            ->title('Event Notification Berhasil Diperbarui')
            ->body('Perubahan telah disimpan.');
    }
    
    public function getTitle(): string
    {
        return 'Edit Event Notification';
    }
    
    public function getHeading(): string
    {
        return 'Edit Event Notification';
    }
    
    public function getSubheading(): ?string
    {
        return 'Perbarui informasi event notification';
    }
}