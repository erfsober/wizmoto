<?php

namespace App\Filament\Resources\VehicleModels\Schemas;

use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Select;
use Filament\Schemas\Schema;

class VehicleModelForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('name')
                    ->label('Model Name')
                    ->required()
                    ->maxLength(255),
                TextInput::make('name_en')
                    ->label('Model Name (English)')
                    ->maxLength(255),
                TextInput::make('name_it')
                    ->label('Model Name (Italian)')
                    ->maxLength(255),
                Select::make('brand_id')
                    ->label('Brand')
                    ->relationship('brand', 'name')
                    ->required()
                    ->searchable()
                    ->preload(),
            ]);
    }
}
