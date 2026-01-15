<?php

namespace App\Filament\Admin\Resources\EventNotifResource\Pages;

use App\Filament\Admin\Resources\EventNotifResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListEventNotifs extends ListRecords
{
    protected static string $resource = EventNotifResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make()
                ->label('Buat Event Notification')
                ->icon('heroicon-o-plus')
                ->color('primary'),
        ];
    }
    
    public function getTitle(): string
    {
        return 'Event Notifications';
    }
    
    public function getHeading(): string
    {
        return 'Event Notifications';
    }
    
    public function getSubheading(): ?string
    {
        return 'Kelola popup event notification yang muncul di homepage';
    }
}