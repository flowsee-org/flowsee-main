<?php

namespace Database\Factories;

use App\Models\CaseStudy;
use App\Models\Project;
use Illuminate\Database\Eloquent\Factories\Factory;

class CaseStudyFactory extends Factory
{
    protected $model = CaseStudy::class;

    public function definition(): array
    {
        return [
            'project_id' => Project::factory(),
            'slug' => fake()->unique()->slug(),
            'title' => fake()->words(3, true),
            'lead' => fake()->paragraph(),
            'eyebrow' => fake()->words(2, true),
            'client_name' => fake()->company(),
            'industry' => fake()->words(2, true),
            'services_provided' => fake()->words(2, true),
            'cover_image' => fake()->unique()->numberBetween(1, 99).'.jpg',
            'cover_caption' => fake()->sentence(),
            'meta_title' => fake()->sentence(),
            'meta_description' => fake()->paragraph(),
            'theme_color' => fake()->hexColor(),
            'is_published' => true,
        ];
    }
}
