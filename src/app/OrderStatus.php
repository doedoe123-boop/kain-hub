<?php

namespace App;

enum OrderStatus: string
{
    case Pending = 'pending';
    case Confirmed = 'confirmed';
    case Preparing = 'preparing';
    case Ready = 'ready';
    case Delivered = 'delivered';
    case Cancelled = 'cancelled';

    /**
     * Human-readable label for display.
     */
    public function label(): string
    {
        return match ($this) {
            self::Pending => 'Pending',
            self::Confirmed => 'Confirmed',
            self::Preparing => 'Preparing',
            self::Ready => 'Ready for Pickup',
            self::Delivered => 'Delivered',
            self::Cancelled => 'Cancelled',
        };
    }

    /**
     * Filament-compatible badge color.
     */
    public function color(): string
    {
        return match ($this) {
            self::Pending => 'warning',
            self::Confirmed => 'info',
            self::Preparing => 'primary',
            self::Ready => 'success',
            self::Delivered => 'success',
            self::Cancelled => 'danger',
        };
    }

    /**
     * Statuses that indicate an active (unfulfilled) order.
     *
     * @return list<self>
     */
    public static function active(): array
    {
        return [self::Pending, self::Confirmed, self::Preparing, self::Ready];
    }
}
