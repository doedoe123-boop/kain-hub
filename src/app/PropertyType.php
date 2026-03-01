<?php

namespace App;

enum PropertyType: string
{
    case House = 'house';
    case Condo = 'condo';
    case Apartment = 'apartment';
    case Townhouse = 'townhouse';
    case Commercial = 'commercial';
    case Lot = 'lot';
    case Warehouse = 'warehouse';
    case Farm = 'farm';

    public function label(): string
    {
        return match ($this) {
            self::House => 'House & Lot',
            self::Condo => 'Condominium',
            self::Apartment => 'Apartment',
            self::Townhouse => 'Townhouse',
            self::Commercial => 'Commercial Space',
            self::Lot => 'Vacant Lot',
            self::Warehouse => 'Warehouse',
            self::Farm => 'Farm / Agricultural',
        };
    }

    public function icon(): string
    {
        return match ($this) {
            self::House => 'heroicon-o-home',
            self::Condo => 'heroicon-o-building-office',
            self::Apartment => 'heroicon-o-building-office-2',
            self::Townhouse => 'heroicon-o-home-modern',
            self::Commercial => 'heroicon-o-building-storefront',
            self::Lot => 'heroicon-o-map',
            self::Warehouse => 'heroicon-o-cube',
            self::Farm => 'heroicon-o-globe-alt',
        };
    }
}
