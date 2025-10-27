<?php

namespace App\Filament\Resources\Advertisements\Schemas;

use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Components\SpatieMediaLibraryFileUpload;
use Filament\Schemas\Schema;
use App\Models\Advertisement;
class AdvertisementForm
{
    
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Select::make('advertisement_type_id')
                    ->relationship('advertisementType', 'title')
                    ->required(),
                Select::make('brand_id')
                    ->relationship('brand', 'name')
                    ->default(null),
                Select::make('vehicle_model_id')
                    ->relationship('vehicleModel', 'name')
                    ->default(null),
                TextInput::make('version_model')
                    ->default(null),
                Select::make('vehicle_body_id')
                    ->relationship('vehicleBody', 'name')
                    ->default(null),
                TextInput::make('color_id')
                    ->numeric()
                    ->default(null),
                Toggle::make('is_metallic_paint')
                    ->required(),
                TextInput::make('vehicle_category')
                    ->default(null),
                TextInput::make('mileage')
                    ->numeric()
                    ->default(null),
                TextInput::make('registration_month')
                    ->default(null),
                TextInput::make('registration_year')
                    ->default(null),
                TextInput::make('previous_owners')
                    ->numeric()
                    ->default(null),
                Toggle::make('coupon_documentation')
                    ->required(),
                TextInput::make('next_review_year')
                    ->default(null),
                TextInput::make('next_review_month')
                    ->default(null),
                TextInput::make('last_service_month')
                    ->default(null),
                TextInput::make('last_service_year')
                    ->default(null),
                Toggle::make('damaged_vehicle')
                    ->required(),
                TextInput::make('motor_change')
                    ->default(null),
                TextInput::make('motor_power_kw')
                    ->numeric()
                    ->default(null),
                TextInput::make('motor_power_cv')
                    ->numeric()
                    ->default(null),
                TextInput::make('motor_marches')
                    ->numeric()
                    ->default(null),
                TextInput::make('motor_cylinders')
                    ->numeric()
                    ->default(null),
                TextInput::make('motor_displacement')
                    ->numeric()
                    ->default(null),
                TextInput::make('motor_empty_weight')
                    ->numeric()
                    ->default(null),
                Select::make('fuel_type_id')
                    ->relationship('fuelType', 'name'),
                TextInput::make('combined_fuel_consumption')
                    ->numeric()
                    ->default(null),
                TextInput::make('co2_emissions')
                    ->numeric()
                    ->default(null),
                TextInput::make('emissions_class')
                    ->default(null),
                Textarea::make('description')
                    ->default(null)
                    ->columnSpanFull(),
                Toggle::make('price_negotiable')
                    ->required(),
                Toggle::make('tax_deductible')
                    ->required(),
                TextInput::make('final_price')
                    ->numeric()
                    ->default(null),
                TextInput::make('price_evaluation')
                    ->default(null),
                TextInput::make('zip_code')
                    ->default(null),
                TextInput::make('city')
                    ->default(null),
                TextInput::make('international_prefix')
                    ->default(null),
                TextInput::make('prefix')
                    ->default(null),
                TextInput::make('telephone')
                    ->tel()
                    ->default(null),
                Toggle::make('show_phone'),
                Toggle::make('is_verified')
                    ->label('Verified by Admin')
                    ->helperText('Verify that this advertisement is valid and should be visible on the site'),
                
                SpatieMediaLibraryFileUpload::make('media')
                    ->collection('covers')
                    ->multiple()
                    ->reorderable()
                    ->appendFiles()
                    ->image()
                    ->imageEditor()
                    ->imageEditorAspectRatios([
                        '16:9',
                        '4:3',
                        '1:1',
                    ])
                    ->maxSize(5120)
                    ->acceptedFileTypes(['image/jpeg', 'image/png', 'image/gif', 'image/webp'])
                    ->openable()
                    ->previewable()
                    ->downloadable()
                    ->deletable()
                    ->moveFiles()
                    ->preserveFilenames()
                    ->label('Advertisement Images')
                    ->helperText('Upload and manage images for this advertisement. You can drag and drop to reorder them.')
                    ->columnSpanFull(),
            ]);
    }
}
