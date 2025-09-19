<?php

namespace App\Filament\Resources\VehicleBodies\Schemas;

use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Select;
use Filament\Schemas\Schema;

class VehicleBodyForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('name')
                    ->label('Vehicle Body Name')
                    ->required()
                    ->maxLength(255),
                Select::make('advertisement_type_id')
                    ->label('Advertisement Type')
                    ->relationship('advertisementType', 'title')
                    ->required()
                    ->searchable()
                    ->preload(),
            ]);
    }
}
