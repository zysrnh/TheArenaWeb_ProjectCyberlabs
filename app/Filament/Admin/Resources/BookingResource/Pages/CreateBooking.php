<?php

namespace App\Filament\Admin\Resources\BookingResource\Pages;

use App\Filament\Admin\Resources\BookingResource;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Database\Eloquent\Model;
use App\Models\BookedTimeSlot;

class CreateBooking extends CreateRecord
{
    protected static string $resource = BookingResource::class;

    protected function afterCreate(): void
    {
        // Setelah booking dibuat, simpan booked time slots
        $booking = $this->record;
        
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