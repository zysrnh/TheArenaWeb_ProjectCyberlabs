<?php

namespace App\Filament\Admin\Widgets;

use App\Models\Booking;
use App\Models\ContactMessage;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class BookingStatsWidget extends BaseWidget
{
    protected static ?int $sort = 3;

    protected function getStats(): array
    {
        // Data bookings
        $totalBookings = Booking::count();
        $paidBookings = Booking::where('payment_status', 'paid')->count();
        $totalRevenue = Booking::where('payment_status', 'paid')->sum('total_price');
        $pendingPayments = Booking::where('payment_status', 'pending')->count();

        // Data revenue bulan ini dan bulan lalu
        $currentMonthRevenue = Booking::whereYear('created_at', now()->year)
            ->whereMonth('created_at', now()->month)
            ->where('payment_status', 'paid')
            ->sum('total_price');

        $lastMonthRevenue = Booking::whereYear('created_at', now()->subMonth()->year)
            ->whereMonth('created_at', now()->subMonth()->month)
            ->where('payment_status', 'paid')
            ->sum('total_price');

        // Hitung persentase perubahan
        if ($lastMonthRevenue > 0) {
            $revenueChange = (($currentMonthRevenue - $lastMonthRevenue) / $lastMonthRevenue) * 100;
        } else {
            $revenueChange = $currentMonthRevenue > 0 ? 100 : 0;
        }

        // Data revenue hari ini
        $todayRevenue = Booking::whereDate('created_at', now()->toDateString())
            ->where('payment_status', 'paid')
            ->sum('total_price');

        $todayBookings = Booking::whereDate('created_at', now()->toDateString())->count();

        // Data messages
        $totalMessages = ContactMessage::count();

        return [
            // Total Bookings
            Stat::make('Total Bookings', $totalBookings)
                ->description($paidBookings . ' paid bookings')
                ->descriptionIcon('heroicon-m-calendar')
                ->color('success')
                ->chart($this->getBookingsChart()),

            // Total Revenue
            Stat::make('Total Revenue', 'Rp ' . number_format($totalRevenue, 0, ',', '.'))
                ->description('From paid bookings')
                ->descriptionIcon('heroicon-m-banknotes')
                ->color('success')
                ->chart($this->getRevenueChart()),

            // Pending Payments
            Stat::make('Pending Payments', $pendingPayments)
                ->description('Awaiting payment')
                ->descriptionIcon('heroicon-m-clock')
                ->color('warning')
                ->chart($this->getPendingPaymentsChart()),

            // Revenue Today
            Stat::make('Revenue Today', 'Rp ' . number_format($todayRevenue, 0, ',', '.'))
                ->description($todayBookings . ' bookings today')
                ->descriptionIcon('heroicon-m-information-circle')
                ->color('info')
                ->chart($this->getTodayRevenueChart()),

            // Revenue This Month
            Stat::make('Revenue This Month', 'Rp ' . number_format($currentMonthRevenue, 0, ',', '.'))
                ->description(number_format($revenueChange, 1) . '% from last month')
                ->descriptionIcon($revenueChange >= 0 ? 'heroicon-m-arrow-trending-up' : 'heroicon-m-arrow-trending-down')
                ->color($revenueChange >= 0 ? 'success' : 'danger')
                ->chart($this->getMonthlyRevenueChart()),

            // Total Messages
            Stat::make('Total Messages', $totalMessages)
                ->description('All contact messages')
                ->descriptionIcon('heroicon-m-envelope')
                ->color('info')
                ->chart($this->getTotalMessagesChart()),
        ];
    }

    /**
     * Chart data bookings: 7 hari terakhir
     */
    private function getBookingsChart(): array
    {
        $data = [];
        for ($i = 6; $i >= 0; $i--) {
            $date = now()->subDays($i)->toDateString();
            $data[] = Booking::whereDate('created_at', $date)->count();
        }
        return $data;
    }

    /**
     * Chart data revenue: 7 hari terakhir
     */
    private function getRevenueChart(): array
    {
        $data = [];
        for ($i = 6; $i >= 0; $i--) {
            $date = now()->subDays($i)->toDateString();
            $data[] = Booking::whereDate('created_at', $date)
                ->where('payment_status', 'paid')
                ->sum('total_price');
        }
        return $data;
    }

    /**
     * Chart data pending payments: 7 hari terakhir
     */
    private function getPendingPaymentsChart(): array
    {
        $data = [];
        for ($i = 6; $i >= 0; $i--) {
            $date = now()->subDays($i)->toDateString();
            $data[] = Booking::whereDate('created_at', $date)
                ->where('payment_status', 'pending')
                ->count();
        }
        return $data;
    }

    /**
     * Chart data revenue hari ini per jam: 24 jam terakhir
     */
    private function getTodayRevenueChart(): array
    {
        $data = [];
        for ($i = 6; $i >= 0; $i--) {
            $date = now()->subDays($i)->toDateString();
            $revenue = Booking::whereDate('created_at', $date)
                ->where('payment_status', 'paid')
                ->sum('total_price');
            $data[] = $revenue;
        }
        return $data;
    }

    /**
     * Chart data revenue bulanan: 6 bulan terakhir
     */
    private function getMonthlyRevenueChart(): array
    {
        $data = [];
        for ($i = 5; $i >= 0; $i--) {
            $date = now()->subMonths($i);
            $revenue = Booking::whereYear('created_at', $date->year)
                ->whereMonth('created_at', $date->month)
                ->where('payment_status', 'paid')
                ->sum('total_price');
            $data[] = $revenue;
        }
        return $data;
    }

    /**
     * Chart data total messages: 7 hari terakhir
     */
    private function getTotalMessagesChart(): array
    {
        $data = [];
        for ($i = 6; $i >= 0; $i--) {
            $date = now()->subDays($i)->toDateString();
            $data[] = ContactMessage::whereDate('created_at', $date)->count();
        }
        return $data;
    }
}