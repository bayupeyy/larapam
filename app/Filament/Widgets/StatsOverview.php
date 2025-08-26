<?php

namespace App\Filament\Widgets;

use App\Models\PatrolPoint;
use App\Models\PatrolSchedule;
use App\Models\Incident;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class StatsOverview extends BaseWidget
{
    protected function getStats(): array
    {
        return [
            Stat::make('Titik Patroli', PatrolPoint::count()),

            Stat::make('Jadwal Hari Ini', PatrolSchedule::whereDate('start_time', today())->count()),

            Stat::make('Total Insiden', Incident::count())
                ->color('danger'),
        ];
    }
}
