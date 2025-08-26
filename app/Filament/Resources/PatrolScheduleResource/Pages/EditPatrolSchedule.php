<?php

namespace App\Filament\Resources\PatrolScheduleResource\Pages;

use App\Filament\Resources\PatrolScheduleResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditPatrolSchedule extends EditRecord
{
    protected static string $resource = PatrolScheduleResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
