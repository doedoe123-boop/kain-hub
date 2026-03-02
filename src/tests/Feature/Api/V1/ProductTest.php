<?php

use App\Models\Store;
use Database\Seeders\LunarSeeder;
use Lunar\FieldTypes\Number;
use Lunar\FieldTypes\Text;
use Lunar\Models\Product;
use Lunar\Models\ProductType;

// ─── Test helper ─────────────────────────────────────────────────────────────

// Lunar requires a default Language (+ Channel, Currency) to exist before
// creating Products — UrlGenerator throws if Language::getDefault() is null.
beforeEach(fn () => (new LunarSeeder)->run());

/**
 * Create a minimal Lunar Product linked to a store.
 */
function createProduct(int $storeId, string $name = 'Test Product', string $status = 'published'): Product
{
    $type = ProductType::query()->firstOrCreate(['name' => 'Test Type']);

    return Product::query()->create([
        'product_type_id' => $type->id,
        'status' => $status,
        'attribute_data' => [
            'name' => new Text($name),
            'store_id' => new Number($storeId),
        ],
    ]);
}

// ─── Product index ────────────────────────────────────────────────────────────

it('returns a paginated list of published products', function () {
    $store = Store::factory()->create();

    createProduct($store->id, 'Widget A');
    createProduct($store->id, 'Widget B');

    $this->getJson(route('api.v1.products.index'))
        ->assertOk()
        ->assertJsonStructure(['data', 'current_page', 'total'])
        ->assertJsonCount(2, 'data');
});

it('excludes draft products from the index', function () {
    $store = Store::factory()->create();

    createProduct($store->id, 'Published Product');
    createProduct($store->id, 'Draft Product', 'draft');

    $this->getJson(route('api.v1.products.index'))
        ->assertOk()
        ->assertJsonCount(1, 'data');
});

it('returns product fields in the list response', function () {
    $store = Store::factory()->create();

    createProduct($store->id, 'Fancy Widget');

    $this->getJson(route('api.v1.products.index'))
        ->assertOk()
        ->assertJsonPath('data.0.name', 'Fancy Widget')
        ->assertJsonStructure(['data' => [['id', 'name', 'description', 'thumbnail', 'store_id', 'default_variant_id', 'price', 'currency']]]);
});

it('filters products by search term', function () {
    $store = Store::factory()->create();

    createProduct($store->id, 'Wireless Mouse');
    createProduct($store->id, 'Mechanical Keyboard');

    $this->getJson(route('api.v1.products.index', ['search' => 'wireless']))
        ->assertOk()
        ->assertJsonCount(1, 'data')
        ->assertJsonPath('data.0.name', 'Wireless Mouse');
});

it('does not require authentication to browse products', function () {
    $store = Store::factory()->create();
    createProduct($store->id);

    $this->getJson(route('api.v1.products.index'))->assertOk();
});

// ─── Product show ─────────────────────────────────────────────────────────────

it('returns a single published product with variants', function () {
    $store = Store::factory()->create();
    $product = createProduct($store->id, 'Premium Headphones');

    $this->getJson(route('api.v1.products.show', $product->id))
        ->assertOk()
        ->assertJsonPath('id', $product->id)
        ->assertJsonPath('name', 'Premium Headphones')
        ->assertJsonStructure(['id', 'name', 'description', 'thumbnail', 'store_id', 'variants']);
});

it('returns 404 for a non-existent product', function () {
    $this->getJson(route('api.v1.products.show', 99999))
        ->assertNotFound();
});

it('returns 404 for a draft product via show', function () {
    $store = Store::factory()->create();
    $product = createProduct($store->id, 'Hidden Draft', 'draft');

    $this->getJson(route('api.v1.products.show', $product->id))
        ->assertNotFound();
});

// ─── Store-scoped products ────────────────────────────────────────────────────

it('returns products scoped to a specific approved store', function () {
    $storeA = Store::factory()->create();
    $storeB = Store::factory()->create();

    createProduct($storeA->id, 'Store A Product 1');
    createProduct($storeA->id, 'Store A Product 2');
    createProduct($storeB->id, 'Store B Product');

    $this->getJson(route('api.v1.products.store', $storeA))
        ->assertOk()
        ->assertJsonCount(2, 'data');
});

it('returns 404 for store products when store is pending', function () {
    $store = Store::factory()->pending()->create();

    $this->getJson(route('api.v1.products.store', $store))
        ->assertNotFound();
});

it('returns 404 for store products when store is suspended', function () {
    $store = Store::factory()->suspended()->create();

    $this->getJson(route('api.v1.products.store', $store))
        ->assertNotFound();
});

it('supports per_page on store products', function () {
    $store = Store::factory()->create();

    foreach (range(1, 5) as $i) {
        createProduct($store->id, "Product {$i}");
    }

    $this->getJson(route('api.v1.products.store', [$store, 'per_page' => 3]))
        ->assertOk()
        ->assertJsonPath('per_page', 3)
        ->assertJsonCount(3, 'data');
});
