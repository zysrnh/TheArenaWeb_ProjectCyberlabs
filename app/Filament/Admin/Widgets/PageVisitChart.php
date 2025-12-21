<?php

namespace App\Filament\Admin\Widgets;

use App\Models\PageVisit;
use Filament\Widgets\ChartWidget;

class PageVisitChart extends ChartWidget
{
    protected static ?string $heading = 'Trend Pengunjung';
    
    protected static ?int $sort = 8;
    
    protected static string $color = 'info';
    
    protected int | string | array $columnSpan = 'full';
    
    protected static ?string $maxHeight = '300px';
    
    // Filter property
    public ?string $filter = 'month';

    protected function getData(): array
    {
        $visits = $this->getFilteredVisits();
        
        $labels = $visits->map(fn($item) => $item->visit_date->format('d M'))->toArray();
        $data = $visits->pluck('total_visits')->toArray();
        
        return [
            'datasets' => [
                [
                    'label' => 'Pengunjung',
                    'data' => $data,
                    'fill' => 'start',
                    'backgroundColor' => 'rgba(59, 130, 246, 0.1)',
                    'borderColor' => 'rgb(59, 130, 246)',
                    'tension' => 0.4,
                    'pointBackgroundColor' => 'rgb(59, 130, 246)',
                    'pointBorderColor' => '#fff',
                    'pointBorderWidth' => 2,
                    'pointRadius' => 4,
                    'pointHoverRadius' => 6,
                ],
            ],
            'labels' => $labels,
        ];
    }
    
    protected function getFilteredVisits()
    {
        return match ($this->filter) {
            'today' => PageVisit::whereDate('visit_date', today())
                ->orderBy('visit_date', 'asc')
                ->get(),
            
            'week' => PageVisit::whereBetween('visit_date', [
                    now()->startOfWeek(),
                    now()->endOfWeek()
                ])
                ->orderBy('visit_date', 'asc')
                ->get(),
            
            'month' => PageVisit::whereMonth('visit_date', now()->month)
                ->whereYear('visit_date', now()->year)
                ->orderBy('visit_date', 'asc')
                ->get(),
            
            'year' => PageVisit::whereYear('visit_date', now()->year)
                ->orderBy('visit_date', 'asc')
                ->get(),
            
            'last30' => PageVisit::where('visit_date', '>=', now()->subDays(29))
                ->orderBy('visit_date', 'asc')
                ->get(),
            
            'last90' => PageVisit::where('visit_date', '>=', now()->subDays(89))
                ->orderBy('visit_date', 'asc')
                ->get(),
            
            default => PageVisit::where('visit_date', '>=', now()->subDays(29))
                ->orderBy('visit_date', 'asc')
                ->get(),
        };
    }
    
    protected function getFilters(): ?array
    {
        return [
            'today' => 'Hari Ini',
            'week' => 'Minggu Ini',
            'month' => 'Bulan Ini',
            'year' => 'Tahun Ini',
            'last30' => '30 Hari Terakhir',
            'last90' => '90 Hari Terakhir',
        ];
    }
    
    protected function getType(): string
    {
        return 'line';
    }
    
    protected function getOptions(): array
    {
        return [
            'plugins' => [
                'legend' => [
                    'display' => true,
                    'position' => 'top',
                    'labels' => [
                        'usePointStyle' => true,
                        'padding' => 15,
                    ],
                ],
                'tooltip' => [
                    'backgroundColor' => 'rgba(0, 0, 0, 0.8)',
                    'padding' => 12,
                    'titleFont' => [
                        'size' => 14,
                    ],
                    'bodyFont' => [
                        'size' => 13,
                    ],
                    'callbacks' => [
                        'label' => 'function(context) {
                            return "Pengunjung: " + context.parsed.y.toLocaleString();
                        }'
                    ],
                ],
            ],
            'scales' => [
                'y' => [
                    'beginAtZero' => true,
                    'ticks' => [
                        'precision' => 0,
                    ],
                    'grid' => [
                        'display' => true,
                        'color' => 'rgba(0, 0, 0, 0.05)',
                    ],
                ],
                'x' => [
                    'grid' => [
                        'display' => false,
                    ],
                    'ticks' => [
                        'maxRotation' => 45,
                        'minRotation' => 0,
                    ],
                ],
            ],
            'interaction' => [
                'mode' => 'index',
                'intersect' => false,
            ],
            'responsive' => true,
            'maintainAspectRatio' => true,
        ];
    }
    
    protected function getPollingInterval(): ?string
    {
        return '60s';
    }
}