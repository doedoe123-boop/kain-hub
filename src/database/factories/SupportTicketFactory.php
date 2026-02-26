<?php

namespace Database\Factories;

use App\Models\User;
use App\TicketCategory;
use App\TicketPriority;
use App\TicketStatus;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\SupportTicket>
 */
class SupportTicketFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'user_id' => User::factory(),
            'subject' => fake()->sentence(6),
            'message' => fake()->paragraphs(2, true),
            'category' => fake()->randomElement(TicketCategory::cases()),
            'priority' => TicketPriority::Medium,
            'status' => TicketStatus::Open,
        ];
    }

    public function urgent(): static
    {
        return $this->state(fn (): array => [
            'priority' => TicketPriority::Urgent,
        ]);
    }

    public function resolved(): static
    {
        return $this->state(fn (): array => [
            'status' => TicketStatus::Resolved,
            'resolved_at' => now(),
            'admin_notes' => fake()->sentence(),
        ]);
    }

    public function closed(): static
    {
        return $this->state(fn (): array => [
            'status' => TicketStatus::Closed,
            'resolved_at' => now()->subDay(),
        ]);
    }

    public function inProgress(): static
    {
        return $this->state(fn (): array => [
            'status' => TicketStatus::InProgress,
        ]);
    }
}
