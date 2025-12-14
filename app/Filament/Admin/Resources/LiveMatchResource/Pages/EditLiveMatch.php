<?php

namespace App\Filament\Admin\Resources\LiveMatchResource\Pages;

use App\Filament\Admin\Resources\LiveMatchResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditLiveMatch extends EditRecord
{
    protected static string $resource = LiveMatchResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
    
    // Redirect ke list setelah update
    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
    
    // Optimasi: Custom notification
    protected function getSavedNotificationTitle(): ?string
    {
        return 'Live Match berhasil diperbarui';
    }
    
    // Optimasi: Mutate data sebelum save
    protected function mutateFormDataBeforeSave(array $data): array
    {
        // Format waktu dengan WIB
        if (isset($data['time']) && !str_contains($data['time'], 'WIB')) {
            $data['time'] = $data['time'] . ' WIB';
        }
        
        return $data;
    }
    
    // Mutate data saat load form untuk edit
    protected function mutateFormDataBeforeFill(array $data): array
    {
        // Hilangkan ' WIB' dari time agar bisa di-edit dengan TimePicker
        if (isset($data['time'])) {
            $data['time'] = str_replace(' WIB', '', $data['time']);
        }
        
        return $data;
    }
}