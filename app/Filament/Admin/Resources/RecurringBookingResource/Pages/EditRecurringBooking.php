<?php

namespace App\Filament\Admin\Resources\RecurringBookingResource\Pages;

use App\Filament\Admin\Resources\RecurringBookingResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditRecurringBooking extends EditRecord
{
    protected static string $resource = RecurringBookingResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }

    protected function mutateFormDataBeforeFill(array $data): array
    {
        // Parse customer type dari notes
        if (!empty($data['notes']) && stripos($data['notes'], 'Customer:') !== false) {
            $data['customer_type'] = 'manual';
            
            // Extract customer name dari notes
            if (preg_match('/Customer: (.+?)(\||$)/i', $data['notes'], $matches)) {
                $data['customer_name_manual'] = trim($matches[1]);
            }
            
            // Extract phone number jika ada
            if (preg_match('/Phone: (.+?)(\||$)/i', $data['notes'], $matches)) {
                $data['customer_phone_manual'] = trim($matches[1]);
            }
        } else {
            $data['customer_type'] = 'existing';
        }

        // Convert time_slots array ke selection
        if (!empty($data['time_slots']) && is_array($data['time_slots'])) {
            $data['time_slots_selection'] = array_column($data['time_slots'], 'time');
        }

        // Set dummy recurring data (karena ini edit single booking, bukan batch)
        $data['recurring_month'] = \Carbon\Carbon::parse($data['booking_date'])->format('Y-m');
        $data['recurring_days'] = [\Carbon\Carbon::parse($data['booking_date'])->dayOfWeek];

        return $data;
    }

    protected function mutateFormDataBeforeSave(array $data): array
    {
        // Format time slots
        if (!empty($data['time_slots_selection'])) {
            $priceMap = [
                'cibadak_a' => 350000,
                'cibadak_b' => 300000,
                'pvj' => 350000,
                'urban' => 400000,
            ];

            $price = $priceMap[$data['venue_type']] ?? 350000;

            $data['time_slots'] = array_map(function ($time) use ($price) {
                return [
                    'time' => $time,
                    'duration' => 120,
                    'price' => $price,
                ];
            }, $data['time_slots_selection']);

            $data['total_price'] = count($data['time_slots']) * $price;
        }

        // Update notes dengan customer info
        $notes = $data['notes'] ?? '';
        if ($data['customer_type'] === 'manual') {
            // Remove old customer info dari notes
            $notes = preg_replace('/Customer: .+?(\||$)/i', '', $notes);
            $notes = preg_replace('/Phone: .+?(\||$)/i', '', $notes);
            
            $customerInfo = "Customer: {$data['customer_name_manual']}";
            if (!empty($data['customer_phone_manual'])) {
                $customerInfo .= " | Phone: {$data['customer_phone_manual']}";
            }
            $notes = trim($customerInfo . ($notes ? " | " . $notes : ''));
            
            // Set client_id null untuk manual customer
            $data['client_id'] = null;
        }

        $data['notes'] = $notes;

        // Remove temporary fields
        unset($data['customer_type']);
        unset($data['customer_name_manual']);
        unset($data['customer_phone_manual']);
        unset($data['time_slots_selection']);
        unset($data['recurring_month']);
        unset($data['recurring_days']);
        unset($data['preview_dates']);
        unset($data['total_bookings']);

        return $data;
    }
}