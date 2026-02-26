<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Lunar\FieldTypes\Text;
use Lunar\FieldTypes\TranslatedText;
use Lunar\Models\Attribute;
use Lunar\Models\AttributeGroup;
use Lunar\Models\Brand;
use Lunar\Models\Collection;
use Lunar\Models\CollectionGroup;
use Lunar\Models\ProductOption;
use Lunar\Models\ProductOptionValue;
use Lunar\Models\ProductType;
use Lunar\Models\Tag;

/**
 * Seeds global Lunar catalog configuration:
 * product types, attribute groups, attributes, collection groups,
 * collections, brands, product options, and tags.
 *
 * These are platform-wide — not scoped to a specific store.
 */
class LunarCatalogSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $this->seedProductTypes();
        $this->seedCollectionGroups();
        $this->seedBrands();
        $this->seedProductOptions();
        $this->seedTags();
    }

    /**
     * Seed product types with attribute groups and attributes.
     */
    private function seedProductTypes(): void
    {
        // === Attribute Group: Product Details ===
        $detailsGroup = AttributeGroup::firstOrCreate(
            ['handle' => 'product-details'],
            [
                'attributable_type' => 'product',
                'name' => collect(['en' => 'Product Details']),
                'position' => 1,
            ]
        );

        $detailAttributes = [
            [
                'handle' => 'name',
                'name' => collect(['en' => 'Name']),
                'type' => TranslatedText::class,
                'required' => true,
                'system' => true,
                'position' => 1,
                'section' => 'main',
                'searchable' => true,
            ],
            [
                'handle' => 'description',
                'name' => collect(['en' => 'Description']),
                'type' => TranslatedText::class,
                'required' => false,
                'system' => false,
                'position' => 2,
                'section' => 'main',
                'searchable' => true,
            ],
        ];

        foreach ($detailAttributes as $attr) {
            Attribute::firstOrCreate(
                ['handle' => $attr['handle'], 'attribute_type' => 'product'],
                array_merge($attr, [
                    'attribute_group_id' => $detailsGroup->id,
                    'configuration' => collect(),
                    'filterable' => false,
                ])
            );
        }

        // === Attribute Group: Pricing & Availability ===
        $pricingGroup = AttributeGroup::firstOrCreate(
            ['handle' => 'pricing-availability'],
            [
                'attributable_type' => 'product',
                'name' => collect(['en' => 'Pricing & Availability']),
                'position' => 2,
            ]
        );

        $pricingAttributes = [
            [
                'handle' => 'preparation_time',
                'name' => collect(['en' => 'Preparation Time (mins)']),
                'type' => Text::class,
                'required' => false,
                'system' => false,
                'position' => 1,
                'section' => 'main',
                'searchable' => false,
                'filterable' => true,
            ],
            [
                'handle' => 'is_available',
                'name' => collect(['en' => 'Available']),
                'type' => \Lunar\FieldTypes\Toggle::class,
                'required' => false,
                'system' => false,
                'position' => 2,
                'section' => 'main',
                'searchable' => false,
                'filterable' => true,
            ],
        ];

        foreach ($pricingAttributes as $attr) {
            Attribute::firstOrCreate(
                ['handle' => $attr['handle'], 'attribute_type' => 'product'],
                array_merge($attr, [
                    'attribute_group_id' => $pricingGroup->id,
                    'configuration' => collect(),
                ])
            );
        }

        // === Product Types ===
        $productTypes = [
            'Food' => [$detailsGroup, $pricingGroup],
            'Beverage' => [$detailsGroup, $pricingGroup],
            'Combo Meal' => [$detailsGroup, $pricingGroup],
        ];

        foreach ($productTypes as $name => $groups) {
            $type = ProductType::firstOrCreate(['name' => $name]);

            // Map attribute groups → attributes to the product type
            foreach ($groups as $group) {
                $attributes = Attribute::where('attribute_group_id', $group->id)->get();
                $type->mappedAttributes()->syncWithoutDetaching($attributes->pluck('id'));
            }
        }
    }

    /**
     * Seed collection groups and default collections.
     */
    private function seedCollectionGroups(): void
    {
        $groups = [
            'menu-categories' => [
                'name' => 'Menu Categories',
                'collections' => [
                    'Appetizers',
                    'Main Course',
                    'Desserts',
                    'Beverages',
                    'Sides',
                    'Combo Meals',
                ],
            ],
            'dietary' => [
                'name' => 'Dietary',
                'collections' => [
                    'Vegetarian',
                    'Vegan',
                    'Halal',
                    'Gluten-Free',
                ],
            ],
            'featured' => [
                'name' => 'Featured',
                'collections' => [
                    'Best Sellers',
                    'New Arrivals',
                    'Special Offers',
                ],
            ],
        ];

        foreach ($groups as $handle => $data) {
            $group = CollectionGroup::firstOrCreate(
                ['handle' => $handle],
                ['name' => $data['name']]
            );

            foreach ($data['collections'] as $collectionName) {
                $exists = Collection::query()
                    ->where('collection_group_id', $group->id)
                    ->whereJsonContains('attribute_data->name->value->en', $collectionName)
                    ->exists();

                if (! $exists) {
                    Collection::create([
                        'collection_group_id' => $group->id,
                        'sort' => 'custom',
                        'attribute_data' => collect([
                            'name' => new TranslatedText(collect(['en' => $collectionName])),
                        ]),
                    ]);
                }
            }
        }
    }

    /**
     * Seed restaurant-related brands.
     */
    private function seedBrands(): void
    {
        $brands = [
            'House Special',
            'Premium',
            'Classic',
            'Street Food',
            'Local Favorite',
        ];

        foreach ($brands as $brand) {
            Brand::firstOrCreate(['name' => $brand]);
        }
    }

    /**
     * Seed product options (size, spice level, etc.).
     */
    private function seedProductOptions(): void
    {
        $options = [
            'size' => [
                'label' => 'Size',
                'values' => ['Small', 'Medium', 'Large', 'Extra Large'],
            ],
            'spice-level' => [
                'label' => 'Spice Level',
                'values' => ['Mild', 'Medium', 'Hot', 'Extra Hot'],
            ],
            'add-ons' => [
                'label' => 'Add-ons',
                'values' => ['Extra Rice', 'Extra Sauce', 'Extra Cheese', 'Egg'],
            ],
            'sugar-level' => [
                'label' => 'Sugar Level',
                'values' => ['No Sugar', '25%', '50%', '75%', '100%'],
            ],
        ];

        foreach ($options as $handle => $data) {
            $option = ProductOption::firstOrCreate(
                ['handle' => $handle],
                [
                    'name' => ['en' => $data['label']],
                    'label' => ['en' => $data['label']],
                    'shared' => true,
                ]
            );

            foreach ($data['values'] as $position => $valueName) {
                $exists = ProductOptionValue::where('product_option_id', $option->id)
                    ->whereJsonContains('name->en', $valueName)
                    ->exists();

                if (! $exists) {
                    ProductOptionValue::create([
                        'product_option_id' => $option->id,
                        'name' => ['en' => $valueName],
                        'position' => $position + 1,
                    ]);
                }
            }
        }
    }

    /**
     * Seed common tags for food marketplace products.
     */
    private function seedTags(): void
    {
        $tags = [
            'bestseller',
            'new',
            'spicy',
            'vegetarian',
            'vegan',
            'halal',
            'gluten-free',
            'promo',
            'limited-edition',
            'chef-special',
            'family-size',
            'value-meal',
        ];

        foreach ($tags as $tag) {
            Tag::firstOrCreate(['value' => $tag]);
        }
    }
}
