<?php

namespace App\Filament\Resources\Faqs\Schemas;

use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Schema;

class FaqForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('question')
                    ->default(null),
                TextInput::make('question_en')
                    ->label('Question (English)'),
                Textarea::make('answer')
                    ->default(null)
                    ->columnSpanFull(),
                Textarea::make('answer_en')
                    ->label('Answer (English)')
                    ->default(null)
                    ->columnSpanFull(),
                TextInput::make('category')
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
