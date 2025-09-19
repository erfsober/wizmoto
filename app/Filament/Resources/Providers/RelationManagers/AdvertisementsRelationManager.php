<?php

namespace App\Filament\Resources\Providers\RelationManagers;

use App\Filament\Resources\Advertisements\AdvertisementResource;
use Filament\Actions\CreateAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class AdvertisementsRelationManager extends RelationManager
{
    protected static string $relationship = 'advertisements';

    protected static ?string $relatedResource = AdvertisementResource::class;

    public function table(Table $table): Table
    {
        return $table
            ->columns([
                ImageColumn::make('media')
                    ->label('Image')
                    ->getStateUsing(function ($record) {
                        return $record->getFirstMediaUrl('covers', 'thumb');
                    })
                    ->circular()
                    ->size(60),
                TextColumn::make('title')
                    ->label('Title')
                    ->searchable()
                    ->sortable()
                    ->limit(50),
                TextColumn::make('advertisementType.title')
                    ->label('Type')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('final_price')
                    ->label('Price')
                    ->money('USD')
                    ->sortable(),
                TextColumn::make('status')
                    ->label('Status')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'active' => 'success',
                        'pending' => 'warning',
                        'inactive' => 'gray',
                        'rejected' => 'danger',
                        default => 'gray',
                    }),
                TextColumn::make('created_at')
                    ->label('Created')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('updated_at')
                    ->label('Updated')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                //
            ])
            ->headerActions([
            
            ])
            ->recordActions([
                EditAction::make(),
            ])
            ->defaultSort('created_at', 'desc');
    }
}
