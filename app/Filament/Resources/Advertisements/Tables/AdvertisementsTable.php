<?php

namespace App\Filament\Resources\Advertisements\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class AdvertisementsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('provider.title')
                    ->searchable(),
                TextColumn::make('advertisementType.title')
                    ->searchable(),
                TextColumn::make('brand.name')
                    ->searchable(),
                TextColumn::make('vehicleModel.name')
                    ->searchable(),
                TextColumn::make('version_model')
                    ->searchable(),
                TextColumn::make('vehicleBody.name')
                    ->searchable(),
                TextColumn::make('color_id')
                    ->numeric()
                    ->sortable(),
                IconColumn::make('is_metallic_paint')
                    ->boolean(),
                TextColumn::make('vehicle_category')
                    ->searchable(),
                TextColumn::make('mileage')
                    ->numeric()
                    ->sortable(),
                TextColumn::make('registration_month')
                    ->searchable(),
                TextColumn::make('registration_year')
                    ->searchable(),
                TextColumn::make('previous_owners')
                    ->numeric()
                    ->sortable(),
                IconColumn::make('coupon_documentation')
                    ->boolean(),
                TextColumn::make('next_review_year')
                    ->searchable(),
                TextColumn::make('next_review_month')
                    ->searchable(),
                TextColumn::make('last_service_month')
                    ->searchable(),
                TextColumn::make('last_service_year')
                    ->searchable(),
                IconColumn::make('damaged_vehicle')
                    ->boolean(),
                TextColumn::make('motor_change')
                    ->searchable(),
                TextColumn::make('motor_power_kw')
                    ->numeric()
                    ->sortable(),
                TextColumn::make('motor_power_cv')
                    ->numeric()
                    ->sortable(),
                TextColumn::make('motor_marches')
                    ->numeric()
                    ->sortable(),
                TextColumn::make('motor_cylinders')
                    ->numeric()
                    ->sortable(),
                TextColumn::make('motor_displacement')
                    ->numeric()
                    ->sortable(),
                TextColumn::make('motor_empty_weight')
                    ->numeric()
                    ->sortable(),
                TextColumn::make('fuelType.name')
                    ->searchable(),
                TextColumn::make('combined_fuel_consumption')
                    ->numeric()
                    ->sortable(),
                TextColumn::make('co2_emissions')
                    ->numeric()
                    ->sortable(),
                TextColumn::make('emissions_class')
                    ->searchable(),
                IconColumn::make('price_negotiable')
                    ->boolean(),
                IconColumn::make('tax_deductible')
                    ->boolean(),
                TextColumn::make('final_price')
                    ->numeric()
                    ->sortable(),
                TextColumn::make('price_evaluation')
                    ->searchable(),
                TextColumn::make('zip_code')
                    ->searchable(),
                TextColumn::make('city')
                    ->searchable(),
                TextColumn::make('international_prefix')
                    ->searchable(),
                TextColumn::make('prefix')
                    ->searchable(),
                TextColumn::make('telephone')
                    ->searchable(),
                IconColumn::make('show_phone')
                    ->boolean(),
                IconColumn::make('is_verified')
                    ->boolean()
                    ->label('Verified')
                    ->sortable(),
                TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                //
            ])
            ->recordActions([
                EditAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
