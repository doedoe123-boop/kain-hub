<?php

namespace App;

enum RentalAgreementStatus: string
{
    case Pending = 'pending';
    case Negotiating = 'negotiating';
    case Signed = 'signed';

    public function label(): string
    {
        return match ($this) {
            self::Pending => 'Pending Review',
            self::Negotiating => 'Negotiating',
            self::Signed => 'Signed',
        };
    }

    public function color(): string
    {
        return match ($this) {
            self::Pending => 'gray',
            self::Negotiating => 'warning',
            self::Signed => 'success',
        };
    }

    public function canTenantSign(): bool
    {
        return in_array($this, [self::Pending, self::Negotiating], true);
    }
}
