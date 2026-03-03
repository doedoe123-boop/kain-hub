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
    case PaymentFailed = 'payment_failed';
    case RefundPending = 'refund_pending';
    case Refunded = 'refunded';

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
            self::PaymentFailed => 'Payment Failed',
            self::RefundPending => 'Refund Pending',
            self::Refunded => 'Refunded',
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
            self::PaymentFailed => 'danger',
            self::RefundPending => 'warning',
            self::Refunded => 'info',
        };
    }

    /**
     * Statuses that indicate an active (unfulfilled) order.
     *
     * Only these statuses permit the order to be cancelled or progressed.
     * Terminal statuses (Delivered, Cancelled, PaymentFailed, Refunded) are excluded.
     *
     * @return list<self>
     */
    public static function active(): array
    {
        return [self::Pending, self::Confirmed, self::Preparing, self::Ready];
    }

    /**
     * Explicit state-machine transition matrix.
     *
     * Returns true when this status is a valid source state for transitioning
     * to $next.  Prevents invalid hops regardless of who triggers them.
     */
    public function canTransitionTo(self $next): bool
    {
        return match ($this) {
            self::Pending => in_array($next, [
                self::Confirmed,
                self::PaymentFailed,
                self::Cancelled,
            ], true),
            self::Confirmed => in_array($next, [
                self::Preparing,
                self::Cancelled,
            ], true),
            self::Preparing => in_array($next, [
                self::Ready,
                self::Cancelled,
            ], true),
            self::Ready => in_array($next, [
                self::Delivered,
                self::Cancelled,
            ], true),
            self::Delivered, self::Cancelled => in_array($next, [
                self::RefundPending,
            ], true),
            self::RefundPending => $next === self::Refunded,
            self::PaymentFailed, self::Refunded => false,
        };
    }
}
