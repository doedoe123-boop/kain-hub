<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Lunar\Models\Currency;
use Lunar\Models\TaxClass;
use Lunar\Shipping\Models\ShippingMethod;
use Lunar\Shipping\Models\ShippingRate;
use Lunar\Shipping\Models\ShippingZone;

class ShippingSeeder extends Seeder
{
    /**
     * Seed shipping zones, methods with flat rates for the Philippines.
     *
     * Structure:
     *   ShippingZone (Nationwide Philippines)
     *     └─ ShippingMethod: Standard Delivery (flat ₱100)
     *     └─ ShippingMethod: Express Delivery  (flat ₱200)
     *     └─ ShippingMethod: Free Shipping     (₱0, for orders ≥ ₱2,000)
     */
    public function run(): void
    {
        if (ShippingZone::count() > 0) {
            $this->command->info('Shipping data already exists — skipping ShippingSeeder.');

            return;
        }

        $currency = Currency::whereDefault(true)->firstOrFail();
        $taxClass = TaxClass::first();

        // ── Zone ─────────────────────────────────────────────────────────────
        /** @var ShippingZone $zone */
        $zone = ShippingZone::create([
            'name' => 'Nationwide Philippines',
            'type' => 'unrestricted',  // applies to all addresses
        ]);

        // ── Methods & Rates ───────────────────────────────────────────────────
        $methods = [
            [
                'name' => 'Standard Delivery',
                'description' => '3–5 business days',
                'driver' => 'flat-rate',
                'price' => 10000,  // stored in lowest denomination (centavos) → ₱100.00
            ],
            [
                'name' => 'Express Delivery',
                'description' => '1–2 business days',
                'driver' => 'flat-rate',
                'price' => 20000,  // ₱200.00
            ],
            [
                'name' => 'Free Shipping',
                'description' => 'Free for orders ₱2,000 and above',
                'driver' => 'free-shipping',
                'price' => 0,
            ],
        ];

        foreach ($methods as $methodData) {
            /** @var ShippingMethod $method */
            $method = ShippingMethod::create([
                'name' => $methodData['name'],
                'description' => $methodData['description'],
                'driver' => $methodData['driver'],
                'enabled' => true,
                'data' => [],
            ]);

            /** @var ShippingRate $rate */
            $rate = ShippingRate::create([
                'shipping_method_id' => $method->id,
                'shipping_zone_id' => $zone->id,
                'enabled' => true,
            ]);

            // Lunar uses the polymorphic prices table for shipping rate prices.
            $rate->prices()->create([
                'price' => $methodData['price'],
                'compare_price' => 0,
                'currency_id' => $currency->id,
                'customer_group_id' => null,
                'min_quantity' => 1,
            ]);
        }

        $this->command->info('Shipping zones and methods seeded successfully.');
    }
}
