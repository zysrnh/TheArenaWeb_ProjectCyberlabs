<?php

namespace App\Filament\Admin\Resources\RecurringBookingResource\Pages;

use App\Filament\Admin\Resources\RecurringBookingResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;
use Filament\Resources\Components\Tab;
use Illuminate\Database\Eloquent\Builder;
use Carbon\Carbon;

class ListRecurringBookings extends ListRecords
{
    protected static string $resource = RecurringBookingResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make()
                ->label('Buat Booking Rutin')
                ->icon('heroicon-o-plus-circle'),
        ];
    }

    public function getTabs(): array
    {
        $currentMonth = Carbon::now();
        $nextMonth = Carbon::now()->addMonth();
        $prevMonth = Carbon::now()->subMonth();

        return [
            'all' => Tab::make('Semua Booking')
                ->icon('heroicon-o-calendar-days'),
            
            'this_month' => Tab::make('Bulan Ini (' . $currentMonth->format('F') . ')')
                ->modifyQueryUsing(function (Builder $query) use ($currentMonth) {
                    return $query
                        ->whereYear('booking_date', $currentMonth->year)
                        ->whereMonth('booking_date', $currentMonth->month);
                })
                ->badge(function () use ($currentMonth) {
                    return static::getModel()::query()
                        ->whereYear('booking_date', $currentMonth->year)
                        ->whereMonth('booking_date', $currentMonth->month)
                        ->where(function ($q) {
                            $q->whereNotNull('notes')
                              ->where(function ($q2) {
                                  $q2->where('notes', 'like', '%rutin%')
                                     ->orWhere('notes', 'like', '%recurring%')
                                     ->orWhere('notes', 'like', '%bulanan%');
                              });
                        })
                        ->count();
                })
                ->icon('heroicon-o-calendar'),
            
            'next_month' => Tab::make('Bulan Depan (' . $nextMonth->format('F') . ')')
                ->modifyQueryUsing(function (Builder $query) use ($nextMonth) {
                    return $query
                        ->whereYear('booking_date', $nextMonth->year)
                        ->whereMonth('booking_date', $nextMonth->month);
                })
                ->badge(function () use ($nextMonth) {
                    return static::getModel()::query()
                        ->whereYear('booking_date', $nextMonth->year)
                        ->whereMonth('booking_date', $nextMonth->month)
                        ->where(function ($q) {
                            $q->whereNotNull('notes')
                              ->where(function ($q2) {
                                  $q2->where('notes', 'like', '%rutin%')
                                     ->orWhere('notes', 'like', '%recurring%')
                                     ->orWhere('notes', 'like', '%bulanan%');
                              });
                        })
                        ->count();
                })
                ->icon('heroicon-o-arrow-right-circle'),
            
            'prev_month' => Tab::make('Bulan Lalu (' . $prevMonth->format('F') . ')')
                ->modifyQueryUsing(function (Builder $query) use ($prevMonth) {
                    return $query
                        ->whereYear('booking_date', $prevMonth->year)
                        ->whereMonth('booking_date', $prevMonth->month);
                })
                ->icon('heroicon-o-arrow-left-circle'),
            
            'pending' => Tab::make('Pending Payment')
                ->modifyQueryUsing(fn (Builder $query) => $query
                    ->where('status', 'pending')
                )
                ->badge(fn () => static::getModel()::query()
                    ->where('status', 'pending')
                    ->where(function ($q) {
                        $q->whereNotNull('notes')
                          ->where(function ($q2) {
                              $q2->where('notes', 'like', '%rutin%')
                                 ->orWhere('notes', 'like', '%recurring%')
                                 ->orWhere('notes', 'like', '%bulanan%');
                          });
                    })
                    ->count()
                )
                ->badgeColor('warning')
                ->icon('heroicon-o-clock'),
        ];
    }
}