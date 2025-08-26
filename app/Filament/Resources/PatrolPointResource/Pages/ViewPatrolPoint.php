<?php

namespace App\Filament\Resources\PatrolPointResource\Pages;

use App\Filament\Resources\PatrolPointResource;
use Filament\Actions;
use Filament\Resources\Pages\ViewRecord;
use Illuminate\Support\Facades\Storage;

class ViewPatrolPoint extends ViewRecord
{
    protected static string $resource = PatrolPointResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\Action::make('downloadQr')
                ->label('Download QR Code')
                ->icon('heroicon-o-arrow-down-tray')
                ->action(function () {
                    $record = $this->getRecord();

                    if ($record->qr_code_path && Storage::disk('public')->exists($record->qr_code_path)) {
                        // SVG
                        $downloadName = "qr-{$record->id}.svg";
                        $contentType  = 'image/svg+xml';

                        // Kalau kamu simpan PNG, pakai ini:
                        // $downloadName = "qr-{$record->id}.png";
                        // $contentType  = 'image/png';

                        return response()->download(
                            storage_path('app/public/' . $record->qr_code_path),
                            $downloadName,
                            ['Content-Type' => $contentType]
                        );
                    }

                    $this->notify('danger', 'QR Code tidak ditemukan.');
                }),

            Actions\EditAction::make(),
        ];
    }
}
