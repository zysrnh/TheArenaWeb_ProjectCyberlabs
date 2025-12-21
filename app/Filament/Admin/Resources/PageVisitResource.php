<?php

namespace App\Filament\Admin\Resources;

use App\Filament\Admin\Resources\PageVisitResource\Pages;
use App\Filament\Admin\Resources\PageVisitResource\RelationManagers;
use App\Models\PageVisit;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class PageVisitResource extends Resource
{
    protected static ?string $model = PageVisit::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('client_id')
                    ->relationship('client', 'name'),
                Forms\Components\TextInput::make('ip_address')
                    ->required()
                    ->maxLength(45),
                Forms\Components\TextInput::make('url')
                    ->required()
                    ->maxLength(500),
                Forms\Components\TextInput::make('method')
                    ->required()
                    ->maxLength(10),
                Forms\Components\Textarea::make('user_agent')
                    ->columnSpanFull(),
                Forms\Components\TextInput::make('session_id')
                    ->maxLength(255),
                Forms\Components\DateTimePicker::make('visited_at')
                    ->required(),
            ]);
            
    }

   public static function table(Table $table): Table
{
    return $table
        ->columns([
            Tables\Columns\TextColumn::make('client.name')
                ->label('Client')
                ->searchable()
                ->sortable()
                ->placeholder('Anonim'),
                
            Tables\Columns\TextColumn::make('ip_address')
                ->label('IP Address')
                ->searchable(),
                
            Tables\Columns\TextColumn::make('url')
                ->label('URL')
                ->limit(50)
                ->searchable()
                ->wrap(),
                
            Tables\Columns\TextColumn::make('visited_at')
                ->label('Visited At')
                ->dateTime('d M Y H:i')
                ->sortable()
                ->since(),
        ])
        ->defaultSort('visited_at', 'desc')
        ->filters([
            Tables\Filters\Filter::make('has_client')
                ->label('Hanya Client Login')
                ->query(fn ($query) => $query->whereNotNull('client_id')),
                
            Tables\Filters\Filter::make('anonymous')
                ->label('Hanya Anonim')
                ->query(fn ($query) => $query->whereNull('client_id')),
        ]);
}
public static function canCreate(): bool
{
    return false;
}

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListPageVisits::route('/'),
            'create' => Pages\CreatePageVisit::route('/create'),
            'edit' => Pages\EditPageVisit::route('/{record}/edit'),
        ];
    }
}
