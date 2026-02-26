<?php

namespace Database\Factories;

use App\Models\User;
use App\IndustrySector;
use App\StoreStatus;
use App\UserRole;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Store>
 */
class StoreFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'user_id' => User::factory()->state(['role' => UserRole::StoreOwner]),
            'name' => fake()->company(),
            'slug' => fake()->unique()->slug(),
            'description' => fake()->sentence(),
            'commission_rate' => 15.00,
            'status' => StoreStatus::Approved,
            'sector' => fake()->randomElement(IndustrySector::cases()),
            'address' => [
                'line_one' => fake()->streetAddress(),
                'city' => fake()->city(),
                'postcode' => fake()->postcode(),
            ],
        ];
    }

    /**
     * Indicate the store is pending approval.
     */
    public function pending(): static
    {
        return $this->state(fn (array $attributes) => [
            'status' => StoreStatus::Pending,
        ]);
    }

    /**
     * Indicate the store is suspended.
     */
    public function suspended(): static
    {
        return $this->state(fn (array $attributes) => [
            'status' => StoreStatus::Suspended,
            'suspended_at' => now(),
            'suspension_reason' => 'Terms violation',
        ]);
    }

    /**
     * Set a specific industry sector for the store.
     */
    public function sector(IndustrySector $sector): static
    {
        return $this->state(fn (array $attributes) => [
            'sector' => $sector,
        ]);
    }
}
