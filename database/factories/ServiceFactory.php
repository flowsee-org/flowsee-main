<?php

namespace Database\Factories;

use App\Models\Service;
use Illuminate\Database\Eloquent\Factories\Factory;

class ServiceFactory extends Factory
{
    protected $model = Service::class;

    public function definition(): array
    {
        return [
            'slug' => fake()->unique()->slug(),
            'title' => fake()->words(2, true),
            'description' => fake()->sentence(),
            'icon' => 'icon_'.fake()->unique()->numberBetween(1, 9999),
            'sort_order' => fake()->numberBetween(0, 100),
            'is_highlighted' => fake()->boolean(20),
            'is_active' => true,
        ];
    }
}
