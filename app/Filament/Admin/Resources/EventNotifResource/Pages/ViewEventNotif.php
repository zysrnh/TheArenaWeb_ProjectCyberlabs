<?php

namespace App\Filament\Admin\Resources\EventNotifResource\Pages;

use App\Filament\Admin\Resources\EventNotifResource;
use Filament\Actions;
use Filament\Resources\Pages\ViewRecord;
use Filament\Infolists\Infolist;
use Filament\Infolists\Components\Section;
use Filament\Infolists\Components\TextEntry;
use Filament\Infolists\Components\ImageEntry;
use Filament\Infolists\Components\IconEntry;

class ViewEventNotif extends ViewRecord
{
    protected static string $resource = EventNotifResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\EditAction::make()
                ->label('Edit')
                ->color('warning'),
            
            Actions\DeleteAction::make()
                ->modalHeading('Hapus Event Notification')
                ->modalDescription('Apakah Anda yakin ingin menghapus event notification ini? Tindakan ini tidak dapat dibatalkan.')
                ->successNotificationTitle('Event notification berhasil dihapus'),
        ];
    }
    
    public function infolist(Infolist $infolist): Infolist
    {
        return $infolist
            ->schema([
                Section::make('Informasi Event')
                    ->schema([
                        ImageEntry::make('image')
                            ->label('Banner Event')
                            ->defaultImageUrl(url('/images/default-event.png'))
                            ->columnSpanFull(),
                        
                        TextEntry::make('title')
                            ->label('Judul Event')
                            ->size('lg')
                            ->weight('bold')
                            ->columnSpanFull(),
                        
                        TextEntry::make('description')
                            ->label('Deskripsi')
                            ->columnSpanFull(),
                    ])
                    ->columns(2),
                
                Section::make('Jadwal & Lokasi')
                    ->schema([
                        TextEntry::make('formatted_date')
                            ->label('Tanggal Event')
                            ->badge()
                            ->color('warning'),
                        
                        TextEntry::make('formatted_time')
                            ->label('Waktu Event')
                            ->badge()
                            ->color('info')
                            ->placeholder('Tidak diatur'),
                        
                        TextEntry::make('location')
                            ->label('Lokasi')
                            ->icon('heroicon-o-map-pin')
                            ->placeholder('Tidak diatur')
                            ->columnSpanFull(),
                    ])
                    ->columns(2),
                
                Section::make('Harga & Paket')
                    ->schema([
                        TextEntry::make('formatted_monthly_original_price')
                            ->label('Harga Asli Bulanan')
                            ->prefix('Rp ')
                            ->placeholder('-'),
                        
                        TextEntry::make('formatted_monthly_price')
                            ->label('Harga Bulanan (Diskon)')
                            ->prefix('Rp ')
                            ->badge()
                            ->color('success')
                            ->placeholder('-'),
                        
                        TextEntry::make('monthly_discount_percent')
                            ->label('Diskon')
                            ->suffix('%')
                            ->badge()
                            ->color('danger')
                            ->placeholder('-'),
                        
                        TextEntry::make('formatted_weekly_price')
                            ->label('Harga Mingguan')
                            ->prefix('Rp ')
                            ->badge()
                            ->color('info')
                            ->placeholder('-'),
                    ])
                    ->columns(2)
                    ->visible(fn ($record) => $record->monthly_price || $record->weekly_price),
                
                Section::make('WhatsApp Integration')
                    ->schema([
                        TextEntry::make('whatsapp_number')
                            ->label('Nomor WhatsApp')
                            ->icon('heroicon-o-phone')
                            ->copyable()
                            ->copyMessage('Nomor disalin!')
                            ->prefix('+62 '),
                        
                        TextEntry::make('whatsapp_message')
                            ->label('Template Pesan')
                            ->columnSpanFull()
                            ->placeholder('Menggunakan template default'),
                        
                        TextEntry::make('whatsapp_url')
                            ->label('WhatsApp Link')
                            ->url(fn ($record) => $record->whatsapp_url, true)
                            ->color('success')
                            ->icon('heroicon-o-link')
                            ->columnSpanFull(),
                    ])
                    ->columns(2),
                
                Section::make('Status & Metadata')
                    ->schema([
                        IconEntry::make('is_active')
                            ->label('Status')
                            ->boolean()
                            ->trueIcon('heroicon-o-check-circle')
                            ->falseIcon('heroicon-o-x-circle')
                            ->trueColor('success')
                            ->falseColor('danger'),
                        
                        TextEntry::make('created_at')
                            ->label('Dibuat')
                            ->dateTime('d M Y H:i'),
                        
                        TextEntry::make('updated_at')
                            ->label('Diperbarui')
                            ->dateTime('d M Y H:i')
                            ->since(),
                    ])
                    ->columns(3),
            ]);
    }
    
    public function getTitle(): string
    {
        return 'Lihat Event Notification';
    }
    
    public function getHeading(): string
    {
        return $this->record->title;
    }
    
    public function getSubheading(): ?string
    {
        return 'Detail event notification';
    }
}