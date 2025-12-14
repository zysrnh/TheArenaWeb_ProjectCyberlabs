<?php

namespace App\Filament\Admin\Widgets;

use App\Models\Client;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget as BaseWidget;

class LatestUsersWidget extends BaseWidget
{
    protected static ?int $sort = 2;
    
    protected int | string | array $columnSpan = 'full';
    
    protected static ?string $heading = 'Latest Added Users';

    public function table(Table $table): Table
    {
        return $table
            ->query(
                Client::query()
                    ->latest()
                    ->limit(5)
            )
            ->columns([
                Tables\Columns\TextColumn::make('email')
                    ->label('Email')
                    ->sortable()
                    ->icon('heroicon-m-envelope'),
                
                Tables\Columns\TextColumn::make('name')
                    ->label('Name')
                    ->sortable()
                    ->badge()
                    ->color('warning'),
                
                Tables\Columns\TextColumn::make('created_at')
                    ->label('Registered At')
                    ->dateTime('d M Y, H:i')
                    ->sortable()
                    ->icon('heroicon-m-calendar'),
            ])
            ->paginated(false)
            ->searchable(false); // Sembunyikan search bar
    }
}