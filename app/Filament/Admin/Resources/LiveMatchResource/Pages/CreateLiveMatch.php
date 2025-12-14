<?php

namespace App\Filament\Admin\Resources\LiveMatchResource\Pages;

use App\Filament\Admin\Resources\LiveMatchResource;
use Filament\Resources\Pages\CreateRecord;

class CreateLiveMatch extends CreateRecord
{
    protected static string $resource = LiveMatchResource::class;
    
    // Redirect ke list setelah create
    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
    
    // Optimasi: Disable notifications yang tidak perlu
    protected function getCreatedNotificationTitle(): ?string
    {
        return 'Live Match berhasil ditambahkan';
    }
    
    // Optimasi: Mutate data sebelum create untuk performa lebih baik
    protected function mutateFormDataBeforeCreate(array $data): array
    {
        // Set default values jika kosong untuk menghindari validasi berulang
        $data['is_active'] = $data['is_active'] ?? true;
        $data['status'] = $data['status'] ?? 'scheduled';
        $data['series'] = $data['series'] ?? 'regular';
        
        // Format waktu dengan WIB
        if (isset($data['time'])) {
            $data['time'] = $data['time'] . ' WIB';
        }
        
        return $data;
    }
}