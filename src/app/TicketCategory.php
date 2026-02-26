<?php

namespace App;

enum TicketCategory: string
{
    case OrderIssue = 'order_issue';
    case PaymentIssue = 'payment_issue';
    case AccountIssue = 'account_issue';
    case StoreIssue = 'store_issue';
    case DeliveryIssue = 'delivery_issue';
    case General = 'general';

    public function label(): string
    {
        return match ($this) {
            self::OrderIssue => 'Order Issue',
            self::PaymentIssue => 'Payment Issue',
            self::AccountIssue => 'Account Issue',
            self::StoreIssue => 'Store Issue',
            self::DeliveryIssue => 'Delivery Issue',
            self::General => 'General Inquiry',
        };
    }
}
