<?php

namespace App\Filament\Resources\BlogCategories\Schemas;

use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Schema;

class BlogCategoryForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('title')
                    ->default(null),
                TextInput::make('title_en')
                    ->label('Title (English)'),
                Toggle::make('published')
                    ->required(),
                TextInput::make('slug')
                    ->default(null),
                TextInput::make('sort')
                    ->numeric()
                    ->default(null),
            ]);
    }
}
