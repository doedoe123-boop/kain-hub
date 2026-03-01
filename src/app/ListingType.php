<?php

namespace App;

enum ListingType: string
{
    case ForSale = 'for_sale';
    case ForRent = 'for_rent';
    case ForLease = 'for_lease';
    case PreSelling = 'pre_selling';

    public function label(): string
    {
        return match ($this) {
            self::ForSale => 'For Sale',
            self::ForRent => 'For Rent',
            self::ForLease => 'For Lease',
            self::PreSelling => 'Pre-Selling',
        };
    }

    public function color(): string
    {
        return match ($this) {
            self::ForSale => 'success',
            self::ForRent => 'info',
            self::ForLease => 'warning',
            self::PreSelling => 'primary',
        };
    }
}
