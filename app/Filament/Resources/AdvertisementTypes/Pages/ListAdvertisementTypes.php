<?php

namespace App\Filament\Resources\AdvertisementTypes\Pages;

use App\Filament\Resources\AdvertisementTypes\AdvertisementTypeResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListAdvertisementTypes extends ListRecords
{
    protected static string $resource = AdvertisementTypeResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
