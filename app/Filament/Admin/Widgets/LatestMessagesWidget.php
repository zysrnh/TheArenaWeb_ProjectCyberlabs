<?php

namespace App\Filament\Admin\Widgets;

use App\Models\ContactMessage;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget as BaseWidget;

class LatestMessagesWidget extends BaseWidget
{
    protected static ?int $sort = 6;
    
    protected int | string | array $columnSpan = 'full';

    public function table(Table $table): Table
    {
        return $table
            ->heading('Latest Contact Messages')
            ->query(
                ContactMessage::query()
                    ->latest()
                    ->limit(10)
            )
            ->columns([
                Tables\Columns\TextColumn::make('nama')
                    ->label('Name')
                    ->sortable()
                    ->weight('bold')
                    ->icon('heroicon-m-user')
                    ->iconColor('primary'),

                Tables\Columns\TextColumn::make('email')
                    ->label('Email')
                    ->sortable()
                    ->icon('heroicon-m-envelope')
                    ->iconColor('info')
                    ->copyable()
                    ->copyMessage('Email copied!')
                    ->copyMessageDuration(1500),

                Tables\Columns\TextColumn::make('subject')
                    ->label('Subject')
                    ->sortable()
                    ->limit(40)
                    ->tooltip(function (ContactMessage $record): string {
                        return $record->subject;
                    }),

                Tables\Columns\TextColumn::make('pesan')
                    ->label('Message')
                    ->limit(50)
                    ->tooltip(function (ContactMessage $record): string {
                        return $record->pesan;
                    })
                    ->wrap(),

                Tables\Columns\TextColumn::make('created_at')
                    ->label('Received At')
                    ->dateTime('d M Y, H:i')
                    ->sortable()
                    ->icon('heroicon-m-clock')
                    ->iconColor('success')
                    ->since()
                    ->tooltip(function (ContactMessage $record): string {
                        return $record->created_at->format('l, d F Y - H:i:s');
                    }),
            ])
            ->actions([
                Tables\Actions\Action::make('view')
                    ->label('View')
                    ->icon('heroicon-m-eye')
                    ->color('info')
                    ->modalHeading(fn (ContactMessage $record) => 'Message from ' . $record->nama)
                    ->modalContent(fn (ContactMessage $record) => view('filament.widgets.message-detail', [
                        'message' => $record
                    ]))
                    ->modalSubmitAction(false)
                    ->modalCancelActionLabel('Close'),
            ])
            ->defaultSort('created_at', 'desc')
            ->striped()
            ->paginated(false);
    }
}