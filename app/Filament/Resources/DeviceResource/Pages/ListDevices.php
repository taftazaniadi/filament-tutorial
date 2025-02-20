<?php

namespace App\Filament\Resources\DeviceResource\Pages;

use App\Filament\Resources\DeviceResource;
use App\Filament\Resources\YesResource\Widgets;
use Illuminate\Support\Facades\Blade;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;
use Filament\Support\Facades\FilamentView;
use Filament\Tables\View\TablesRenderHook;

class ListDevices extends ListRecords
{
    protected static string $resource = DeviceResource::class;

    protected function getHeaderActions(): array
    {
        return [
            // ! Turn off the default CreateAction
            // Actions\CreateAction::make(),
        ];
    }

    // Adding a card above the table to display the total number of devices
    protected function getHeaderWidgets(): array
    {
        return [
            // Get CountDeviceOverview widget from the YesResource
            Widgets\CountDeviceOverview::make(),
        ];
    }

    // Customizing the toolbar by adding a button to add a new device
    public function mount(): void
    {
        FilamentView::registerRenderHook(
            TablesRenderHook::TOOLBAR_START,
            function () {
                return Blade::render('<x-filament::button tag="a" href="{{ $link }}">Add Device</x-filament::button>', [
                    'link' => self::$resource::getUrl('create'),
                ]);
            },
        );

        parent::mount();
    }
}
