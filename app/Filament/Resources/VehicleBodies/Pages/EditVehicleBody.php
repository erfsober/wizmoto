<?php

namespace App\Filament\Resources\VehicleBodies\Pages;

use App\Filament\Resources\VehicleBodies\VehicleBodyResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditVehicleBody extends EditRecord
{
    protected static string $resource = VehicleBodyResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
