<?php

namespace App\Filament\Admin\Resources\RecurringBookingResource\Pages;

use App\Filament\Admin\Resources\RecurringBookingResource;
use App\Models\Booking;
use App\Models\BookedTimeSlot;
use Filament\Resources\Pages\CreateRecord;
use Filament\Notifications\Notification;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class CreateRecurringBooking extends CreateRecord
{
    protected static string $resource = RecurringBookingResource::class;

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        // Jangan create di sini, kita override handleRecordCreation
        return $data;
    }

    protected function handleRecordCreation(array $data): \Illuminate\Database\Eloquent\Model
    {
        DB::beginTransaction();
        
        try {
            // 1. Hitung semua tanggal recurring
            $recurringDates = $this->calculateRecurringDates(
                $data['recurring_month'],
                $data['recurring_days']
            );

            // 2. Validasi konflik slot
            $conflicts = $this->checkConflicts(
                $recurringDates,
                $data['venue_type'],
                $data['time_slots_selection']
            );

            if (!empty($conflicts)) {
                DB::rollBack();
                
                Notification::make()
                    ->title('Ada Konflik Booking!')
                    ->danger()
                    ->body('Tanggal berikut sudah dibooking: ' . implode(', ', array_map(function($date) {
                        return Carbon::parse($date)->format('d M');
                    }, $conflicts)))
                    ->persistent()
                    ->send();
                
                $this->halt();
                
                // This line will never be reached due to halt(), but satisfies IDE
                throw new \RuntimeException('Booking conflict detected');
            }

            // 3. Format time slots
            $timeSlots = $this->formatTimeSlots($data['time_slots_selection'], $data['venue_type']);
            $totalPrice = array_sum(array_column($timeSlots, 'price'));

            // 4. Tentukan client_id
            $clientId = $data['customer_type'] === 'existing' ? $data['client_id'] : null;

            // 5. Buat notes dengan info customer manual
            $notes = $data['notes'] ?? '';
            if ($data['customer_type'] === 'manual') {
                $customerInfo = "Customer: {$data['customer_name_manual']}";
                if (!empty($data['customer_phone_manual'])) {
                    $customerInfo .= " | Phone: {$data['customer_phone_manual']}";
                }
                $notes = $customerInfo . ($notes ? " | " . $notes : '');
            }
            $notes .= " | Booking Rutin Bulanan | Generated: " . Carbon::now()->format('d M Y H:i');

            // 6. Create bookings untuk setiap tanggal
            $createdCount = 0;
            $firstBooking = null;

            foreach ($recurringDates as $date) {
                $booking = Booking::create([
                    'client_id' => $clientId,
                    'venue_id' => $this->getVenueId($data['venue_type']),
                    'booking_date' => $date,
                    'venue_type' => $data['venue_type'],
                    'time_slots' => $timeSlots,
                    'total_price' => $totalPrice,
                    'status' => $data['status'] ?? 'confirmed',
                    'payment_status' => $data['payment_status'] ?? 'paid',
                    'is_paid' => $data['is_paid'] ?? true,
                    'notes' => $notes,
                ]);

                // Create booked time slots
                foreach ($timeSlots as $slot) {
                    BookedTimeSlot::create([
                        'booking_id' => $booking->id,
                        'date' => $date,
                        'time_slot' => $slot['time'],
                        'venue_type' => $data['venue_type'],
                    ]);
                }

                if (!$firstBooking) {
                    $firstBooking = $booking;
                }
                
                $createdCount++;
            }

            DB::commit();

            Notification::make()
                ->title('Booking Rutin Berhasil!')
                ->success()
                ->body("Berhasil membuat {$createdCount} booking untuk periode " . 
                       Carbon::parse($data['recurring_month'])->format('F Y'))
                ->send();

            return $firstBooking;

        } catch (\Exception $e) {
            DB::rollBack();
            
            Log::error('Failed to create recurring booking', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            
            Notification::make()
                ->title('Gagal Membuat Booking')
                ->danger()
                ->body('Error: ' . $e->getMessage())
                ->persistent()
                ->send();
            
            $this->halt();
            
            // This line will never be reached due to halt(), but satisfies IDE
            throw $e;
        }
    }

    /**
     * Hitung tanggal recurring berdasarkan bulan dan hari
     */
    protected function calculateRecurringDates(string $month, array $days): array
    {
        $dates = [];
        $startDate = Carbon::parse($month . '-01');
        $endDate = $startDate->copy()->endOfMonth();
        
        $current = $startDate->copy();
        while ($current <= $endDate) {
            if (in_array((string)$current->dayOfWeek, $days, true)) {
                // Skip tanggal yang sudah lewat
                if ($current->gte(Carbon::today())) {
                    $dates[] = $current->format('Y-m-d');
                }
            }
            $current->addDay();
        }
        
        return $dates;
    }

    /**
     * Cek konflik dengan booking existing
     */
    protected function checkConflicts(array $dates, string $venueType, array $timeSlots): array
    {
        $conflicts = [];

        foreach ($dates as $date) {
            $hasConflict = BookedTimeSlot::where('date', $date)
                ->where('venue_type', $venueType)
                ->whereIn('time_slot', $timeSlots)
                ->whereHas('booking', function ($query) {
                    $query->whereIn('status', ['pending', 'confirmed'])
                          ->whereIn('payment_status', ['pending', 'paid']);
                })
                ->exists();

            if ($hasConflict) {
                $conflicts[] = $date;
            }
        }

        return $conflicts;
    }

    /**
     * Format time slots dengan harga
     */
    protected function formatTimeSlots(array $selectedSlots, string $venueType): array
    {
        $priceMap = [
            'cibadak_a' => 350000,
            'cibadak_b' => 300000,
            'pvj' => 350000,
            'urban' => 400000,
        ];

        $price = $priceMap[$venueType] ?? 350000;

        return array_map(function ($time) use ($price) {
            return [
                'time' => $time,
                'duration' => 120,
                'price' => $price,
            ];
        }, $selectedSlots);
    }

    /**
     * Get venue ID (sesuaikan dengan data venue Anda)
     */
    protected function getVenueId(string $venueType): int
    {
        $venueMap = [
            'cibadak_a' => 1,
            'cibadak_b' => 2,
            'pvj' => 3,
            'urban' => 4,
        ];

        return $venueMap[$venueType] ?? 1;
    }
}