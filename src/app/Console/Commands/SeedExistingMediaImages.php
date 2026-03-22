<?php

namespace App\Console\Commands;

use App\Models\Property;
use App\PropertyType;
use App\Support\MediaSeederHelper;
use Illuminate\Console\Command;
use Lunar\Models\Product;

/**
 * Attaches sample Unsplash images to existing products and properties
 * that currently have no media records.
 *
 * Safe to run multiple times — skips records that already have media.
 */
class SeedExistingMediaImages extends Command
{
    protected $signature = 'media:seed-images
                            {--products : Only seed product images}
                            {--properties : Only seed property images}';

    protected $description = 'Attach sample images to existing products/properties that have no media';

    public function handle(): int
    {
        $seedProducts = ! $this->option('properties');
        $seedProperties = ! $this->option('products');

        if ($seedProducts) {
            $this->seedProducts();
        }

        if ($seedProperties) {
            $this->seedProperties();
        }

        return self::SUCCESS;
    }

    private function seedProducts(): void
    {
        $products = Product::query()->doesntHave('media')->with('attribute_data')->get();

        if ($products->isEmpty()) {
            $this->info('Products: all records already have media — skipping.');

            return;
        }

        $this->info("Products: attaching images to {$products->count()} records...");
        $bar = $this->output->createProgressBar($products->count());
        $bar->start();

        foreach ($products as $product) {
            $typeName = $product->attribute_data->get('product_type')?->getValue()
                ?? $product->translateAttribute('name');
            $keyword = MediaSeederHelper::keywordForProductType((string) $typeName);
            MediaSeederHelper::attachImages($product, $keyword, 'images', 3);
            $bar->advance();
        }

        $bar->finish();
        $this->newLine();
        $this->info("Products: done — {$products->count()} records updated.");
    }

    private function seedProperties(): void
    {
        $properties = Property::query()->doesntHave('media')->get();

        if ($properties->isEmpty()) {
            $this->info('Properties: all records already have media — skipping.');

            return;
        }

        $this->info("Properties: attaching images to {$properties->count()} records...");
        $bar = $this->output->createProgressBar($properties->count());
        $bar->start();

        foreach ($properties as $property) {
            $keyword = MediaSeederHelper::keywordForPropertyType(
                $property->property_type instanceof PropertyType
                    ? $property->property_type->value
                    : (string) $property->property_type
            );
            MediaSeederHelper::attachImages($property, $keyword, 'images', 4);
            $bar->advance();
        }

        $bar->finish();
        $this->newLine();
        $this->info("Properties: done — {$properties->count()} records updated.");
    }
}
