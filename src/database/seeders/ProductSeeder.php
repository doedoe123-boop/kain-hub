<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Lunar\FieldTypes\Number;
use Lunar\FieldTypes\TranslatedText;
use Lunar\Models\Attribute;
use Lunar\Models\AttributeGroup;
use Lunar\Models\Channel;
use Lunar\Models\Currency;
use Lunar\Models\CustomerGroup;
use Lunar\Models\Product;
use Lunar\Models\ProductType;
use Lunar\Models\ProductVariant;
use Lunar\Models\TaxClass;

/**
 * Seeds Lunar e-commerce products for store_id = 9.
 *
 * Depends on: LunarSeeder (channel, currency, tax class, customer group)
 * and LunarCatalogSeeder (attribute groups).
 *
 * Products are linked to their store via `attribute_data->store_id`, which is
 * how ScopedProductResource and OrderService query them:
 *   ->whereJsonContains('attribute_data->store_id', $store->id)
 */
class ProductSeeder extends Seeder
{
    private const STORE_ID = 9;

    private Channel $channel;

    private Currency $currency;

    private TaxClass $taxClass;

    private CustomerGroup $customerGroup;

    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Guard: only seed if this store has no products yet.
        if (Product::whereJsonContains('attribute_data->store_id->value', self::STORE_ID)->exists()) {
            $this->command->getOutput()->writeln(
                '<comment>ProductSeeder: store_id='.self::STORE_ID.' already has products — skipping.</comment>'
            );

            return;
        }

        $this->channel = Channel::whereDefault(true)->firstOrFail();
        $this->currency = Currency::whereDefault(true)->firstOrFail();
        $this->taxClass = TaxClass::first() ?? throw new \RuntimeException('No TaxClass found. Run LunarSeeder first.');
        $this->customerGroup = CustomerGroup::whereDefault(true)->firstOrFail();

        $this->ensureProductTypes();

        foreach ($this->catalog() as $item) {
            $this->createProduct($item);
        }
    }

    // ── Product catalog ────────────────────────────────────────────────────────

    /**
     * Product definitions for the e-commerce store.
     *
     * `price` and `compare_price` are in the smallest currency unit
     * (e.g. centavos for PHP, cents for USD — matches the Lunar prices table).
     *
     * @return list<array{
     *     name: string,
     *     description: string,
     *     type: string,
     *     sku: string,
     *     price: int,
     *     compare_price: int|null,
     *     stock: int,
     * }>
     */
    private function catalog(): array
    {
        return [
            // === Electronics ===
            [
                'name' => 'Wireless Bluetooth Earbuds',
                'description' => 'True wireless stereo earbuds with active noise cancellation, 24-hour battery life, and IPX5 water resistance. Compatible with all Bluetooth 5.0 devices.',
                'type' => 'Electronics',
                'sku' => 'ELEC-001',
                'price' => 249900,        // PHP 2,499.00
                'compare_price' => 349900,
                'stock' => 80,
            ],
            [
                'name' => 'Portable Powerbank 20000mAh',
                'description' => 'Ultra-capacity power bank with dual USB-A and USB-C output. Fast-charge support. Keeps your phone topped up for days away from the socket.',
                'type' => 'Electronics',
                'sku' => 'ELEC-002',
                'price' => 129900,
                'compare_price' => 159900,
                'stock' => 120,
            ],
            [
                'name' => 'USB-C Mechanical Keyboard',
                'description' => 'Compact tenkeyless mechanical keyboard with tactile blue switches, per-key RGB, and a hot-swappable PCB. Ships with a braided USB-C cable.',
                'type' => 'Electronics',
                'sku' => 'ELEC-003',
                'price' => 399900,
                'compare_price' => null,
                'stock' => 45,
            ],
            [
                'name' => 'HD Webcam 1080p with Built-in Mic',
                'description' => 'Plug-and-play 1080p webcam with auto-focus, low-light correction, and a dual omnidirectional microphone. Works on Windows, macOS, and Linux.',
                'type' => 'Electronics',
                'sku' => 'ELEC-004',
                'price' => 179900,
                'compare_price' => 229900,
                'stock' => 65,
            ],

            // === Clothing ===
            [
                'name' => 'Premium Cotton Polo Shirt',
                'description' => 'Classic-fit polo in 100% combed ring-spun cotton. Breathable, durable, and machine-washable. Available in 8 solid colours.',
                'type' => 'Clothing',
                'sku' => 'CLTH-001',
                'price' => 79900,
                'compare_price' => 99900,
                'stock' => 200,
            ],
            [
                'name' => 'Slim-Fit Chino Pants',
                'description' => 'Versatile slim-fit chinos in a cotton-elastane blend for all-day comfort. Suits casual and smart-casual occasions.',
                'type' => 'Clothing',
                'sku' => 'CLTH-002',
                'price' => 149900,
                'compare_price' => null,
                'stock' => 150,
            ],
            [
                'name' => 'Lightweight Running Shoes',
                'description' => 'Engineered mesh upper with a cushioned EVA midsole and rubber outsole for grip. Ideal for road running and gym workouts.',
                'type' => 'Clothing',
                'sku' => 'CLTH-003',
                'price' => 289900,
                'compare_price' => 359900,
                'stock' => 100,
            ],

            // === Home & Living ===
            [
                'name' => 'Stainless Steel Insulated Tumbler 500ml',
                'description' => 'Double-wall vacuum-insulated tumbler. Keeps drinks cold 24 hr or hot 12 hr. BPA-free lid, sweat-free exterior.',
                'type' => 'Home & Living',
                'sku' => 'HOME-001',
                'price' => 89900,
                'compare_price' => 109900,
                'stock' => 300,
            ],
            [
                'name' => 'Minimalist Bamboo Desk Organizer',
                'description' => 'Handcrafted bamboo organizer with 6 compartments for pens, cards, and accessories. Natural finish; anti-scratch silicone base pads.',
                'type' => 'Home & Living',
                'sku' => 'HOME-002',
                'price' => 59900,
                'compare_price' => null,
                'stock' => 90,
            ],
            [
                'name' => 'Non-Stick Ceramic Frying Pan Set (3 pcs)',
                'description' => 'PFOA-free ceramic-coated pans in 20 cm, 24 cm, and 28 cm. Compatible with gas, electric, and induction hobs. Dishwasher-safe.',
                'type' => 'Home & Living',
                'sku' => 'HOME-003',
                'price' => 249900,
                'compare_price' => 319900,
                'stock' => 60,
            ],
        ];
    }

    // ── Helpers ────────────────────────────────────────────────────────────────

    /**
     * Create one Lunar product with a default variant and a base price.
     *
     * @param array{
     *     name: string,
     *     description: string,
     *     type: string,
     *     sku: string,
     *     price: int,
     *     compare_price: int|null,
     *     stock: int
     * } $data
     */
    private function createProduct(array $data): void
    {
        $productType = ProductType::where('name', $data['type'])->firstOrFail();

        $product = Product::create([
            'product_type_id' => $productType->id,
            'status' => 'published',
            'attribute_data' => collect([
                'name' => new TranslatedText(collect(['en' => $data['name']])),
                'description' => new TranslatedText(collect(['en' => $data['description']])),
                // Wrapped in Number so AsAttributeData cast can serialise it.
                // Queried via whereJsonContains('attribute_data->store_id->value', $storeId).
                'store_id' => new Number(self::STORE_ID),
            ]),
        ]);

        // Enable the product on the default channel.
        $product->channels()->sync([
            $this->channel->id => [
                'enabled' => true,
                'starts_at' => now(),
                'ends_at' => null,
            ],
        ]);

        // Make it visible and purchasable for the default customer group.
        $product->customerGroups()->sync([
            $this->customerGroup->id => [
                'enabled' => true,
                'visible' => true,
                'purchasable' => true,
                'starts_at' => null,
                'ends_at' => null,
            ],
        ]);

        // One default variant (no size/colour options — simple product).
        $variant = ProductVariant::create([
            'product_id' => $product->id,
            'tax_class_id' => $this->taxClass->id,
            'sku' => $data['sku'],
            'stock' => $data['stock'],
            'purchasable' => 'always',
            'shippable' => true,
            'unit_quantity' => 1,
            'backorder' => 0,
        ]);

        // Base price — null customer_group_id means it applies to all groups.
        $variant->prices()->create([
            'customer_group_id' => null,
            'currency_id' => $this->currency->id,
            'price' => $data['price'],
            'compare_price' => $data['compare_price'],
            'min_quantity' => 1,
        ]);
    }

    /**
     * Ensure the product types used by this seeder exist, and map the standard
     * Lunar attribute groups to them (created by LunarCatalogSeeder).
     */
    private function ensureProductTypes(): void
    {
        $detailsGroup = AttributeGroup::where('handle', 'product-details')
            ->where('attributable_type', 'product')
            ->first();

        $pricingGroup = AttributeGroup::where('handle', 'pricing-availability')
            ->where('attributable_type', 'product')
            ->first();

        foreach (['Electronics', 'Clothing', 'Home & Living'] as $typeName) {
            $type = ProductType::firstOrCreate(['name' => $typeName]);

            foreach (array_filter([$detailsGroup, $pricingGroup]) as $group) {
                $attrs = Attribute::where('attribute_group_id', $group->id)
                    ->where('attribute_type', 'product')
                    ->get();

                $type->mappedAttributes()->syncWithoutDetaching($attrs->pluck('id'));
            }
        }
    }
}
