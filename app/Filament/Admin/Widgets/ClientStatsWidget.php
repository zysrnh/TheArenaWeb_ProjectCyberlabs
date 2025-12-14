<?php

namespace App\Filament\Admin\Widgets;

use App\Models\Client;
use App\Models\User;
use App\Models\News;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class ClientStatsWidget extends BaseWidget
{
    protected static ?int $sort = 1;
    
    protected function getStats(): array
    {
        return [
            // Total Users/Clients
            Stat::make('Total Users', Client::count())
                ->description('Registered users')
                ->descriptionIcon('heroicon-m-users')
                ->color('success')
                ->chart($this->getUsersChart()),

            // Total Admins
            Stat::make('Total Admins', User::count())
                ->description('Admin accounts')
                ->descriptionIcon('heroicon-m-shield-check')
                ->color('warning')
                ->chart($this->getAdminsChart()),

            // Total News
            Stat::make('Total News', News::count())
                ->description(News::published()->count() . ' published')
                ->descriptionIcon('heroicon-m-newspaper')
                ->color('info')
                ->chart($this->getNewsChart()),
        ];
    }

    /**
     * Chart data users: 7 hari terakhir
     */
    private function getUsersChart(): array
    {
        $data = [];
        for ($i = 6; $i >= 0; $i--) {
            $date = now()->subDays($i)->toDateString();
            $data[] = Client::whereDate('created_at', $date)->count();
        }
        return $data;
    }

    /**
     * Chart data admins: 7 hari terakhir
     */
    private function getAdminsChart(): array
    {
        $data = [];
        for ($i = 6; $i >= 0; $i--) {
            $date = now()->subDays($i)->toDateString();
            $data[] = User::whereDate('created_at', $date)->count();
        }
        return $data;
    }

    /**
     * Chart data news: 7 hari terakhir
     */
    private function getNewsChart(): array
    {
        $data = [];
        for ($i = 6; $i >= 0; $i--) {
            $date = now()->subDays($i)->toDateString();
            $data[] = News::whereDate('created_at', $date)->count();
        }
        return $data;
    }
}