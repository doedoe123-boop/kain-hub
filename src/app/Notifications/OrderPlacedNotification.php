<?php

namespace App\Notifications;

use App\Models\Order;
use Filament\Notifications\Notification as FilamentNotification;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Notification;

/**
 * In-app (database) notification sent to the store owner when a new order is
 * placed.
 *
 * The email counterpart is handled separately by the NewOrderReceived mailable.
 * This class only targets the 'database' channel to power the Filament bell
 * icon in the store and realty panels.
 */
class OrderPlacedNotification extends Notification implements ShouldQueue
{
    use Queueable;

    public function __construct(
        public Order $order,
    ) {}

    /**
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['database'];
    }

    /**
     * @return array<string, mixed>
     */
    public function toDatabase(object $notifiable): array
    {
        $total = number_format($this->order->total->value / 100, 2);

        return FilamentNotification::make()
            ->title('New Order Received')
            ->body("Order #{$this->order->reference} — {$this->order->currency_code} {$total}")
            ->icon('heroicon-o-shopping-bag')
            ->iconColor('warning')
            ->getDatabaseMessage();
    }
}
