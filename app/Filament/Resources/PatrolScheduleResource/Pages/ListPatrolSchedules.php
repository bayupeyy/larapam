<?php

namespace App\Filament\Resources\PatrolScheduleResource\Pages;

use App\Filament\Resources\PatrolScheduleResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListPatrolSchedules extends ListRecords
{
    protected static string $resource = PatrolScheduleResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
