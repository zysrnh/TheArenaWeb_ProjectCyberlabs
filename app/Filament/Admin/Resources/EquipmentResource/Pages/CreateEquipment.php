<?php

namespace App\Filament\Admin\Resources\EquipmentResource\Pages;

use App\Filament\Admin\Resources\EquipmentResource;
use Filament\Resources\Pages\CreateRecord;

class CreateEquipment extends CreateRecord
{
    protected static string $resource = EquipmentResource::class;

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }

    protected function getCreatedNotificationTitle(): ?string
    {
        return 'Peralatan berhasil ditambahkan';
    }

    public function getTitle(): string
    {
        return 'Tambah Peralatan Baru';
    }
}