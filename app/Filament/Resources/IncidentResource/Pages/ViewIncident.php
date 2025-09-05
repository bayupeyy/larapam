<?php

namespace App\Filament\Resources\IncidentResource\Pages;

use App\Filament\Resources\IncidentResource;
use Filament\Actions;
use Filament\Resources\Pages\ViewRecord;

class ViewIncident extends ViewRecord
{
    protected static string $resource = IncidentResource::class;

    protected function getHeaderActions(): array
    {
        return [
            // Tombol buka gambar asli di tab baru (jika ada)
            Actions\Action::make('openImage')
                ->label('Lihat Gambar Asli')
                ->icon('heroicon-o-photo')
                ->visible(fn () => filled($this->record->photo_path))
                ->url(fn () => $this->record->photo_path
                    ? asset('storage/' . ltrim($this->record->photo_path, '/'))
                    : '#'
                )
                ->openUrlInNewTab(),
        ];
    }
}
