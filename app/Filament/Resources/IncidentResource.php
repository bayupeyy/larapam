<?php

namespace App\Filament\Resources;

use App\Filament\Resources\IncidentResource\Pages;
use App\Models\Incident;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Support\Str;

class IncidentResource extends Resource
{
    protected static ?string $model = Incident::class;
    protected static ?string $navigationIcon = 'heroicon-o-exclamation-triangle';
    protected static ?string $navigationGroup = 'Laporan';

    public static function form(Form $form): Form
    {
        return $form->schema([
            Forms\Components\Select::make('user_id')
                ->relationship('user', 'name')
                ->label('Pelapor')
                ->required()
                ->searchable()
                ->preload(),

            Forms\Components\Textarea::make('description')
                ->label('Deskripsi Insiden')
                ->rows(5)
                ->required(),

            Forms\Components\FileUpload::make('photo_path')
                ->label('Foto (opsional)')
                ->image()
                ->directory('incidents')   // disimpan di storage/app/public/incidents
                ->disk('public')
                ->visibility('public')
                ->acceptedFileTypes(['image/png','image/jpeg','image/jpg','image/webp'])
                ->maxSize(1024)
                ->imagePreviewHeight('220')
                ->openable()
                ->downloadable()
                ->getUploadedFileNameForStorageUsing(
                    fn ($file) => now()->format('Ymd_His') . '_' . Str::random(6) . '.' . $file->getClientOriginalExtension()
                ),

            Forms\Components\DateTimePicker::make('reported_at')
                ->label('Waktu Lapor')
                ->seconds(false)
                ->default(now()),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table->columns([
            Tables\Columns\TextColumn::make('id')->sortable(),

            Tables\Columns\TextColumn::make('user.name')
                ->label('Pelapor')
                ->searchable(),

            Tables\Columns\TextColumn::make('description')
                ->label('Deskripsi')
                ->limit(60)
                ->tooltip(fn ($record) => $record->description),

            Tables\Columns\ImageColumn::make('photo_path')
                ->label('Foto')
                ->getStateUsing(
                    fn($record) => $record->photo_path
                        ? asset('storage/' . ltrim($record->photo_path, '/'))  // -> /storage/qr_codes/xxx.svg
                        : null
                )
                ->height(48),

            Tables\Columns\TextColumn::make('reported_at')
                ->label('Dilaporkan')
                ->dateTime('d M Y H:i'),
        ])
        ->actions([
            Tables\Actions\ViewAction::make(),
            Tables\Actions\EditAction::make(),
            Tables\Actions\DeleteAction::make(),
        ]);
    }

    public static function getPages(): array
    {
        return [
            'index'  => Pages\ListIncidents::route('/'),
            'create' => Pages\CreateIncident::route('/create'),
            'edit'   => Pages\EditIncident::route('/{record}/edit'),
            'view'   => Pages\ViewIncident::route('/{record}'), // ⬅️ penting
        ];
    }
}
