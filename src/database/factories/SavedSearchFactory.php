<?php

namespace Database\Factories;

use App\Models\SavedSearch;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<SavedSearch>
 */
class SavedSearchFactory extends Factory
{
    protected $model = SavedSearch::class;

    /** @var list<string> */
    private array $names = [
        'Budget Condos in Makati',
        'Family Homes in Cebu',
        'Luxury Lots in Tagaytay',
        'Affordable Rentals Near BGC',
        'Warehouse Space in Laguna',
        'Beachfront Properties',
        'Commercial Space in Ortigas',
        'Farm Lot in Batangas',
    ];

    /** @var list<string> */
    private array $cities = [
        'Makati', 'Taguig', 'Cebu City', 'Quezon City', 'Pasig',
        'Davao City', 'Tagaytay', 'Baguio', 'Manila', 'Iloilo City',
    ];

    public function definition(): array
    {
        return [
            'user_id' => User::factory(),
            'name' => fake()->randomElement($this->names),
            'criteria' => [
                'property_type' => fake()->optional(0.7)->randomElement(['condo', 'house', 'lot', 'townhouse']),
                'listing_type' => fake()->optional(0.8)->randomElement(['for_sale', 'for_rent']),
                'min_price' => fake()->optional(0.6)->numberBetween(500000, 5000000),
                'max_price' => fake()->optional(0.6)->numberBetween(5000000, 50000000),
                'bedrooms' => fake()->optional(0.5)->numberBetween(1, 5),
                'city' => fake()->optional(0.7)->randomElement($this->cities),
            ],
            'notify_frequency' => fake()->randomElement(['instant', 'daily', 'weekly', 'none']),
            'last_notified_at' => fake()->optional(0.4)->dateTimeBetween('-30 days', 'now'),
            'is_active' => fake()->boolean(80),
        ];
    }

    public function active(): static
    {
        return $this->state(fn () => ['is_active' => true]);
    }

    public function inactive(): static
    {
        return $this->state(fn () => ['is_active' => false]);
    }
}
