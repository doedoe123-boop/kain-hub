<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Announcement>
 */
class AnnouncementFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'title' => fake()->sentence(5),
            'content' => fake()->paragraphs(3, true),
            'type' => 'info',
            'audience' => 'all',
            'is_active' => true,
            'published_at' => now(),
            'created_by' => User::factory(),
        ];
    }

    public function maintenance(): static
    {
        return $this->state(fn (): array => [
            'type' => 'maintenance',
            'title' => 'Scheduled Maintenance',
        ]);
    }

    public function warning(): static
    {
        return $this->state(fn (): array => [
            'type' => 'warning',
        ]);
    }

    public function expired(): static
    {
        return $this->state(fn (): array => [
            'expires_at' => now()->subDay(),
        ]);
    }

    public function inactive(): static
    {
        return $this->state(fn (): array => [
            'is_active' => false,
        ]);
    }

    public function forStoreOwners(): static
    {
        return $this->state(fn (): array => [
            'audience' => 'store_owners',
        ]);
    }

    public function forCustomers(): static
    {
        return $this->state(fn (): array => [
            'audience' => 'customers',
        ]);
    }
}
