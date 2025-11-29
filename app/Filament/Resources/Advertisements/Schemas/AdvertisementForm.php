<?php

namespace App\Filament\Resources\Advertisements\Schemas;

use App\Models\City;
use App\Models\Country;
use App\Models\VehicleColor;
use App\Models\VehicleModel;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\SpatieMediaLibraryFileUpload;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Illuminate\Support\Facades\Schema as SchemaFacade;

class AdvertisementForm
{
    protected const INTERNATIONAL_PREFIXES = [
        '+1', '+30', '+31', '+32', '+33', '+34', '+351', '+352', '+353', '+354', '+355',
        '+356', '+358', '+359', '+36', '+370', '+371', '+372', '+373', '+375', '+376',
        '+377', '+378', '+379', '+380', '+381', '+382', '+385', '+386', '+387', '+389',
        '+39', '+40', '+41', '+420', '+421', '+423', '+43', '+44', '+45', '+46', '+47',
        '+48', '+49', '+52', '+55', '+7', '+90',
    ];

    protected const EMISSIONS_CLASSES = [
        'Euro 1',
        'Euro 2',
        'Euro 3',
        'Euro 4',
        'Euro 5',
        'Euro 6',
    ];
    
    public static function configure(Schema $schema): Schema
    {
        $hasCountryColumn = SchemaFacade::hasColumn('advertisements', 'country_id');
        $hasCityColumn = SchemaFacade::hasColumn('advertisements', 'city_id');
        $internationalPrefixOptions = array_combine(self::INTERNATIONAL_PREFIXES, self::INTERNATIONAL_PREFIXES);

        return $schema->components([
            Section::make('Listing Owner')
                ->columnSpanFull()
                ->schema([
                    Grid::make(2)
                        ->schema([
                            Select::make('provider_id')
                                ->label('Provider')
                                ->relationship('provider', 'title')
                                ->getOptionLabelFromRecordUsing(function ($record) {
                                    if ($record->title) {
                                        return $record->title;
                                    }
                                    $fullName = trim(($record->first_name ?? '') . ' ' . ($record->last_name ?? ''));
                                    if ($fullName) {
                                        return $fullName;
                                    }
                                    return $record->email ?? 'N/A';
                                })
                                ->required()
                                ->searchable()
                                ->preload(),
                            Toggle::make('is_verified')
                                ->label('Verified by Admin')
                                ->inline(false)
                                ->helperText('Mark as verified to publish the advertisement.'),
                        ]),
                ]),
            Section::make('Vehicle Data')
                ->columnSpanFull()
                ->schema([
                    Grid::make(2)
                        ->schema([
                Select::make('advertisement_type_id')
                                ->label('What do you sell?')
                    ->relationship('advertisementType', 'title')
                                ->getOptionLabelFromRecordUsing(fn ($record) => $record->localized_title ?? $record->title ?? 'N/A')
                                ->required()
                                ->searchable()
                                ->preload(),
                Select::make('brand_id')
                    ->relationship('brand', 'name')
                                ->getOptionLabelFromRecordUsing(fn ($record) => $record->localized_name ?? $record->name ?? 'N/A')
                                ->label('Brand')
                                ->required()
                                ->searchable()
                                ->preload()
                                ->reactive()
                                ->afterStateUpdated(fn ($state, callable $set) => $set('vehicle_model_id', null)),
                Select::make('vehicle_model_id')
                                ->label('Model')
                                ->options(function (callable $get) {
                                    $brandId = $get('brand_id');

                                    if (! $brandId) {
                                        return [];
                                    }

                                    return VehicleModel::query()
                                        ->where('brand_id', $brandId)
                                        ->orderBy('name')
                                        ->pluck('name', 'id')
                                        ->toArray();
                                })
                                ->required()
                                ->searchable()
                                ->disabled(fn (callable $get) => blank($get('brand_id')))
                                ->reactive(),
                TextInput::make('version_model')
                                ->label('Version')
                                ->maxLength(255),
                        ]),
                ]),
            Section::make('Characteristics')
                ->columnSpanFull()
                ->schema([
                    Grid::make(2)
                        ->schema([
                Select::make('vehicle_body_id')
                                ->label('Body Type')
                    ->relationship('vehicleBody', 'name')
                                ->getOptionLabelFromRecordUsing(fn ($record) => $record->localized_name ?? $record->name ?? 'N/A')
                                ->required()
                                ->searchable()
                                ->preload(),
                            Select::make('color_id')
                                ->label('Exterior Color')
                                ->options(fn () => VehicleColor::query()
                                    ->orderBy('name')
                                    ->pluck('name', 'id'))
                                ->searchable()
                                ->preload(),
                Toggle::make('is_metallic_paint')
                                ->label('Metallic Paint')
                                ->inline(false),
                            Select::make('vehicle_category')
                                ->label('Vehicle Category')
                                ->options([
                                    'Used' => 'Used',
                                    'Era' => 'Era',
                                ])
                                ->required()
                                ->searchable(),
                TextInput::make('mileage')
                    ->numeric()
                                ->label('Mileage (km)')
                                ->required(),
                TextInput::make('registration_month')
                                ->label('Registration Month')
                                ->maxLength(2)
                                ->required(),
                TextInput::make('registration_year')
                                ->label('Registration Year')
                                ->maxLength(4)
                                ->required(),
                TextInput::make('previous_owners')
                    ->numeric()
                                ->label('Previous Owners')
                                ->default(1),
                        ]),
                ]),
            Section::make('Equipment & Maintenance')
                ->columnSpanFull()
                ->schema([
                    Grid::make(2)
                        ->schema([
                            Toggle::make('service_history_available')
                                ->label('Service History Available')
                                ->inline(false),
                            Toggle::make('warranty_available')
                                ->label('Warranty Available')
                                ->inline(false),
                            TextInput::make('next_review_month')
                                ->label('Next Review Month')
                                ->maxLength(2),
                TextInput::make('next_review_year')
                                ->label('Next Review Year')
                                ->maxLength(4),
                TextInput::make('last_service_month')
                                ->label('Last Service Month')
                                ->maxLength(2),
                TextInput::make('last_service_year')
                                ->label('Last Service Year')
                                ->maxLength(4),
                        ]),
                    Grid::make(1)
                        ->schema([
                            Select::make('equipments')
                                ->label('Equipments & Accessories')
                                ->relationship('equipments', 'name')
                                ->multiple()
                                ->searchable()
                                ->preload()
                                ->helperText('Mirror the equipment checklist available to providers.'),
                        ]),
                ]),
            Section::make('Engine & Performance')
                ->columnSpanFull()
                ->schema([
                    Grid::make(3)
                        ->schema([
                            Select::make('motor_change')
                                ->label('Gearbox')
                                ->options([
                                    'Manual' => 'Manual',
                                    'Automatic' => 'Automatic',
                                    'Semi-automatic' => 'Semi-automatic',
                                ]),
                TextInput::make('motor_power_kw')
                                ->label('Power (kW)')
                    ->numeric()
                                ->required(),
                TextInput::make('motor_power_cv')
                                ->label('Power (CV)')
                    ->numeric()
                                ->required(),
                TextInput::make('motor_marches')
                                ->label('Gears')
                                ->numeric(),
                TextInput::make('motor_cylinders')
                                ->label('Cylinders')
                                ->numeric(),
                TextInput::make('motor_displacement')
                                ->label('Displacement (cc)')
                                ->numeric(),
                TextInput::make('motor_empty_weight')
                                ->label('Empty Weight (kg)')
                                ->numeric(),
                Select::make('fuel_type_id')
                                ->label('Fuel Type')
                                ->relationship('fuelType', 'name')
                                ->getOptionLabelFromRecordUsing(fn ($record) => $record->localized_name ?? $record->name ?? 'N/A')
                                ->searchable()
                                ->preload()
                                ->required(),
                            Select::make('drive_type')
                                ->label('Drive Type')
                                ->options([
                                    'Chain' => 'Chain',
                                    'Belt' => 'Belt',
                                    'Shaft' => 'Shaft',
                                ]),
                            TextInput::make('tank_capacity_liters')
                                ->label('Tank Capacity (L)')
                                ->numeric(),
                            TextInput::make('seat_height_mm')
                                ->label('Seat Height (mm)')
                                ->numeric(),
                            TextInput::make('top_speed_kmh')
                                ->label('Top Speed (km/h)')
                                ->numeric(),
                            TextInput::make('torque_nm')
                                ->label('Torque (Nm)')
                                ->numeric(),
                TextInput::make('combined_fuel_consumption')
                                ->label('Fuel Consumption (L/100km)')
                                ->numeric(),
                TextInput::make('co2_emissions')
                                ->label('CO2 Emissions (g/km)')
                                ->numeric(),
                            Select::make('emissions_class')
                                ->label('Emissions Class')
                                ->options(array_combine(self::EMISSIONS_CLASSES, self::EMISSIONS_CLASSES)),
                        ]),
                ]),
            Section::make('Pricing & Sales Features')
                ->columnSpanFull()
                ->schema([
                    Grid::make(2)
                        ->schema([
                            TextInput::make('final_price')
                                ->label('Final Price')
                    ->numeric()
                    ->required(),
                            TextInput::make('price_evaluation')
                                ->label('Price Evaluation')
                                ->disabled()
                                ->hint('Automatically recalculated after save.'),
                Toggle::make('tax_deductible')
                                ->label('Tax Deductible')
                                ->inline(false),
                            Toggle::make('price_negotiable')
                                ->label('Price Negotiable')
                                ->inline(false),
                            Toggle::make('financing_available')
                                ->label('Financing Available')
                                ->inline(false),
                            Toggle::make('trade_in_possible')
                                ->label('Trade-in Possible')
                                ->inline(false),
                            Toggle::make('available_immediately')
                                ->label('Available Immediately')
                                ->inline(false)
                                ->default(true),
                        ]),
                ]),
            Section::make('Seller & Contact')
                ->columnSpanFull()
                ->schema(function () use ($hasCountryColumn, $hasCityColumn, $internationalPrefixOptions) {
                    $components = [
                        Grid::make(2)
                            ->schema([
                                TextInput::make('zip_code')
                                    ->label('ZIP Code')
                                    ->maxLength(20)
                    ->required(),
                TextInput::make('city')
                                    ->label('City')
                                    ->maxLength(100)
                                    ->required()
                                    ->helperText('Displayed on the listing – kept even if IDs are stored.'),
                            ]),
                    ];

                    $locationFields = [];

                    if ($hasCountryColumn) {
                        $locationFields[] = Select::make('country_id')
                            ->label('Country')
                            ->options(fn () => Country::query()
                                ->orderBy('name')
                                ->pluck('name', 'id')
                                ->toArray())
                            ->searchable()
                            ->preload()
                            ->required()
                            ->reactive()
                            ->afterStateUpdated(fn ($state, callable $set) => $set('city_id', null));

                        if ($hasCityColumn) {
                            $locationFields[] = Select::make('city_id')
                                ->label('City (Directory)')
                                ->options(function (callable $get) {
                                    $countryId = $get('country_id');

                                    if (! $countryId) {
                                        return [];
                                    }

                                    return City::query()
                                        ->where('country_id', $countryId)
                                        ->orderBy('name')
                                        ->pluck('name', 'id')
                                        ->toArray();
                                })
                                ->searchable()
                                ->preload()
                                ->required()
                                ->disabled(fn (callable $get) => blank($get('country_id')))
                                ->reactive()
                                ->afterStateUpdated(function ($state, callable $set) {
                                    if (! $state) {
                                        return;
                                    }

                                    $cityName = City::query()->find($state)?->name;
                                    if ($cityName) {
                                        $set('city', $cityName);
                                    }
                                });
                        }
                    }

                    if (! empty($locationFields)) {
                        $components[] = Grid::make(2)->schema($locationFields);
                    }

                    $components[] = Grid::make(2)
                        ->schema([
                            Select::make('international_prefix')
                                ->label('International Prefix')
                                ->options($internationalPrefixOptions)
                                ->searchable()
                                ->default('+39'),
                TextInput::make('prefix')
                                ->label('Phone Prefix')
                                ->maxLength(5),
                TextInput::make('telephone')
                                ->label('Telephone')
                    ->tel()
                                ->maxLength(20),
                            Toggle::make('show_phone')
                                ->label('Show Phone')
                                ->inline(false),
                        ]);

                    return $components;
                }),
            Section::make('Description & Media')
                ->columnSpanFull()
                ->schema([
                    Textarea::make('description')
                        ->label('Description')
                        ->columnSpanFull()
                        ->rows(6),
                SpatieMediaLibraryFileUpload::make('media')
                        ->label('Advertisement Images')
                    ->collection('covers')
                    ->multiple()
                    ->reorderable()
                    ->appendFiles()
                    ->image()
                    ->imageEditor()
                        ->imageEditorAspectRatios(['16:9', '4:3', '1:1'])
                    ->maxSize(5120)
                    ->acceptedFileTypes(['image/jpeg', 'image/png', 'image/gif', 'image/webp'])
                    ->openable()
                    ->previewable()
                    ->downloadable()
                    ->deletable()
                    ->moveFiles()
                    ->preserveFilenames()
                        ->columnSpanFull()
                        ->helperText('Matches the provider dashboard requirement of at least one image.'),
                ]),
            ]);
    }
}
