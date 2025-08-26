<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PatrolScheduleResource\Pages;
use App\Models\PatrolSchedule;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class PatrolScheduleResource extends Resource
{
    protected static ?string $model = PatrolSchedule::class;

    protected static ?string $navigationIcon = 'heroicon-o-calendar-days';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('user_id')
                    ->label('Petugas')
                    ->relationship('user', 'name')
                    ->searchable()
                    ->required(),

                Forms\Components\Select::make('patrol_point_id')
                    ->label('Titik Patroli')
                    ->relationship('patrolPoint', 'name')
                    ->searchable()
                    ->required(),

                Forms\Components\DateTimePicker::make('start_time')
                    ->label('Waktu Mulai')
                    ->required(),

                Forms\Components\DateTimePicker::make('end_time')
                    ->label('Waktu Selesai')
                    ->required(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('user.name')
                    ->label('Petugas')
                    ->sortable()
                    ->searchable(),

                Tables\Columns\TextColumn::make('patrolPoint.name')
                    ->label('Titik Patroli')
                    ->sortable()
                    ->searchable(),

                Tables\Columns\TextColumn::make('start_time')
                    ->label('Mulai')
                    ->dateTime('d M Y H:i')
                    ->sortable(),

                Tables\Columns\TextColumn::make('end_time')
                    ->label('Selesai')
                    ->dateTime('d M Y H:i')
                    ->sortable(),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
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
            'index'  => Pages\ListPatrolSchedules::route('/'),
            'create' => Pages\CreatePatrolSchedule::route('/create'),
            'edit'   => Pages\EditPatrolSchedule::route('/{record}/edit'),
        ];
    }
}
