<?php

namespace App\Filament\Admin\Resources\EquipmentResource\Pages;

use App\Filament\Admin\Resources\EquipmentResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditEquipment extends EditRecord
{
    protected static string $resource = EquipmentResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make()
                ->label('Hapus')
                ->requiresConfirmation(),
        ];
    }

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }

    protected function getSavedNotificationTitle(): ?string
    {
        return 'Peralatan berhasil diperbarui';
    }

    public function getTitle(): string
    {
        return 'Edit Peralatan';
    }
}