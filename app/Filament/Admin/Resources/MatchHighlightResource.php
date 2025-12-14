<?php

namespace App\Filament\Admin\Resources;

use App\Filament\Admin\Resources\MatchHighlightResource\Pages;
use App\Models\MatchHighlight;
use App\Models\Game;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Notifications\Notification;
use Illuminate\Database\Eloquent\Builder;

class MatchHighlightResource extends Resource
{
    protected static ?string $model = MatchHighlight::class;

    protected static ?string $navigationIcon = 'heroicon-o-film';
    
    protected static ?string $navigationLabel = 'Match Highlights';
    
    protected static ?string $navigationGroup = 'Content Management';
    
    protected static ?int $navigationSort = 3;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Highlight Information')
                    ->schema([
                        Forms\Components\Select::make('game_id')
                            ->label('Match')
                            ->options(function () {
                                return Game::with(['team1', 'team2'])
                                    ->where('status', 'finished')
                                    ->orderBy('date', 'desc')
                                    ->get()
                                    ->mapWithKeys(function ($game) {
                                        return [
                                            $game->id => "{$game->team1->name} vs {$game->team2->name} - " . 
                                                        $game->date->format('d M Y')
                                        ];
                                    });
                            })
                            ->searchable()
                            ->preload()
                            ->required()
                            ->live(),

                        Forms\Components\TextInput::make('title')
                            ->label('Title')
                            ->required()
                            ->maxLength(255)
                            ->placeholder('e.g., Buzzer Beater Quarter 4!'),

                        Forms\Components\Textarea::make('description')
                            ->label('Description')
                            ->rows(3)
                            ->maxLength(500)
                            ->placeholder('Deskripsi singkat tentang highlight ini...'),

                        Forms\Components\Select::make('quarter')
                            ->label('Quarter/Type')
                            ->options([
                                'Quarter 1' => 'Quarter 1',
                                'Quarter 2' => 'Quarter 2',
                                'Quarter 3' => 'Quarter 3',
                                'Quarter 4' => 'Quarter 4',
                                'Full Highlights' => 'Full Highlights',
                                'Best Plays' => 'Best Plays',
                                'Top 5 Plays' => 'Top 5 Plays',
                                'Game Winner' => 'Game Winner',
                            ])
                            ->default('Full Highlights')
                            ->required(),

                        Forms\Components\TextInput::make('duration')
                            ->label('Duration (mm:ss)')
                            ->placeholder('2:30')
                            ->default('2:30')
                            ->required(),
                    ])
                    ->columns(2),

                Forms\Components\Section::make('Media')
                    ->schema([
                        Forms\Components\FileUpload::make('thumbnail')
                            ->label('Thumbnail')
                            ->image()
                            ->directory('highlights/thumbnails')
                            ->maxSize(2048)
                            ->imageEditor()
                            ->helperText('Upload thumbnail untuk highlight (Max: 2MB)'),

                        Forms\Components\TextInput::make('video_url')
                            ->label('Video URL')
                            ->url()
                            ->placeholder('https://youtube.com/watch?v=... atau https://vimeo.com/...')
                            ->helperText('Link ke YouTube, Vimeo, atau platform video lainnya'),
                    ])
                    ->columns(1),

                Forms\Components\Section::make('Settings')
                    ->schema([
                        Forms\Components\TextInput::make('views')
                            ->label('Views Count')
                            ->numeric()
                            ->default(0)
                            ->helperText('Jumlah views (untuk tracking)'),

                        Forms\Components\Toggle::make('is_featured')
                            ->label('Featured')
                            ->helperText('Highlight unggulan akan muncul lebih menonjol')
                            ->default(false),

                        Forms\Components\Select::make('status')
                            ->label('Status')
                            ->options([
                                'active' => 'Active',
                                'inactive' => 'Inactive',
                            ])
                            ->default('active')
                            ->required(),
                    ])
                    ->columns(3),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('title')
                    ->label('Title')
                    ->searchable()
                    ->sortable()
                    ->weight('bold')
                    ->description(fn (MatchHighlight $record): string => 
                        $record->game->team1->name . ' vs ' . $record->game->team2->name
                    ),

                Tables\Columns\TextColumn::make('game.date')
                    ->label('Match Date')
                    ->date('d M Y')
                    ->sortable()
                    ->description(fn (MatchHighlight $record): string => 
                        $record->game->score ?? 'No score'
                    ),

                Tables\Columns\TextColumn::make('quarter')
                    ->label('Type')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'Full Highlights' => 'success',
                        'Best Plays', 'Top 5 Plays' => 'warning',
                        'Game Winner' => 'danger',
                        default => 'info',
                    })
                    ->formatStateUsing(fn (string $state): string => str_replace('Quarter ', 'Q', $state)),

                Tables\Columns\TextColumn::make('duration')
                    ->label('Duration')
                    ->icon('heroicon-o-clock')
                    ->alignCenter()
                    ->sortable(),

                Tables\Columns\TextColumn::make('views')
                    ->label('Views')
                    ->icon('heroicon-o-eye')
                    ->alignCenter()
                    ->sortable()
                    ->formatStateUsing(fn (int $state): string => 
                        $state >= 1000000 
                            ? number_format($state / 1000000, 1) . 'M'
                            : ($state >= 1000 
                                ? number_format($state / 1000, 1) . 'K' 
                                : (string) $state)
                    ),

                Tables\Columns\IconColumn::make('is_featured')
                    ->label('Featured')
                    ->boolean()
                    ->trueIcon('heroicon-o-star')
                    ->falseIcon('heroicon-o-star')
                    ->trueColor('warning')
                    ->falseColor('gray')
                    ->alignCenter()
                    ->sortable(),

                Tables\Columns\TextColumn::make('status')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'active' => 'success',
                        'inactive' => 'danger',
                        default => 'gray',
                    })
                    ->sortable(),

                Tables\Columns\TextColumn::make('created_at')
                    ->label('Created')
                    ->dateTime('d M Y, H:i')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('game_id')
                    ->label('Match')
                    ->options(function () {
                        return Game::with(['team1', 'team2'])
                            ->orderBy('date', 'desc')
                            ->get()
                            ->mapWithKeys(function ($game) {
                                return [
                                    $game->id => "{$game->team1->name} vs {$game->team2->name}"
                                ];
                            });
                    })
                    ->searchable()
                    ->preload(),

                Tables\Filters\SelectFilter::make('quarter')
                    ->label('Type')
                    ->options([
                        'Quarter 1' => 'Quarter 1',
                        'Quarter 2' => 'Quarter 2',
                        'Quarter 3' => 'Quarter 3',
                        'Quarter 4' => 'Quarter 4',
                        'Full Highlights' => 'Full Highlights',
                        'Best Plays' => 'Best Plays',
                        'Top 5 Plays' => 'Top 5 Plays',
                        'Game Winner' => 'Game Winner',
                    ])
                    ->multiple(),

                Tables\Filters\TernaryFilter::make('is_featured')
                    ->label('Featured')
                    ->placeholder('All highlights')
                    ->trueLabel('Featured only')
                    ->falseLabel('Not featured'),

                Tables\Filters\SelectFilter::make('status')
                    ->options([
                        'active' => 'Active',
                        'inactive' => 'Inactive',
                    ]),
            ])
            ->actions([
                // Modal View Details
                Tables\Actions\Action::make('view_details')
                    ->label('View Details')
                    ->icon('heroicon-o-eye')
                    ->color('info')
                    ->modalHeading(fn (MatchHighlight $record): string => 'Highlight: ' . $record->title)
                    ->modalContent(fn (MatchHighlight $record): \Illuminate\View\View => 
                        view('filament.admin.resources.match-highlight.view-modal', ['record' => $record])
                    )
                    ->modalWidth('3xl')
                    ->slideOver()
                    ->modalSubmitAction(false)
                    ->modalCancelActionLabel('Close'),

                // Toggle Status
                Tables\Actions\Action::make('toggle_status')
                    ->label(fn (MatchHighlight $record): string => $record->status === 'active' ? 'Deactivate' : 'Activate')
                    ->icon(fn (MatchHighlight $record): string => 
                        $record->status === 'active' ? 'heroicon-o-x-circle' : 'heroicon-o-check-circle'
                    )
                    ->color(fn (MatchHighlight $record): string => $record->status === 'active' ? 'danger' : 'success')
                    ->requiresConfirmation()
                    ->action(function (MatchHighlight $record) {
                        $newStatus = $record->status === 'active' ? 'inactive' : 'active';
                        $record->update(['status' => $newStatus]);
                        
                        Notification::make()
                            ->title('Status Updated!')
                            ->success()
                            ->body("Highlight is now {$newStatus}.")
                            ->send();
                    }),

                Tables\Actions\EditAction::make()
                    ->slideOver(),
                
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    // Bulk Activate
                    Tables\Actions\BulkAction::make('activate')
                        ->label('Activate')
                        ->icon('heroicon-o-check-circle')
                        ->color('success')
                        ->requiresConfirmation()
                        ->modalHeading('Activate Highlights')
                        ->modalDescription('Are you sure you want to activate the selected highlights?')
                        ->action(function ($records) {
                            $records->each->update(['status' => 'active']);
                            
                            Notification::make()
                                ->title('Highlights Activated')
                                ->success()
                                ->body(count($records) . ' highlights have been activated.')
                                ->send();
                        }),
                    
                    // Bulk Deactivate
                    Tables\Actions\BulkAction::make('deactivate')
                        ->label('Deactivate')
                        ->icon('heroicon-o-x-circle')
                        ->color('danger')
                        ->requiresConfirmation()
                        ->modalHeading('Deactivate Highlights')
                        ->modalDescription('Are you sure you want to deactivate the selected highlights?')
                        ->action(function ($records) {
                            $records->each->update(['status' => 'inactive']);
                            
                            Notification::make()
                                ->title('Highlights Deactivated')
                                ->success()
                                ->body(count($records) . ' highlights have been deactivated.')
                                ->send();
                        }),

                    // Bulk Feature
                    Tables\Actions\BulkAction::make('feature')
                        ->label('Add to Featured')
                        ->icon('heroicon-o-star')
                        ->color('warning')
                        ->requiresConfirmation()
                        ->action(function ($records) {
                            $records->each->update(['is_featured' => true]);
                            
                            Notification::make()
                                ->title('Added to Featured')
                                ->success()
                                ->body(count($records) . ' highlights are now featured.')
                                ->send();
                        }),

                    // Bulk Unfeature
                    Tables\Actions\BulkAction::make('unfeature')
                        ->label('Remove from Featured')
                        ->icon('heroicon-o-star')
                        ->color('gray')
                        ->requiresConfirmation()
                        ->action(function ($records) {
                            $records->each->update(['is_featured' => false]);
                            
                            Notification::make()
                                ->title('Removed from Featured')
                                ->success()
                                ->body(count($records) . ' highlights are no longer featured.')
                                ->send();
                        }),
                    
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ])
            ->defaultSort('created_at', 'desc')
            ->poll('60s'); // Auto refresh setiap 60 detik
    }

    public static function getRelations(): array
    {
        return [];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListMatchHighlights::route('/'),
            'create' => Pages\CreateMatchHighlight::route('/create'),
            'edit' => Pages\EditMatchHighlight::route('/{record}/edit'),
        ];
    }

    public static function getNavigationBadge(): ?string
    {
        return static::getModel()::where('status', 'active')->count();
    }

    public static function getNavigationBadgeColor(): ?string
    {
        return 'success';
    }
}