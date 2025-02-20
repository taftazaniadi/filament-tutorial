<?php

namespace App\Filament\Resources\YesResource\Widgets;

use App\Models\Device;
use Filament\Support\Enums\IconPosition;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class CountDeviceOverview extends BaseWidget
{
    protected static ?string $pollingInterval = '5s';

    protected static bool $isLazy = false;

    protected function getStats(): array
    {
        return [
            // ! Get the total number of devices from the database
            Stat::make('Total Devices', Device::count()),
            Stat::make('Active Devices', Device::where('is_active', 1)->count()),
            Stat::make('Inactive Devices', Device::where('is_active', 0)->count()),
        ];
    }
}
