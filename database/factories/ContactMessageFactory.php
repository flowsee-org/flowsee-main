<?php

namespace Database\Factories;

use App\Models\ContactMessage;
use Illuminate\Database\Eloquent\Factories\Factory;

class ContactMessageFactory extends Factory
{
    protected $model = ContactMessage::class;

    public function definition(): array
    {
        return [
            'name' => fake()->name(),
            'phone' => fake()->phoneNumber(),
            'email' => fake()->optional()->safeEmail(),
            'service' => fake()->randomElement(['branding', 'marketing', 'uiux', 'packaging', 'video', 'academy', 'consultation']),
            'details' => fake()->paragraph(),
            'type' => fake()->randomElement(['project', 'consultation']),
            'ip_address' => fake()->ipv4(),
        ];
    }
}
