<?php

namespace App\Filament\Resources\Admins\Schemas;

use Filament\Forms\Components\SpatieMediaLibraryFileUpload;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;
use Illuminate\Support\Facades\Hash;

class AdminForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('name')
                    ->default(null),
                TextInput::make('email')
                    ->label('Email address')
                    ->email()
                    ->default(null),
        
                TextInput::make('phone')
                    ->tel()
                    ->default(null),
                
                SpatieMediaLibraryFileUpload::make('image')
                    ->label('Profile Image')
                    ->collection('image')
                    ->image()
                    ->imageEditor()
                    ->imageEditorAspectRatios([
                        '1:1',
                    ])
                    ->maxSize(2048)
                    ->acceptedFileTypes(['image/jpeg', 'image/png', 'image/gif', 'image/webp'])
                    ->openable()
                    ->previewable()
                    ->downloadable()
                    ->reorderable()
                    ->multiple(false)
                    ->maxFiles(1)
                    ->deletable()
                    ->moveFiles()
                    ->preserveFilenames(),
            ]);
    }
}
