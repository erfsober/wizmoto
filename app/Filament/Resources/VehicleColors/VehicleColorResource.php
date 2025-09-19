<?php

namespace App\Filament\Resources\VehicleColors;

use App\Filament\Resources\VehicleColors\Pages\CreateVehicleColor;
use App\Filament\Resources\VehicleColors\Pages\EditVehicleColor;
use App\Filament\Resources\VehicleColors\Pages\ListVehicleColors;
use App\Filament\Resources\VehicleColors\Schemas\VehicleColorForm;
use App\Filament\Resources\VehicleColors\Tables\VehicleColorsTable;
use App\Models\VehicleColor;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class VehicleColorResource extends Resource
{
    protected static ?string $model = VehicleColor::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    protected static ?string $recordTitleAttribute = 'name';

    public static function form(Schema $schema): Schema
    {
        return VehicleColorForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return VehicleColorsTable::configure($table);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListVehicleColors::route('/'),
            'create' => CreateVehicleColor::route('/create'),
            'edit' => EditVehicleColor::route('/{record}/edit'),
        ];
    }
}
