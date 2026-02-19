<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Lunar\Base\Casts\Price;
use Lunar\Models\Order as LunarOrder;

/**
 * Extends Lunar's Order model with marketplace-specific fields.
 *
 * @property ?int $store_id
 * @property int $commission_amount
 * @property int $store_earning
 * @property int $platform_earning
 *
 * @see /skills/commission-calculation.md
 * @see /skills/order-processing.md
 */
class Order extends LunarOrder
{
    /**
     * Additional casts for marketplace columns.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return array_merge(parent::casts(), [
            'commission_amount' => Price::class,
            'store_earning' => Price::class,
            'platform_earning' => Price::class,
        ]);
    }

    /**
     * Return the store relationship.
     */
    public function store(): BelongsTo
    {
        return $this->belongsTo(Store::class);
    }
}
