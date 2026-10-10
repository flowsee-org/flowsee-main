<?php

namespace Database\Factories;

use App\Models\Lead;
use Illuminate\Database\Eloquent\Factories\Factory;

class LeadFactory extends Factory
{
    protected $model = Lead::class;

    public function definition(): array
    {
        return [
            'name' => fake()->name(),
            'phone' => '09'.fake()->numerify('#########'),
            'email' => fake()->optional()->safeEmail(),
            'service' => fake()->randomElement(['branding', 'marketing', 'uiux', 'packaging', 'video', 'academy', 'consultation']),
            'details' => fake()->paragraph(),
            'ip_address' => fake()->ipv4(),
            'user_agent' => fake()->userAgent(),
            'is_read' => false,
        ];
    }
}
