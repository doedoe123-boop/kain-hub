<?php

namespace App\Filament\Admin\Resources;

use App\Filament\Admin\Resources\TaxZoneResource\Pages;
use Filament\Forms;
use Filament\Forms\Components\Component;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Lunar\Admin\Filament\Resources\TaxZoneResource as BaseTaxZoneResource;
use Lunar\Models\Country;

class TaxZoneResource extends BaseTaxZoneResource
{
    protected static ?string $permission = null;

    protected static ?string $cluster = null;

    protected static ?string $navigationGroup = 'E-commerce';

    protected static ?int $navigationSort = 16;

    /**
     * Override the broken Lunar method that calls ->first()->id without a null guard.
     * When a tax zone has no country linked yet, ->first() returns null and crashes.
     */
    protected static function getZoneTypeCountryFormComponent(): Component
    {
        return Forms\Components\Select::make('zone_country')
            ->label(__('lunarpanel::taxzone.form.zone_country.label'))
            ->visible(fn ($get) => $get('zone_type') !== 'country')
            ->dehydrated(false)
            ->required()
            ->options(Country::get()->pluck('name', 'id'))
            ->searchable()
            ->afterStateHydrated(static function (Forms\Components\Select $component, ?Model $record): void {
                if ($record) {
                    $record->loadMissing('countries.country');

                    /** @var Collection $relatedModels */
                    $relatedModels = $record->countries;

                    $component->state(
                        $relatedModels
                            ->pluck('country')
                            ->first()?->id,
                    );
                }
            });
    }

    public static function getDefaultPages(): array
    {
        return [
            'index' => Pages\ListTaxZones::route('/'),
            'create' => Pages\CreateTaxZone::route('/create'),
            'edit' => Pages\EditTaxZone::route('/{record}/edit'),
        ];
    }
}
