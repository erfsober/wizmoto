<?php

namespace App\Filament\Resources\Advertisements\Pages;

use App\Filament\Resources\Advertisements\AdvertisementResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;
use Illuminate\Contracts\Support\Htmlable;

class EditAdvertisement extends EditRecord
{
    protected static string $resource = AdvertisementResource::class;

    public function getTitle(): string|Htmlable
    {
        return 'Advertisement of ' . optional($this->record->provider)->full_name ?? 'Unknown Provider';
    }


    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
