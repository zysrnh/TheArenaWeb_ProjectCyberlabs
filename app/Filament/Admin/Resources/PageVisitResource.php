<?php

namespace App\Filament\Admin\Resources;

use App\Filament\Admin\Resources\PageVisitResource\Pages;
use App\Models\PageVisit;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;

class PageVisitResource extends Resource
{
    protected static ?string $model = PageVisit::class;

    protected static ?string $navigationIcon = 'heroicon-o-chart-bar';
    
    protected static ?string $navigationLabel = 'Statistik Pengunjung';
    
    protected static ?string $navigationGroup = 'Analytics';
    
    protected static ?int $navigationSort = 1;

    public static function form(Form $form): Form
    {
        return $form->schema([]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\Layout\Split::make([
                    Tables\Columns\Layout\Stack::make([
                        Tables\Columns\TextColumn::make('visit_date')
                            ->label('Tanggal')
                            ->date('l, d F Y')
                            ->sortable()
                            ->searchable()
                            ->weight('bold')
                            ->size('lg')
                            ->icon('heroicon-m-calendar-days')
                            ->iconColor('primary'),
                            
                        Tables\Columns\TextColumn::make('visit_date')
                            ->label('')
                            ->formatStateUsing(fn ($state) => \Carbon\Carbon::parse($state)->diffForHumans())
                            ->color('gray')
                            ->size('sm'),
                    ])->space(1),
                    
                    Tables\Columns\Layout\Stack::make([
                        Tables\Columns\TextColumn::make('total_visits')
                            ->label('Total Pengunjung')
                            ->numeric()
                            ->sortable()
                            ->badge()
                            ->color(fn ($state): string => match (true) {
                                $state >= 100 => 'success',
                                $state >= 50 => 'warning',
                                default => 'gray',
                            })
                            ->icon('heroicon-m-users')
                            ->size('xl')
                            ->weight('bold'),
                            
                        Tables\Columns\TextColumn::make('growth')
                            ->label('Tren')
                            ->getStateUsing(function (PageVisit $record): string {
                                $previous = PageVisit::where('visit_date', '<', $record->visit_date)
                                    ->orderBy('visit_date', 'desc')
                                    ->first();
                                    
                                if (!$previous) return 'Data pertama';
                                
                                $diff = $record->total_visits - $previous->total_visits;
                                $percentage = $previous->total_visits > 0 
                                    ? round(($diff / $previous->total_visits) * 100, 1) 
                                    : 0;
                                
                                if ($diff > 0) {
                                    return "↗ +{$diff} ({$percentage}%)";
                                } elseif ($diff < 0) {
                                    return "↘ {$diff} ({$percentage}%)";
                                } else {
                                    return "→ Sama";
                                }
                            })
                            ->badge()
                            ->color(function (PageVisit $record): string {
                                $previous = PageVisit::where('visit_date', '<', $record->visit_date)
                                    ->orderBy('visit_date', 'desc')
                                    ->first();
                                    
                                if (!$previous) return 'gray';
                                
                                $diff = $record->total_visits - $previous->total_visits;
                                
                                if ($diff > 0) return 'success';
                                if ($diff < 0) return 'danger';
                                return 'gray';
                            }),
                    ])->space(1)->alignment('end'),
                ])->from('md'),
            ])
            ->contentGrid([
                'md' => 1,
                'xl' => 1,
            ])
            ->defaultSort('visit_date', 'desc')
            ->filters([
                Tables\Filters\SelectFilter::make('period')
                    ->label('Periode')
                    ->options([
                        'today' => '📅 Hari Ini',
                        'yesterday' => '📅 Kemarin',
                        'this_week' => '📅 Minggu Ini',
                        'last_week' => '📅 Minggu Lalu',
                        'this_month' => '📅 Bulan Ini',
                        'last_month' => '📅 Bulan Lalu',
                        'last_30_days' => '📅 30 Hari Terakhir',
                        'last_90_days' => '📅 90 Hari Terakhir',
                    ])
                    ->query(function (Builder $query, array $data) {
                        return match ($data['value'] ?? null) {
                            'today' => $query->whereDate('visit_date', today()),
                            'yesterday' => $query->whereDate('visit_date', today()->subDay()),
                            'this_week' => $query->whereBetween('visit_date', [
                                now()->startOfWeek(),
                                now()->endOfWeek()
                            ]),
                            'last_week' => $query->whereBetween('visit_date', [
                                now()->subWeek()->startOfWeek(),
                                now()->subWeek()->endOfWeek()
                            ]),
                            'this_month' => $query->whereMonth('visit_date', now()->month)
                                ->whereYear('visit_date', now()->year),
                            'last_month' => $query->whereMonth('visit_date', now()->subMonth()->month)
                                ->whereYear('visit_date', now()->subMonth()->year),
                            'last_30_days' => $query->where('visit_date', '>=', now()->subDays(30)),
                            'last_90_days' => $query->where('visit_date', '>=', now()->subDays(90)),
                            default => $query,
                        };
                    }),
                    
                Tables\Filters\Filter::make('high_traffic')
                    ->label('🔥 Traffic Tinggi (≥50)')
                    ->query(fn (Builder $query) => $query->where('total_visits', '>=', 50))
                    ->toggle(),
                    
                Tables\Filters\Filter::make('low_traffic')
                    ->label('📉 Traffic Rendah (<10)')
                    ->query(fn (Builder $query) => $query->where('total_visits', '<', 10))
                    ->toggle(),
            ])
            ->actions([
                Tables\Actions\Action::make('view_details')
                    ->label('Lihat Detail')
                    ->icon('heroicon-o-eye')
                    ->color('info')
                    ->modalHeading(fn (PageVisit $record): string => 'Statistik Pengunjung - ' . $record->visit_date->format('l, d F Y'))
                    ->modalContent(fn (PageVisit $record): \Illuminate\View\View => view(
                        'filament.admin.resources.page-visit.view-modal',
                        ['record' => $record]
                    ))
                    ->modalWidth('4xl')
                    ->slideOver()
                    ->modalSubmitAction(false)
                    ->modalCancelActionLabel('Tutup'),
            ])
            ->bulkActions([])
            ->emptyStateHeading('Belum Ada Data Pengunjung')
            ->emptyStateDescription('Data statistik pengunjung akan muncul di sini setelah ada aktivitas.')
            ->emptyStateIcon('heroicon-o-chart-bar')
            ->poll('30s'); // Auto refresh setiap 30 detik
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListPageVisits::route('/'),
        ];
    }
    
    public static function canCreate(): bool
    {
        return false;
    }
    
    public static function getNavigationBadge(): ?string
    {
        $today = static::getModel()::whereDate('visit_date', today())->first();
        return $today ? (string) $today->total_visits : '0';
    }

    public static function getNavigationBadgeColor(): ?string
    {
        return 'success';
    }
    
    public static function getNavigationBadgeTooltip(): ?string
    {
        return 'Pengunjung hari ini';
    }
}