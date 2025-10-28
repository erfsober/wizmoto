<?php

namespace App\Filament\Resources\AboutUs\Schemas;

use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Schema;

class AboutUsForm
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
                Textarea::make('content')
                    ->default(null)
                    ->columnSpanFull(),
                Textarea::make('content_en')
                    ->label('Content (English)')
                    ->default(null)
                    ->columnSpanFull(),
                Textarea::make('content_it')
                    ->label('Content (Italian)')
                    ->default(null)
                    ->columnSpanFull(),
                TextInput::make('section')
                    ->default(null),
                TextInput::make('sort')
                    ->required()
                    ->numeric()
                    ->default(0),
                Toggle::make('is_active')
                    ->required(),
            ]);
    }
}
