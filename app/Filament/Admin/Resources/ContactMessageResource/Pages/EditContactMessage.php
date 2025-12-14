<?php

namespace App\Filament\Admin\Resources\ContactMessageResource\Pages;

use App\Filament\Admin\Resources\ContactMessageResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;
use Filament\Notifications\Notification;

class EditContactMessage extends EditRecord
{
    protected static string $resource = ContactMessageResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\ViewAction::make(),
            Actions\DeleteAction::make(),
        ];
    }

    protected function beforeSave(): void
    {
        // Auto-update status when admin reply is filled
        if ($this->record->isDirty('admin_reply') && !empty($this->data['admin_reply'])) {
            $this->data['status'] = 'replied';
            $this->data['replied_at'] = now();
        }
    }

    protected function getSavedNotification(): ?Notification
    {
        return Notification::make()
            ->success()
            ->title('Pesan berhasil diupdate')
            ->body('Status dan balasan pesan telah disimpan.');
    }
}