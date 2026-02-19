<?php

namespace Database\Factories;

use App\Models\Store;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Payout>
 */
class PayoutFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $start = fake()->dateTimeBetween('-3 months', '-1 month');

        return [
            'store_id' => Store::factory(),
            'amount' => fake()->randomFloat(2, 100, 10000),
            'period_start' => $start,
            'period_end' => fake()->dateTimeBetween($start, 'now'),
            'status' => fake()->randomElement(['pending', 'paid']),
            'reference' => 'PAY-'.fake()->unique()->numerify('######'),
        ];
    }

    /**
     * Indicate the payout has been paid.
     */
    public function paid(): static
    {
        return $this->state(fn (array $attributes) => [
            'status' => 'paid',
        ]);
    }
}
