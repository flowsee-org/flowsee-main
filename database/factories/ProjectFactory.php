<?php

namespace Database\Factories;

use App\Models\Project;
use Illuminate\Database\Eloquent\Factories\Factory;

class ProjectFactory extends Factory
{
    protected $model = Project::class;

    public function definition(): array
    {
        return [
            'slug' => fake()->unique()->slug(),
            'name' => fake()->words(2, true),
            'description' => fake()->paragraph(),
            'cover_image' => fake()->unique()->numberBetween(1, 99).'.jpg',
            'asset_id' => 'asset_'.fake()->unique()->numberBetween(1, 9999),
            'is_featured' => fake()->boolean(10),
            'has_case_study' => false,
            'sort_order' => fake()->numberBetween(0, 100),
            'is_active' => true,
        ];
    }
}
