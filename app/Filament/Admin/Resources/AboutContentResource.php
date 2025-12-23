<?php

namespace App\Filament\Admin\Resources;

use App\Filament\Admin\Resources\AboutContentResource\Pages;
use App\Models\AboutContent;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Notifications\Notification;

class AboutContentResource extends Resource
{
    protected static ?string $model = AboutContent::class;

    protected static ?string $navigationIcon = 'heroicon-o-document-text';

    protected static ?string $navigationLabel = 'Konten About';

    protected static ?string $navigationGroup = 'Manajemen Konten';

    protected static ?int $navigationSort = 2;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Informasi Utama')
                    ->schema([
                        Forms\Components\Select::make('section_key')
                            ->label('Bagian Halaman')
                            ->options([
                                'hero' => 'Hero Section (Judul Utama)',
                                'arena' => 'The Arena (Kiri)',
                                'komunitas' => 'Komunitas (Kanan)',
                                'tribun' => 'Tribun Penonton',
                                'full_description' => 'Deskripsi Lengkap (Bawah)',
                            ])
                            ->required()
                            ->unique(ignoreRecord: true)
                            ->helperText('Pilih bagian mana yang ingin diubah'),

                        Forms\Components\TextInput::make('title')
                            ->label('Judul')
                            ->maxLength(255)
                            ->columnSpanFull(),

                        Forms\Components\TextInput::make('subtitle')
                            ->label('Sub Judul')
                            ->maxLength(255)
                            ->columnSpanFull(),
                    ])->columns(2),

                Forms\Components\Section::make('Konten & Gambar')
                    ->schema([
                        // ✅ RICH TEXT EDITOR dengan toolbar lengkap
                        Forms\Components\RichEditor::make('description_1')
                            ->label('Deskripsi 1')
                            ->toolbarButtons([
                                'attachFiles',
                                'blockquote',
                                'bold',
                                'bulletList',
                                'codeBlock',
                                'h2',
                                'h3',
                                'italic',
                                'link',
                                'orderedList',
                                'redo',
                                'strike',
                                'underline',
                                'undo',
                            ])
                            ->columnSpanFull()
                            ->required(fn (callable $get) => in_array($get('section_key'), ['arena', 'komunitas', 'tribun', 'full_description']))
                            ->helperText('Gunakan toolbar untuk format teks (bold, italic, list, dll)'),

                        Forms\Components\RichEditor::make('description_2')
                            ->label('Deskripsi 2')
                            ->toolbarButtons([
                                'attachFiles',
                                'blockquote',
                                'bold',
                                'bulletList',
                                'codeBlock',
                                'h2',
                                'h3',
                                'italic',
                                'link',
                                'orderedList',
                                'redo',
                                'strike',
                                'underline',
                                'undo',
                            ])
                            ->columnSpanFull()
                            ->helperText('Opsional - Tambahkan paragraf kedua jika diperlukan'),

                        Forms\Components\RichEditor::make('description_3')
                            ->label('Deskripsi 3 (Opsional)')
                            ->toolbarButtons([
                                'attachFiles',
                                'blockquote',
                                'bold',
                                'bulletList',
                                'codeBlock',
                                'h2',
                                'h3',
                                'italic',
                                'link',
                                'orderedList',
                                'redo',
                                'strike',
                                'underline',
                                'undo',
                            ])
                            ->columnSpanFull()
                            ->helperText('Opsional - Tambahkan paragraf ketiga jika diperlukan'),

                        Forms\Components\FileUpload::make('image_url')
                            ->label('Gambar')
                            ->image()
                            ->directory('about-images')
                            ->maxSize(2048)
                            ->imageEditor()
                            ->imageEditorAspectRatios([
                                '16:9',
                                '4:3',
                                '1:1',
                            ])
                            ->helperText('Maksimal 2MB. Format: JPG, PNG. Klik untuk edit/crop gambar.')
                            ->columnSpanFull(),
                    ]),

                Forms\Components\Section::make('Pengaturan')
                    ->schema([
                        Forms\Components\Toggle::make('is_active')
                            ->label('Aktif')
                            ->default(true)
                            ->inline(false)
                            ->helperText('Nonaktifkan untuk menyembunyikan dari halaman'),

                        Forms\Components\TextInput::make('order')
                            ->label('Urutan')
                            ->numeric()
                            ->default(0)
                            ->minValue(0)
                            ->maxValue(100)
                            ->helperText('Urutan tampilan (semakin kecil, semakin atas)'),
                    ])->columns(2),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('section_key')
                    ->label('Bagian')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'hero' => 'info',
                        'arena' => 'success',
                        'komunitas' => 'warning',
                        'tribun' => 'danger',
                        'full_description' => 'gray',
                        default => 'gray',
                    })
                    ->formatStateUsing(fn (string $state): string => match ($state) {
                        'hero' => 'Hero',
                        'arena' => 'The Arena',
                        'komunitas' => 'Komunitas',
                        'tribun' => 'Tribun',
                        'full_description' => 'Deskripsi Lengkap',
                        default => $state,
                    })
                    ->sortable()
                    ->searchable(),

                Tables\Columns\TextColumn::make('title')
                    ->label('Judul')
                    ->limit(30)
                    ->searchable()
                    ->wrap(),

                // ✅ HTML Column untuk preview rich text
                Tables\Columns\TextColumn::make('description_1')
                    ->label('Preview Deskripsi')
                    ->limit(50)
                    ->html()
                    ->wrap()
                    ->toggleable(),

                Tables\Columns\ImageColumn::make('image_url')
                    ->label('Gambar')
                    ->circular()
                    ->defaultImageUrl(url('/images/placeholder.png')),

                Tables\Columns\IconColumn::make('is_active')
                    ->label('Status')
                    ->boolean()
                    ->trueIcon('heroicon-o-check-circle')
                    ->falseIcon('heroicon-o-x-circle')
                    ->trueColor('success')
                    ->falseColor('danger'),

                Tables\Columns\TextColumn::make('order')
                    ->label('Urutan')
                    ->sortable()
                    ->badge()
                    ->color('gray'),

                Tables\Columns\TextColumn::make('updated_at')
                    ->label('Terakhir Diubah')
                    ->dateTime('d M Y, H:i')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->defaultSort('order', 'asc')
            ->filters([
                Tables\Filters\SelectFilter::make('section_key')
                    ->label('Bagian')
                    ->options([
                        'hero' => 'Hero',
                        'arena' => 'The Arena',
                        'komunitas' => 'Komunitas',
                        'tribun' => 'Tribun',
                        'full_description' => 'Deskripsi Lengkap',
                    ]),

                Tables\Filters\TernaryFilter::make('is_active')
                    ->label('Status')
                    ->placeholder('Semua')
                    ->trueLabel('Aktif')
                    ->falseLabel('Nonaktif'),
            ])
            ->actions([
                // 👁️ Modal View Action - SLIDE OVER
                Tables\Actions\ViewAction::make()
                    ->label('Lihat')
                    ->icon('heroicon-o-eye')
                    ->color('info')
                    ->modalWidth('3xl')
                    ->slideOver(),

                // 🔄 Toggle Status Aktif
                Tables\Actions\Action::make('toggle_status')
                    ->label(fn (AboutContent $record): string => $record->is_active ? 'Nonaktifkan' : 'Aktifkan')
                    ->icon(fn (AboutContent $record): string => $record->is_active ? 'heroicon-o-eye-slash' : 'heroicon-o-eye')
                    ->color(fn (AboutContent $record): string => $record->is_active ? 'warning' : 'success')
                    ->requiresConfirmation()
                    ->modalHeading(fn (AboutContent $record): string => ($record->is_active ? 'Nonaktifkan' : 'Aktifkan') . ' Konten')
                    ->modalDescription(fn (AboutContent $record): string => 
                        'Apakah Anda yakin ingin ' . ($record->is_active ? 'menonaktifkan' : 'mengaktifkan') . ' konten ini?'
                    )
                    ->action(function (AboutContent $record) {
                        $newStatus = !$record->is_active;
                        $record->update(['is_active' => $newStatus]);
                        
                        Notification::make()
                            ->title($newStatus ? 'Konten Diaktifkan' : 'Konten Dinonaktifkan')
                            ->success()
                            ->body('Status konten berhasil diubah.')
                            ->send();
                    }),

                Tables\Actions\EditAction::make()
                    ->icon('heroicon-o-pencil-square')
                    ->color('warning'),
                
                Tables\Actions\DeleteAction::make()
                    ->icon('heroicon-o-trash')
                    ->requiresConfirmation(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    // 📦 Bulk Aktifkan
                    Tables\Actions\BulkAction::make('bulk_activate')
                        ->label('Aktifkan')
                        ->icon('heroicon-o-check-circle')
                        ->color('success')
                        ->requiresConfirmation()
                        ->action(function ($records) {
                            $records->each->update(['is_active' => true]);
                            
                            Notification::make()
                                ->title('Konten Diaktifkan')
                                ->success()
                                ->body(count($records) . ' konten telah diaktifkan.')
                                ->send();
                        }),

                    // 🚫 Bulk Nonaktifkan
                    Tables\Actions\BulkAction::make('bulk_deactivate')
                        ->label('Nonaktifkan')
                        ->icon('heroicon-o-x-circle')
                        ->color('warning')
                        ->requiresConfirmation()
                        ->action(function ($records) {
                            $records->each->update(['is_active' => false]);
                            
                            Notification::make()
                                ->title('Konten Dinonaktifkan')
                                ->success()
                                ->body(count($records) . ' konten telah dinonaktifkan.')
                                ->send();
                        }),

                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ])
            ->emptyStateHeading('Belum Ada Konten')
            ->emptyStateDescription('Buat konten baru untuk mengelola halaman About.')
            ->emptyStateIcon('heroicon-o-document-text')
            ->emptyStateActions([
                Tables\Actions\CreateAction::make()
                    ->label('Buat Konten Baru')
                    ->icon('heroicon-o-plus'),
            ])
            ->poll('30s'); // Auto refresh setiap 30 detik
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListAboutContents::route('/'),
            'create' => Pages\CreateAboutContent::route('/create'),
            'edit' => Pages\EditAboutContent::route('/{record}/edit'),
        ];
    }

    public static function getNavigationBadge(): ?string
    {
        return static::getModel()::where('is_active', true)->count();
    }

    public static function getNavigationBadgeColor(): ?string
    {
        return 'success';
    }
}