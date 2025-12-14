<?php

namespace App\Filament\Admin\Widgets;

use App\Models\Booking;
use Filament\Widgets\ChartWidget;

class BookingStatusChart extends ChartWidget
{
    protected static ?string $heading = 'Booking Status Distribution';
    protected static ?int $sort = 4;
    protected int | string | array $columnSpan = [
        'md' => 1,
        'xl' => 1,
    ];

    protected function getData(): array
    {
        $paid = Booking::where('payment_status', 'paid')->count();
        $pending = Booking::where('payment_status', 'pending')->count();
        $failed = Booking::where('payment_status', 'failed')->count();
        $expired = Booking::where('payment_status', 'expired')->count();

        return [
            'datasets' => [
                [
                    'label' => 'Bookings',
                    'data' => [$paid, $pending, $failed, $expired],
                    'backgroundColor' => [
                        'rgba(34, 197, 94, 0.8)',   // Green - Paid
                        'rgba(251, 191, 36, 0.8)',  // Yellow - Pending
                        'rgba(239, 68, 68, 0.8)',   // Red - Failed
                        'rgba(156, 163, 175, 0.8)', // Gray - Expired
                    ],
                    'borderColor' => [
                        'rgb(34, 197, 94)',
                        'rgb(251, 191, 36)',
                        'rgb(239, 68, 68)',
                        'rgb(156, 163, 175)',
                    ],
                    'borderWidth' => 2,
                ],
            ],
            'labels' => ['Paid', 'Pending', 'Failed', 'Expired'],
        ];
    }

    protected function getType(): string
    {
        return 'doughnut';
    }

    protected function getOptions(): array
    {
        return [
            'plugins' => [
                'legend' => [
                    'display' => true,
                    'position' => 'bottom',
                ],
            ],
        ];
    }
}