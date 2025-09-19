<?php

namespace App\Filament\Resources\VehicleBodies;

use App\Filament\Resources\VehicleBodies\Pages\CreateVehicleBody;
use App\Filament\Resources\VehicleBodies\Pages\EditVehicleBody;
use App\Filament\Resources\VehicleBodies\Pages\ListVehicleBodies;
use App\Filament\Resources\VehicleBodies\Schemas\VehicleBodyForm;
use App\Filament\Resources\VehicleBodies\Tables\VehicleBodiesTable;
use App\Models\VehicleBody;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class VehicleBodyResource extends Resource
{
    protected static ?string $model = VehicleBody::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    protected static ?string $recordTitleAttribute = 'name';

    public static function form(Schema $schema): Schema
    {
        return VehicleBodyForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return VehicleBodiesTable::configure($table);
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
            'index' => ListVehicleBodies::route('/'),
            'create' => CreateVehicleBody::route('/create'),
            'edit' => EditVehicleBody::route('/{record}/edit'),
        ];
    }
}
