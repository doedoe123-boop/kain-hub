<?php

namespace App;

enum PhilippineIdType: string
{
    case Passport        = 'passport';
    case DriversLicense  = 'drivers_license';
    case NationalId      = 'national_id';
    case Sss             = 'sss';
    case PhilHealth      = 'philhealth';
    case PostalId        = 'postal_id';

    /**
     * Get the regex pattern for validating the ID number.
     *
     * Patterns are based on official 2025 government ID formats:
     *
     *  Passport      — DFA ePassport (post-2016): 2 letters + 7 digits (e.g. EC1234567)
     *                  Older formats also accepted: 1L+6D, 2L+6D, 1L+7D, 1L+7D+1L
     *
     *  Driver's Lic. — LTO: 1–3 letters + 2 digits + dash + 2 digits + dash + 6 digits
     *                  e.g. N01-12-123456, NO1-12-123456, D00-00-000000
     *
     *  National ID   — PhilSys PCN (on the physical card): 16 digits
     *                  Also accepts the confidential PSN: 12 digits
     *                  Both may be typed with or without dashes.
     *
     *  SSS           — 10 digits in XX-XXXXXXX-X format (permanent lifetime number)
     *
     *  PhilHealth    — 12-digit PIN/CRN, displayed as XX-XXXXXXXXX-X on card
     *                  Also accepts plain 12-digit string (no dashes).
     *
     *  Postal ID     — PHLPost Postal Reference Number (PRN): alphanumeric, variable length
     */
    public function pattern(): string
    {
        return match ($this) {
            // 1–2 letters, 6–7 digits, optional trailing letter
            self::Passport       => '/^[A-Z]{1,2}[0-9]{6,7}[A-Z]?$/i',

            // 1–3 letters, then XX-XX-XXXXXX (LTO 3-2-6 format)
            self::DriversLicense => '/^[A-Z]{1,3}[0-9]{2}-[0-9]{2}-[0-9]{6}$/i',

            // 16-digit PCN (may use dashes every 4: XXXX-XXXX-XXXX-XXXX)
            // or 12-digit PSN (plain digits or dashes)
            self::NationalId     => '/^([0-9]{4}-?){3}[0-9]{4}$|^[0-9]{12}$/',

            // XX-XXXXXXX-X (10 digits with dashes)
            self::Sss            => '/^[0-9]{2}-[0-9]{7}-[0-9]$/',

            // XX-XXXXXXXXX-X (12 digits formatted) OR plain 12 digits
            self::PhilHealth     => '/^[0-9]{2}-[0-9]{9}-[0-9]$|^[0-9]{12}$/',

            // PHLPost PRN: flexible alphanumeric, 6–20 chars
            self::PostalId       => '/^[A-Z0-9]{6,20}$/i',
        };
    }

    /**
     * Get a human-readable format hint for the ID number.
     */
    public function formatHint(): string
    {
        return match ($this) {
            self::Passport       => 'e.g. EC1234567 (2 letters + 7 digits)',
            self::DriversLicense => 'e.g. N01-12-123456 or D00-00-000000',
            self::NationalId     => 'e.g. 1234-5678-9012-3456 (PCN) or 12-digit PSN',
            self::Sss            => 'e.g. 01-2345678-9',
            self::PhilHealth     => 'e.g. 01-234567890-1 or 123456789012',
            self::PostalId       => '6–20 alphanumeric characters (PRN)',
        };
    }

    /**
     * Get the display label for the ID type.
     */
    public function label(): string
    {
        return match ($this) {
            self::Passport       => 'Passport',
            self::DriversLicense => "Driver's License",
            self::NationalId     => 'National ID (PhilSys)',
            self::Sss            => 'SSS ID',
            self::PhilHealth     => 'PhilHealth ID',
            self::PostalId       => 'Postal ID',
        };
    }
}
