<?php

namespace App\Filament\Widgets;

use App\Models\Incident;
use Filament\Widgets\TableWidget as BaseWidget;
use Filament\Tables;

class RecentIncidents extends BaseWidget
{
    protected int|string|array $columnSpan = 'full'; // biar widget melebar penuh (opsional)

    public function table(\Filament\Tables\Table $table): \Filament\Tables\Table
    {
        return $table
            ->query(
                Incident::query()
                    ->latest()
                    ->limit(5)
            )
            ->columns([
                Tables\Columns\TextColumn::make('id')
                    ->label('ID')
                    ->sortable(),

                Tables\Columns\TextColumn::make('user.name')
                    ->label('Petugas')
                    ->sortable()
                    ->searchable(),

                Tables\Columns\TextColumn::make('description')
                    ->label('Deskripsi')
                    ->limit(50),

                Tables\Columns\TextColumn::make('reported_at')
                    ->label('Dilaporkan')
                    ->dateTime('d M Y H:i')
                    ->sortable(),
            ]);
    }
}
