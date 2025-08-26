<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PatrolPointResource\Pages;
use App\Models\PatrolPoint;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Infolists\Components\ImageEntry;
use Filament\Infolists\Components\TextEntry;
use Filament\Infolists\Infolist;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class PatrolPointResource extends Resource
{
    protected static ?string $model = PatrolPoint::class;
    protected static ?string $navigationIcon = 'heroicon-o-map-pin';
    protected static ?string $navigationGroup = 'Manajemen Keamanan';

    public static function form(Form $form): Form
    {
        return $form->schema([
            Forms\Components\TextInput::make('name')
                ->label('Nama Titik Patroli')
                ->required(),

            Forms\Components\Textarea::make('location')
                ->label('Lokasi')
                ->nullable(),

            // Jangan tampilkan qr_code di form (otomatis dibuat)
            // Forms\Components\TextInput::make('qr_code')->disabled(), // optional untuk debug
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table->columns([
            Tables\Columns\ImageColumn::make('qr_code_path')
                ->label('QR')
                ->getStateUsing(
                    fn($record) => $record->qr_code_path
                        ? asset('storage/' . ltrim($record->qr_code_path, '/'))  // -> /storage/qr_codes/xxx.svg
                        : null
                )
                ->height(48),

            Tables\Columns\TextColumn::make('name')->label('Nama'),
            Tables\Columns\TextColumn::make('location')->label('Lokasi')->limit(40),
            Tables\Columns\TextColumn::make('created_at')->dateTime(),
        ])->actions([
            Tables\Actions\ViewAction::make(),
            Tables\Actions\EditAction::make(),
            Tables\Actions\DeleteAction::make(),
        ]);
    }

    // Detail view
    public static function infolist(Infolist $infolist): Infolist
    {
        return $infolist->schema([
            TextEntry::make('name')->label('Nama'),
            TextEntry::make('location')->label('Lokasi'),
            ImageEntry::make('qr_code_path')
                ->label('QR Code')
                ->getStateUsing(
                    fn($record) => $record->qr_code_path
                        ? asset('storage/' . $record->qr_code_path)   // ⬅️ pakai URL absolut
                        : null
                )
                ->height(300),
        ]);
    }

    public static function getPages(): array
    {
        return [
            'index'  => Pages\ListPatrolPoints::route('/'),
            'create' => Pages\CreatePatrolPoint::route('/create'),
            'edit'   => Pages\EditPatrolPoint::route('/{record}/edit'),
            'view'   => Pages\ViewPatrolPoint::route('/{record}'),
        ];
    }
}
