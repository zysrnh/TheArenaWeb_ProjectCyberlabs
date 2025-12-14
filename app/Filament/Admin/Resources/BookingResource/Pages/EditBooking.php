<?php

namespace App\Filament\Admin\Resources\BookingResource\Pages;

use App\Filament\Admin\Resources\BookingResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;
use App\Models\BookedTimeSlot;

class EditBooking extends EditRecord
{
    protected static string $resource = BookingResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\ViewAction::make(),
            Actions\DeleteAction::make(),
        ];
    }

    protected function afterSave(): void
    {
        // Update booked time slots setelah edit
        $booking = $this->record;
        
        // Hapus semua booked time slots yang lama
        BookedTimeSlot::where('booking_id', $booking->id)->delete();
        
        // Buat yang baru
        if ($booking->time_slots && is_array($booking->time_slots)) {
            foreach ($booking->time_slots as $slot) {
                BookedTimeSlot::create([
                    'booking_id' => $booking->id,
                    'date' => $booking->booking_date,
                    'time_slot' => $slot['time'],
                    'venue_type' => $booking->venue_type,
                ]);
            }
        }
    }
}