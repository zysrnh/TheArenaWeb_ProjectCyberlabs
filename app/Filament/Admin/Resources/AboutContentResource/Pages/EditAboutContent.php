<?php

namespace App\Filament\Admin\Resources\AboutContentResource\Pages;

use App\Filament\Admin\Resources\AboutContentResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;
use Filament\Notifications\Notification;

class EditAboutContent extends EditRecord
{
    protected static string $resource = AboutContentResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }

    // ✅ Redirect setelah update
    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }

    // ✅ Notifikasi sukses
    protected function getSavedNotification(): ?Notification
    {
        return Notification::make()
            ->success()
            ->title('Konten Berhasil Diupdate')
            ->body('Data konten About telah berhasil diperbarui.');
    }

    // ✅ Debug: Log data sebelum disimpan
    protected function mutateFormDataBeforeSave(array $data): array
    {
        \Log::info('Data yang akan disimpan:', $data);
        return $data;
    }

    // ✅ Debug: Log setelah disimpan
    protected function afterSave(): void
    {
        \Log::info('Data berhasil disimpan:', $this->record->toArray());
    }
}