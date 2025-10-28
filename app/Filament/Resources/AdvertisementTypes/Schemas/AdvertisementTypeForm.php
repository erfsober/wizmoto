<?php

namespace App\Filament\Resources\AdvertisementTypes\Schemas;

use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class AdvertisementTypeForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('title')
                    ->default(null),
                TextInput::make('title_en')
                    ->label('Title (English)'),
                TextInput::make('title_it')
                    ->label('Title (Italian)'),
            ]);
    }
}
