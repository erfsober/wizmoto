<?php

namespace App\Filament\Resources\Brands\Schemas;

use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Select;
use Filament\Schemas\Schema;

class BrandForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('name')
                    ->label('Brand Name')
                    ->required()
                    ->maxLength(255),
                Select::make('advertisementTypes')
                    ->label('Advertisement Types')
                    ->relationship('advertisementTypes', 'title')
                    ->multiple()
                    ->required()
                    ->searchable()
                    ->preload(),
            ]);
    }
}
