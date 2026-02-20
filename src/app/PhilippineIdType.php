<?php

namespace App;

enum PhilippineIdType: string
{
    case Passport = 'passport';
    case DriversLicense = 'drivers_license';
    case NationalId = 'national_id';
    case Sss = 'sss';
    case PhilHealth = 'philhealth';
    case PostalId = 'postal_id';

    /**
     * Get the regex pattern for validating the ID number.
     */
    public function pattern(): string
    {
        return match ($this) {
            self::Passport => '/^[A-Z]{1}[0-9]{7}[A-Z]?$/i',
            self::DriversLicense => '/^[A-Z]{1}[0-9]{2}-[0-9]{2}-[0-9]{6}$/i',
            self::NationalId => '/^[0-9]{4}-[0-9]{4}-[0-9]{4}-[0-9]{4}$/i',
            self::Sss => '/^[0-9]{2}-[0-9]{7}-[0-9]{1}$/',
            self::PhilHealth => '/^[0-9]{2}-[0-9]{9}-[0-9]{1}$/',
            self::PostalId => '/^[A-Z0-9]{6,20}$/i',
        };
    }

    /**
     * Get a human-readable format hint for the ID number.
     */
    public function formatHint(): string
    {
        return match ($this) {
            self::Passport => 'e.g. P1234567 or P1234567A',
            self::DriversLicense => 'e.g. N01-12-123456',
            self::NationalId => 'e.g. 1234-5678-9012-3456',
            self::Sss => 'e.g. 01-2345678-9',
            self::PhilHealth => 'e.g. 01-234567890-1',
            self::PostalId => '6–20 alphanumeric characters',
        };
    }

    /**
     * Get the display label for the ID type.
     */
    public function label(): string
    {
        return match ($this) {
            self::Passport => 'Passport',
            self::DriversLicense => "Driver's License",
            self::NationalId => 'National ID (PhilSys)',
            self::Sss => 'SSS ID',
            self::PhilHealth => 'PhilHealth ID',
            self::PostalId => 'Postal ID',
        };
    }
}
