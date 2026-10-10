<?php

namespace Database\Factories;

use App\Models\CaseStudySection;
use App\Models\CaseStudyStep;
use Illuminate\Database\Eloquent\Factories\Factory;

class CaseStudyStepFactory extends Factory
{
    protected $model = CaseStudyStep::class;

    public function definition(): array
    {
        return [
            'section_id' => CaseStudySection::factory(),
            'title' => fake()->words(2, true),
            'description' => fake()->sentence(),
            'step_number' => str_pad((string) fake()->numberBetween(1, 99), 2, '0', STR_PAD_LEFT),
            'sort_order' => fake()->numberBetween(0, 100),
        ];
    }
}
