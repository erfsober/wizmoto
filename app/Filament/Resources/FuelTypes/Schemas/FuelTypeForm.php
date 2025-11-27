<?php

namespace App\Filament\Resources\FuelTypes\Schemas;

use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class FuelTypeForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('code')
                    ->label('Fuel Code')
                    ->required()
                    ->maxLength(10),
                TextInput::make('name')
                    ->label('Fuel Type Name')
                    ->required()
                    ->maxLength(255),
            ]);
    }
}
