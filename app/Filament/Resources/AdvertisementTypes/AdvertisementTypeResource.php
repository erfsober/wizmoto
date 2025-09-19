<?php

namespace App\Filament\Resources\AdvertisementTypes;

use App\Filament\Resources\AdvertisementTypes\Pages\CreateAdvertisementType;
use App\Filament\Resources\AdvertisementTypes\Pages\EditAdvertisementType;
use App\Filament\Resources\AdvertisementTypes\Pages\ListAdvertisementTypes;
use App\Filament\Resources\AdvertisementTypes\Schemas\AdvertisementTypeForm;
use App\Filament\Resources\AdvertisementTypes\Tables\AdvertisementTypesTable;
use App\Models\AdvertisementType;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class AdvertisementTypeResource extends Resource
{
    protected static ?string $model = AdvertisementType::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    protected static ?string $recordTitleAttribute = 'title';

    public static function form(Schema $schema): Schema
    {
        return AdvertisementTypeForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return AdvertisementTypesTable::configure($table);
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
            'index' => ListAdvertisementTypes::route('/'),
            'create' => CreateAdvertisementType::route('/create'),
            'edit' => EditAdvertisementType::route('/{record}/edit'),
        ];
    }
}
