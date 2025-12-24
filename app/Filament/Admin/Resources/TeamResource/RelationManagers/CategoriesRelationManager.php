<?php

namespace App\Filament\Admin\Resources\TeamResource\RelationManagers;

use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Table;

class CategoriesRelationManager extends RelationManager
{
    protected static string $relationship = 'categories';

    protected static ?string $title = 'Team Categories';

    protected static ?string $icon = 'heroicon-o-tag';

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Category Information')
                    ->schema([
                        Forms\Components\TextInput::make('category_name')
                            ->label('Category Name')
                            ->required()
                            ->maxLength(255)
                            ->placeholder('e.g., U-16, U-18, U-22, Senior')
                            ->helperText('Contoh: U-16, U-18, U-22, Senior, Junior'),

                        Forms\Components\TextInput::make('age_group')
                            ->label('Age Group Description')
                            ->maxLength(255)
                            ->placeholder('e.g., Under 16 Years Old')
                            ->helperText('Deskripsi kelompok usia (optional)'),

                        Forms\Components\Grid::make(2)
                            ->schema([
                                Forms\Components\TextInput::make('min_age')
                                    ->label('Minimum Age')
                                    ->numeric()
                                    ->minValue(0)
                                    ->maxValue(100)
                                    ->placeholder('e.g., 14')
                                    ->helperText('Usia minimal pemain (optional)'),

                                Forms\Components\TextInput::make('max_age')
                                    ->label('Maximum Age')
                                    ->numeric()
                                    ->minValue(0)
                                    ->maxValue(100)
                                    ->placeholder('e.g., 16')
                                    ->helperText('Usia maksimal pemain (optional)'),
                            ]),

                        Forms\Components\Toggle::make('is_active')
                            ->label('Active Status')
                            ->default(true)
                            ->helperText('Kategori tidak aktif tidak akan muncul di form pemain'),
                    ])
                    ->columns(1),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('category_name')
            ->columns([
                Tables\Columns\TextColumn::make('category_name')
                    ->label('Category')
                    ->searchable()
                    ->sortable()
                    ->weight('bold')
                    ->badge()
                    ->color('primary'),

                Tables\Columns\TextColumn::make('age_group')
                    ->label('Age Group')
                    ->searchable()
                    ->default('-'),

                Tables\Columns\TextColumn::make('age_range')
                    ->label('Age Range')
                    ->getStateUsing(function ($record) {
                        if ($record->min_age && $record->max_age) {
                            return $record->min_age . ' - ' . $record->max_age . ' tahun';
                        } elseif ($record->min_age) {
                            return $record->min_age . '+ tahun';
                        } elseif ($record->max_age) {
                            return 'Max ' . $record->max_age . ' tahun';
                        }
                        return '-';
                    })
                    ->badge()
                    ->color('info'),

                Tables\Columns\TextColumn::make('players_count')
                    ->counts('players')
                    ->label('Total Players')
                    ->sortable()
                    ->badge()
                    ->color('success'),

                Tables\Columns\IconColumn::make('is_active')
                    ->label('Active')
                    ->boolean()
                    ->sortable(),

                Tables\Columns\TextColumn::make('created_at')
                    ->label('Created')
                    ->dateTime('d M Y')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                Tables\Filters\TernaryFilter::make('is_active')
                    ->label('Active Status')
                    ->placeholder('All Categories')
                    ->trueLabel('Active Only')
                    ->falseLabel('Inactive Only'),
            ])
            ->headerActions([
                Tables\Actions\CreateAction::make()
                    ->label('Add Category')
                    ->icon('heroicon-o-plus')
                    ->successNotificationTitle('Category added successfully!'),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make()
                    ->requiresConfirmation()
                    ->before(function ($record) {
                        if ($record->players()->count() > 0) {
                            \Filament\Notifications\Notification::make()
                                ->title('Cannot Delete Category')
                                ->danger()
                                ->body('This category has ' . $record->players()->count() . ' players assigned. Please reassign them first.')
                                ->send();
                            return false;
                        }
                    }),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ])
            ->defaultSort('created_at', 'desc')
            ->emptyStateHeading('No categories yet')
            ->emptyStateDescription('Add categories like U-16, U-18, U-22, or Senior to organize your players.')
            ->emptyStateIcon('heroicon-o-tag');
    }
}