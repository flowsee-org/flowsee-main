<?php

namespace Database\Factories;

use App\Models\CaseStudy;
use App\Models\CaseStudySection;
use Illuminate\Database\Eloquent\Factories\Factory;

class CaseStudySectionFactory extends Factory
{
    protected $model = CaseStudySection::class;

    public function definition(): array
    {
        return [
            'case_study_id' => CaseStudy::factory(),
            'slug' => fake()->unique()->slug(),
            'title' => fake()->words(3, true),
            'lead' => fake()->paragraph(),
            'eyebrow' => fake()->words(2, true),
            'index_label' => str_pad((string) fake()->numberBetween(0, 99), 2, '0', STR_PAD_LEFT),
            'band_image' => fake()->unique()->numberBetween(1, 99).'.jpg',
            'band_caption' => fake()->sentence(),
            'sort_order' => fake()->numberBetween(0, 100),
        ];
    }
}
