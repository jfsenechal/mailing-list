<?php

declare(strict_types=1);

namespace Database\Factories;

use App\Enums\EmailStatus;
use App\Models\Email;
use App\Models\Sender;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Email>
 */
final class EmailFactory extends Factory
{
    /**
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'username' => fake()->userName(),
            'sender_id' => Sender::factory(),
            'subject' => fake()->sentence(),
            'body' => fake()->paragraphs(3, true),
            'attachments' => null,
            'status' => EmailStatus::Draft,
            'unsubscribe_enabled' => true,
        ];
    }

    public function withoutUnsubscribe(): static
    {
        return $this->state(fn (): array => [
            'unsubscribe_enabled' => false,
        ]);
    }

    public function sent(): static
    {
        return $this->state(fn (): array => [
            'status' => EmailStatus::Sent,
        ]);
    }

    public function sending(): static
    {
        return $this->state(fn (): array => [
            'status' => EmailStatus::Sending,
        ]);
    }
}
