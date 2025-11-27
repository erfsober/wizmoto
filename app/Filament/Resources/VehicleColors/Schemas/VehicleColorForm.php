<?php

namespace App\Filament\Resources\VehicleColors\Schemas;

use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\ColorPicker;
use Filament\Schemas\Schema;

class VehicleColorForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('name')
                    ->label('Color Name')
                    ->required()
                    ->maxLength(255)
                    ->placeholder('e.g., Red, Blue, Silver'),
                TextInput::make('name_en')
                    ->label('Color Name (English)')
                    ->maxLength(255),
                ColorPicker::make('hex_code')
                    ->label('Color')
                    ->required()
                    ->default('#000000')
                    ->helperText('Select a color using the color picker'),
            ]);
    }
}
