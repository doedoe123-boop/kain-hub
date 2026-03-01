<?php

namespace App;

enum InquiryStatus: string
{
    case New = 'new';
    case Contacted = 'contacted';
    case ViewingScheduled = 'viewing_scheduled';
    case Negotiating = 'negotiating';
    case Closed = 'closed';

    public function label(): string
    {
        return match ($this) {
            self::New => 'New',
            self::Contacted => 'Contacted',
            self::ViewingScheduled => 'Viewing Scheduled',
            self::Negotiating => 'Negotiating',
            self::Closed => 'Closed',
        };
    }

    public function color(): string
    {
        return match ($this) {
            self::New => 'info',
            self::Contacted => 'warning',
            self::ViewingScheduled => 'primary',
            self::Negotiating => 'success',
            self::Closed => 'gray',
        };
    }
}
