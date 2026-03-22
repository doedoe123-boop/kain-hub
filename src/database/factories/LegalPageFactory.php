<?php

namespace Database\Factories;

use App\Models\LegalPage;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends Factory<LegalPage>
 */
class LegalPageFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $title = fake()->unique()->words(3, true);

        return [
            'title' => $title,
            'slug' => Str::slug($title),
            'content' => fake()->paragraphs(5, true),
            'type' => fake()->randomElement(['terms', 'privacy', 'store_agreement', 'refund', 'data_privacy', 'acceptable_use']),
            'is_published' => false,
        ];
    }

    public function published(): static
    {
        return $this->state(fn (): array => [
            'is_published' => true,
            'published_at' => now(),
        ]);
    }
}
