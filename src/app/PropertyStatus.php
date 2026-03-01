<?php

namespace App;

enum PropertyStatus: string
{
    case Draft = 'draft';
    case Active = 'active';
    case UnderOffer = 'under_offer';
    case Sold = 'sold';
    case Rented = 'rented';
    case Archived = 'archived';

    public function label(): string
    {
        return match ($this) {
            self::Draft => 'Draft',
            self::Active => 'Active',
            self::UnderOffer => 'Under Offer',
            self::Sold => 'Sold',
            self::Rented => 'Rented',
            self::Archived => 'Archived',
        };
    }

    public function color(): string
    {
        return match ($this) {
            self::Draft => 'gray',
            self::Active => 'success',
            self::UnderOffer => 'warning',
            self::Sold => 'danger',
            self::Rented => 'info',
            self::Archived => 'gray',
        };
    }
}
