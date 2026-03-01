<?php

namespace Database\Factories;

use App\InquiryStatus;
use App\Models\Property;
use App\Models\Store;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\PropertyInquiry>
 */
class PropertyInquiryFactory extends Factory
{
    /**
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'property_id' => Property::factory(),
            'store_id' => fn (array $attributes) => Property::find($attributes['property_id'])?->store_id ?? Store::factory(),
            'user_id' => null,
            'name' => fake()->name(),
            'email' => fake()->safeEmail(),
            'phone' => fake()->optional(0.7)->phoneNumber(),
            'message' => fake()->optional(0.8)->paragraph(),
            'status' => InquiryStatus::New,
            'agent_notes' => null,
            'contacted_at' => null,
            'viewing_date' => null,
            'source' => fake()->randomElement(['website', 'referral', 'walk-in']),
        ];
    }

    public function contacted(): static
    {
        return $this->state(fn (array $attributes) => [
            'status' => InquiryStatus::Contacted,
            'contacted_at' => now()->subDays(fake()->numberBetween(1, 7)),
        ]);
    }

    public function withViewing(): static
    {
        return $this->state(fn (array $attributes) => [
            'status' => InquiryStatus::ViewingScheduled,
            'contacted_at' => now()->subDays(3),
            'viewing_date' => now()->addDays(fake()->numberBetween(1, 14)),
        ]);
    }

    public function closed(): static
    {
        return $this->state(fn (array $attributes) => [
            'status' => InquiryStatus::Closed,
            'contacted_at' => now()->subDays(14),
        ]);
    }
}
