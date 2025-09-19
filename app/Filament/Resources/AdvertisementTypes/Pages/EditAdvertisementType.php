<?php

namespace App\Filament\Resources\AdvertisementTypes\Pages;

use App\Filament\Resources\AdvertisementTypes\AdvertisementTypeResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditAdvertisementType extends EditRecord
{
    protected static string $resource = AdvertisementTypeResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
