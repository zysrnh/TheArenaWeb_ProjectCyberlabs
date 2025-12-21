<?php

namespace App\Filament\Admin\Resources;

use App\Filament\Admin\Resources\ReviewResource\Pages;
use App\Models\Review;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Filament\Notifications\Notification;

class ReviewResource extends Resource
{
    protected static ?string $model = Review::class;

    protected static ?string $navigationIcon = 'heroicon-o-star';
    
    protected static ?string $navigationLabel = 'Reviews';
    
    protected static ?string $navigationGroup = 'Booking Management';
    
    protected static ?int $navigationSort = 4;

    public static function form(Form $form): Form
    {
        return $form->schema([]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                // ✅ Status Badge
                Tables\Columns\BadgeColumn::make('is_approved')
                    ->label('Status')
                    ->formatStateUsing(fn (bool $state): string => $state ? 'Approved' : 'Pending')
                    ->colors([
                        'success' => fn ($state): bool => $state === true,
                        'warning' => fn ($state): bool => $state === false,
                    ])
                    ->icons([
                        'heroicon-o-check-circle' => fn ($state): bool => $state === true,
                        'heroicon-o-clock' => fn ($state): bool => $state === false,
                    ])
                    ->sortable(),

                Tables\Columns\TextColumn::make('client.name')
                    ->label('Client')
                    ->searchable()
                    ->sortable()
                    ->description(fn (Review $record): string => $record->client->email ?? '')
                    ->weight('bold'),

                // ✅ Update Rating Column - tampilkan semua rating
                Tables\Columns\Layout\Split::make([
                    Tables\Columns\TextColumn::make('rating_facilities')
                        ->label('Fasilitas')
                        ->formatStateUsing(fn (int $state): string => str_repeat('⭐', $state))
                        ->size('sm'),
                    
                    Tables\Columns\TextColumn::make('rating_hospitality')
                        ->label('Keramahan')
                        ->formatStateUsing(fn (int $state): string => str_repeat('⭐', $state))
                        ->size('sm'),
                    
                    Tables\Columns\TextColumn::make('rating_cleanliness')
                        ->label('Kebersihan')
                        ->formatStateUsing(fn (int $state): string => str_repeat('⭐', $state))
                        ->size('sm'),
                ])->from('md'),

                Tables\Columns\TextColumn::make('comment')
                    ->label('Komentar')
                    ->limit(80)
                    ->searchable()
                    ->wrap()
                    ->tooltip(fn (Review $record): string => $record->comment),

                Tables\Columns\TextColumn::make('booking.booking_date')
                    ->label('Tanggal Booking')
                    ->date('d M Y')
                    ->sortable()
                    ->placeholder('-')
                    ->toggleable(),

                Tables\Columns\TextColumn::make('approved_at')
                    ->label('Disetujui')
                    ->dateTime('d M Y H:i')
                    ->sortable()
                    ->placeholder('Belum disetujui')
                    ->toggleable(),

                Tables\Columns\TextColumn::make('created_at')
                    ->label('Dibuat')
                    ->dateTime('d M Y H:i')
                    ->sortable()
                    ->since()
                    ->toggleable(),
            ])
            ->defaultSort('created_at', 'desc')
            ->filters([
                // ✅ Filter Status Approval
                Tables\Filters\SelectFilter::make('is_approved')
                    ->label('Status')
                    ->options([
                        true => 'Approved',
                        false => 'Pending',
                    ])
                    ->default(false), // Default show pending reviews

                Tables\Filters\SelectFilter::make('rating_facilities')
                    ->label('Rating Fasilitas')
                    ->options([
                        1 => '⭐ 1 Star',
                        2 => '⭐⭐ 2 Stars',
                        3 => '⭐⭐⭐ 3 Stars',
                        4 => '⭐⭐⭐⭐ 4 Stars',
                        5 => '⭐⭐⭐⭐⭐ 5 Stars',
                    ])
                    ->multiple(),

                Tables\Filters\Filter::make('created_at')
                    ->form([
                        Forms\Components\DatePicker::make('created_from')
                            ->label('Dari Tanggal'),
                        Forms\Components\DatePicker::make('created_until')
                            ->label('Sampai Tanggal'),
                    ])
                    ->query(function (Builder $query, array $data): Builder {
                        return $query
                            ->when(
                                $data['created_from'],
                                fn (Builder $query, $date): Builder => $query->whereDate('created_at', '>=', $date),
                            )
                            ->when(
                                $data['created_until'],
                                fn (Builder $query, $date): Builder => $query->whereDate('created_at', '<=', $date),
                            );
                    }),
            ])
            ->actions([
                // ✅ Action Approve/Reject
                Tables\Actions\Action::make('approve')
                    ->label('Approve')
                    ->icon('heroicon-o-check-circle')
                    ->color('success')
                    ->visible(fn (Review $record): bool => !$record->is_approved)
                    ->requiresConfirmation()
                    ->modalHeading('Approve Review')
                    ->modalDescription('Apakah Anda yakin ingin menyetujui review ini?')
                    ->modalSubmitActionLabel('Ya, Setujui')
                    ->action(function (Review $record) {
                        $record->update([
                            'is_approved' => true,
                            'approved_at' => now(),
                            'approved_by' => auth()->id(),
                        ]);

                        Notification::make()
                            ->title('Review Approved')
                            ->success()
                            ->body('Review berhasil disetujui dan akan tampil di website.')
                            ->send();
                    }),

                Tables\Actions\Action::make('reject')
                    ->label('Reject')
                    ->icon('heroicon-o-x-circle')
                    ->color('danger')
                    ->visible(fn (Review $record): bool => $record->is_approved)
                    ->requiresConfirmation()
                    ->modalHeading('Reject Review')
                    ->modalDescription('Review akan disembunyikan dari website.')
                    ->modalSubmitActionLabel('Ya, Tolak')
                    ->action(function (Review $record) {
                        $record->update([
                            'is_approved' => false,
                            'approved_at' => null,
                            'approved_by' => null,
                        ]);

                        Notification::make()
                            ->title('Review Rejected')
                            ->warning()
                            ->body('Review telah ditolak dan disembunyikan.')
                            ->send();
                    }),

                Tables\Actions\ViewAction::make()
                    ->modalHeading('Detail Review')
                    ->modalWidth('2xl')
                    ->slideOver()
                    ->modalContent(fn (Review $record): \Illuminate\Contracts\View\View => view(
                        'filament.admin.resources.review-resource.pages.view-review',
                        ['record' => $record->load('client', 'booking')]
                    )),
                    
                Tables\Actions\DeleteAction::make()
                    ->requiresConfirmation()
                    ->modalHeading('Hapus Review')
                    ->modalDescription('Apakah Anda yakin ingin menghapus review ini? Tindakan ini tidak dapat dibatalkan.')
                    ->modalSubmitActionLabel('Ya, Hapus'),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    // ✅ Bulk Approve
                    Tables\Actions\BulkAction::make('approve')
                        ->label('Approve Selected')
                        ->icon('heroicon-o-check-circle')
                        ->color('success')
                        ->requiresConfirmation()
                        ->action(function ($records) {
                            $records->each(fn ($record) => $record->update([
                                'is_approved' => true,
                                'approved_at' => now(),
                                'approved_by' => auth()->id(),
                            ]));

                            Notification::make()
                                ->title('Reviews Approved')
                                ->success()
                                ->body(count($records) . ' review berhasil disetujui.')
                                ->send();
                        }),

                    Tables\Actions\DeleteBulkAction::make()
                        ->requiresConfirmation()
                        ->modalHeading('Hapus Review Terpilih')
                        ->modalDescription('Apakah Anda yakin ingin menghapus semua review yang dipilih?')
                        ->modalSubmitActionLabel('Ya, Hapus Semua'),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListReviews::route('/'),
        ];
    }

    public static function canCreate(): bool
    {
        return false;
    }

    // ✅ Badge untuk pending reviews
    public static function getNavigationBadge(): ?string
    {
        $pendingCount = static::getModel()::where('is_approved', false)->count();
        return $pendingCount > 0 ? (string) $pendingCount : null;
    }

    public static function getNavigationBadgeColor(): ?string
    {
        return 'warning';
    }
}