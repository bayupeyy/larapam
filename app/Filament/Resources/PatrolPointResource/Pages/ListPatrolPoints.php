<?php

namespace App\Filament\Resources\PatrolPointResource\Pages;

use App\Filament\Resources\PatrolPointResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListPatrolPoints extends ListRecords
{
    protected static string $resource = PatrolPointResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
