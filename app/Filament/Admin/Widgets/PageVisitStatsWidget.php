<?php

namespace App\Filament\Admin\Widgets;

use App\Models\PageVisit;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class PageVisitStatsWidget extends BaseWidget
{
    protected static ?int $sort = 7;
    
    protected function getStats(): array
    {
        // Today's visits
        $today = PageVisit::whereDate('visit_date', today())->first();
        $todayVisits = $today ? $today->total_visits : 0;
        
        // Yesterday's visits
        $yesterday = PageVisit::whereDate('visit_date', today()->subDay())->first();
        $yesterdayVisits = $yesterday ? $yesterday->total_visits : 0;
        
        // Calculate today's growth
        $todayGrowth = 0;
        if ($yesterdayVisits > 0) {
            $todayGrowth = round((($todayVisits - $yesterdayVisits) / $yesterdayVisits) * 100, 1);
        }
        
        // This week total
        $weekStart = now()->startOfWeek();
        $weekEnd = now()->endOfWeek();
        $weekVisits = PageVisit::whereBetween('visit_date', [$weekStart, $weekEnd])->sum('total_visits');
        
        // This month total
        $monthVisits = PageVisit::whereMonth('visit_date', now()->month)
            ->whereYear('visit_date', now()->year)
            ->sum('total_visits');
        
        // Last month total for comparison
        $lastMonth = PageVisit::whereMonth('visit_date', now()->subMonth()->month)
            ->whereYear('visit_date', now()->subMonth()->year)
            ->sum('total_visits');
        
        $monthGrowth = 0;
        if ($lastMonth > 0) {
            $monthGrowth = round((($monthVisits - $lastMonth) / $lastMonth) * 100, 1);
        }
        
        // All time total
        $allTimeVisits = PageVisit::sum('total_visits');
        
        return [
            Stat::make('Pengunjung Hari Ini', number_format($todayVisits))
                ->description($todayGrowth >= 0 ? "+{$todayGrowth}% dari kemarin" : "{$todayGrowth}% dari kemarin")
                ->descriptionIcon($todayGrowth >= 0 ? 'heroicon-m-arrow-trending-up' : 'heroicon-m-arrow-trending-down')
                ->color($todayGrowth >= 0 ? 'success' : 'danger')
                ->chart($this->getLastSevenDaysChart()),
            
            Stat::make('Pengunjung Minggu Ini', number_format($weekVisits))
                ->description('Total kunjungan minggu ini')
                ->descriptionIcon('heroicon-m-calendar-days')
                ->color('info'),
            
            Stat::make('Pengunjung Bulan Ini', number_format($monthVisits))
                ->description($monthGrowth >= 0 ? "+{$monthGrowth}% dari bulan lalu" : "{$monthGrowth}% dari bulan lalu")
                ->descriptionIcon($monthGrowth >= 0 ? 'heroicon-m-arrow-trending-up' : 'heroicon-m-arrow-trending-down')
                ->color($monthGrowth >= 0 ? 'success' : 'warning'),
            
            Stat::make('Total Pengunjung', number_format($allTimeVisits))
                ->description('Total kunjungan sepanjang masa')
                ->descriptionIcon('heroicon-m-users')
                ->color('primary'),
        ];
    }
    
    protected function getLastSevenDaysChart(): array
    {
        $visits = PageVisit::where('visit_date', '>=', now()->subDays(7))
            ->orderBy('visit_date', 'asc')
            ->pluck('total_visits')
            ->toArray();
        
        return $visits ?: [0, 0, 0, 0, 0, 0, 0];
    }
    
    protected function getPollingInterval(): ?string
    {
        return '30s';
    }
}