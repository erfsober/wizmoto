<?php

namespace App\Filament\Resources\Equipment\Schemas;

use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Select;
use Filament\Schemas\Schema;

class EquipmentForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('name')
                    ->label('Equipment Name')
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
