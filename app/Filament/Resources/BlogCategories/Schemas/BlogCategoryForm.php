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
                Toggle::make('published')
                    ->required(),
                TextInput::make('slug')
                    ->default(null),
            ]);
    }
}
