<?php

namespace App\Filament\Resources\VehicleBodies\Pages;

use App\Filament\Resources\VehicleBodies\VehicleBodyResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListVehicleBodies extends ListRecords
{
    protected static string $resource = VehicleBodyResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
