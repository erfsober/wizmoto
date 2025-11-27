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
                TextInput::make('name_en')
                    ->label('Brand Name (English)')
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
