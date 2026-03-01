<?php

namespace Database\Factories;

use App\ListingType;
use App\Models\Store;
use App\PropertyStatus;
use App\PropertyType;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Property>
 */
class PropertyFactory extends Factory
{
    /**
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $title = fake()->randomElement([
            'Modern 3BR House in '.fake()->city(),
            'Spacious Condo Unit at '.fake()->company().' Tower',
            'Prime Commercial Lot in '.fake()->city(),
            'Luxury Townhouse with Pool',
            'Affordable Studio Apartment',
            'Farm Lot in '.fake()->city(),
            'Warehouse Space for Lease',
            'Brand New 4BR House & Lot',
        ]);

        $propertyType = fake()->randomElement(PropertyType::cases());
        $listingType = fake()->randomElement(ListingType::cases());

        return [
            'store_id' => Store::factory(),
            'title' => $title,
            'slug' => Str::slug($title).'-'.Str::random(6),
            'description' => fake()->paragraphs(2, true),
            'property_type' => $propertyType,
            'listing_type' => $listingType,
            'status' => PropertyStatus::Active,
            'price' => fake()->randomFloat(2, 500_000, 50_000_000),
            'price_currency' => 'PHP',
            'price_period' => $listingType === ListingType::ForRent ? 'per_month' : null,
            'bedrooms' => in_array($propertyType, [PropertyType::Lot, PropertyType::Warehouse, PropertyType::Commercial]) ? null : fake()->numberBetween(1, 6),
            'bathrooms' => in_array($propertyType, [PropertyType::Lot, PropertyType::Warehouse, PropertyType::Commercial]) ? null : fake()->numberBetween(1, 4),
            'garage_spaces' => fake()->optional(0.6)->numberBetween(1, 3),
            'floor_area' => fake()->optional(0.8)->randomFloat(2, 30, 500),
            'lot_area' => fake()->optional(0.7)->randomFloat(2, 50, 2000),
            'year_built' => fake()->optional(0.5)->numberBetween(2000, 2026),
            'floors' => fake()->optional(0.4)->numberBetween(1, 5),
            'address_line' => fake()->streetAddress(),
            'barangay' => 'Brgy. '.fake()->word(),
            'city' => fake()->randomElement(['Makati', 'Quezon City', 'Cebu City', 'Davao City', 'Manila', 'Taguig', 'Pasig']),
            'province' => fake()->randomElement(['Metro Manila', 'Cebu', 'Davao del Sur', 'Pampanga', 'Cavite', 'Laguna']),
            'zip_code' => fake()->numerify('####'),
            'latitude' => fake()->optional(0.3)->latitude(7, 18),
            'longitude' => fake()->optional(0.3)->longitude(117, 127),
            'features' => fake()->randomElements(
                ['Swimming Pool', 'Gated Community', 'Corner Lot', 'Near School', 'Near Mall', 'Parking', 'Garden', 'Balcony', 'CCTV', 'Elevator', 'Gym', 'Clubhouse', 'Pet Friendly', 'Furnished', 'Near MRT/LRT'],
                fake()->numberBetween(2, 6)
            ),
            'images' => null,
            'video_url' => null,
            'virtual_tour_url' => null,
            'is_featured' => fake()->boolean(20),
            'published_at' => now()->subDays(fake()->numberBetween(1, 90)),
            'views_count' => fake()->numberBetween(0, 5000),
        ];
    }

    public function draft(): static
    {
        return $this->state(fn (array $attributes) => [
            'status' => PropertyStatus::Draft,
            'published_at' => null,
        ]);
    }

    public function sold(): static
    {
        return $this->state(fn (array $attributes) => [
            'status' => PropertyStatus::Sold,
        ]);
    }

    public function underOffer(): static
    {
        return $this->state(fn (array $attributes) => [
            'status' => PropertyStatus::UnderOffer,
        ]);
    }

    public function featured(): static
    {
        return $this->state(fn (array $attributes) => [
            'is_featured' => true,
            'status' => PropertyStatus::Active,
        ]);
    }

    public function forRent(): static
    {
        return $this->state(fn (array $attributes) => [
            'listing_type' => ListingType::ForRent,
            'price' => fake()->randomFloat(2, 8_000, 150_000),
            'price_period' => 'per_month',
        ]);
    }

    public function forSale(): static
    {
        return $this->state(fn (array $attributes) => [
            'listing_type' => ListingType::ForSale,
            'price_period' => null,
        ]);
    }
}
