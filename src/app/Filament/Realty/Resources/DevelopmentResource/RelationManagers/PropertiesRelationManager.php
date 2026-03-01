<?php

namespace App\Filament\Realty\Resources\DevelopmentResource\RelationManagers;

use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Table;

class PropertiesRelationManager extends RelationManager
{
    protected static string $relationship = 'properties';

    protected static ?string $title = 'Properties';

    protected static ?string $icon = 'heroicon-o-home-modern';

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('title')
            ->columns([
                Tables\Columns\TextColumn::make('title')
                    ->searchable()
                    ->sortable()
                    ->limit(40),

                Tables\Columns\TextColumn::make('unit_number')
                    ->label('Unit')
                    ->placeholder('—')
                    ->sortable(),

                Tables\Columns\TextColumn::make('property_type')
                    ->label('Type')
                    ->badge(),

                Tables\Columns\TextColumn::make('listing_type')
                    ->label('Listing')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'for_sale' => 'success',
                        'for_rent' => 'info',
                        'pre_selling' => 'warning',
                        default => 'gray',
                    }),

                Tables\Columns\TextColumn::make('status')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'active' => 'success',
                        'sold' => 'danger',
                        'rented' => 'info',
                        'draft' => 'gray',
                        default => 'warning',
                    }),

                Tables\Columns\TextColumn::make('price')
                    ->money('PHP')
                    ->sortable(),

                Tables\Columns\TextColumn::make('bedrooms')
                    ->label('Beds')
                    ->numeric()
                    ->sortable()
                    ->toggleable(),

                Tables\Columns\TextColumn::make('floor_area')
                    ->label('Area (sqm)')
                    ->numeric()
                    ->sortable()
                    ->toggleable(),

                Tables\Columns\IconColumn::make('is_featured')
                    ->label('Featured')
                    ->boolean()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('status')
                    ->options([
                        'draft' => 'Draft',
                        'active' => 'Active',
                        'sold' => 'Sold',
                        'rented' => 'Rented',
                        'reserved' => 'Reserved',
                    ]),

                Tables\Filters\SelectFilter::make('listing_type')
                    ->options([
                        'for_sale' => 'For Sale',
                        'for_rent' => 'For Rent',
                        'pre_selling' => 'Pre-Selling',
                    ]),
            ])
            ->actions([
                Tables\Actions\Action::make('view')
                    ->icon('heroicon-o-eye')
                    ->url(fn ($record) => route('filament.realty.resources.properties.edit', $record))
                    ->openUrlInNewTab(),
            ])
            ->defaultSort('created_at', 'desc');
    }
}
