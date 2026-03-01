<?php

namespace Database\Factories;

use App\Models\OpenHouse;
use App\Models\OpenHouseRsvp;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<OpenHouseRsvp>
 */
class OpenHouseRsvpFactory extends Factory
{
    protected $model = OpenHouseRsvp::class;

    public function definition(): array
    {
        return [
            'open_house_id' => OpenHouse::factory(),
            'name' => fake()->name(),
            'email' => fake()->safeEmail(),
            'phone' => fake()->optional(0.8)->phoneNumber(),
            'notes' => fake()->optional(0.3)->sentence(),
            'status' => 'confirmed',
        ];
    }

    public function cancelled(): static
    {
        return $this->state(fn () => ['status' => 'cancelled']);
    }

    public function attended(): static
    {
        return $this->state(fn () => ['status' => 'attended']);
    }

    public function noShow(): static
    {
        return $this->state(fn () => ['status' => 'no_show']);
    }
}
