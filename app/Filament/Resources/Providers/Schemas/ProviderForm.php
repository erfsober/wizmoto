<?php

namespace App\Filament\Resources\Providers\Schemas;

use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class ProviderForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('username')
                    ->default(null),
                TextInput::make('email')
                    ->label('Email address')
                    ->email()
                    ->default(null),
                TextInput::make('title')
                    ->default(null),
                TextInput::make('first_name')
                    ->default(null),
                TextInput::make('last_name')
                    ->default(null),
                TextInput::make('phone')
                    ->tel()
                    ->default(null),
                TextInput::make('whatsapp')
                    ->default(null),
                TextInput::make('address')
                    ->default(null),
                TextInput::make('village')
                    ->default(null),
                TextInput::make('zip_code')
                    ->default(null),
                TextInput::make('city')
                    ->default(null),
                TextInput::make('show_info_in_advertisement')
                    ->default(null),
                DateTimePicker::make('email_verified_at'),
            ]);
    }
}
