<?php

namespace App\Services;

use App\Models\Order;
use App\Models\Store;

/**
 * Calculates platform commission and store earnings for orders.
 *
 * @see /skills/commission-calculation.md
 */
class CommissionService
{
    /**
     * Calculate commission breakdown for a given order total and store.
     *
     * @return array{commission_amount: int, store_earning: int, platform_earning: int}
     */
    public function calculate(int $orderTotal, Store $store): array
    {
        $commissionRate = (float) $store->commission_rate;
        $commissionAmount = (int) round($orderTotal * ($commissionRate / 100));
        $storeEarning = $orderTotal - $commissionAmount;

        return [
            'commission_amount' => $commissionAmount,
            'store_earning' => $storeEarning,
            'platform_earning' => $commissionAmount,
        ];
    }

    /**
     * Apply commission breakdown to an existing order.
     */
    public function applyToOrder(Order $order): Order
    {
        if (! $order->store) {
            return $order;
        }

        $breakdown = $this->calculate(
            $order->total->value,
            $order->store
        );

        $order->update($breakdown);

        return $order->refresh();
    }
}
