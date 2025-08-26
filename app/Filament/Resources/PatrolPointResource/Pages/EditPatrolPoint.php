<?php

namespace App\Filament\Resources\PatrolPointResource\Pages;

use App\Filament\Resources\PatrolPointResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditPatrolPoint extends EditRecord
{
    protected static string $resource = PatrolPointResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
