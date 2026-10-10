<?php

namespace Database\Factories;

use App\Models\CaseStudy;
use App\Models\ColorPalette;
use Illuminate\Database\Eloquent\Factories\Factory;

class ColorPaletteFactory extends Factory
{
    protected $model = ColorPalette::class;

    public function definition(): array
    {
        return [
            'case_study_id' => CaseStudy::factory(),
            'name' => fake()->colorName(),
            'hex' => fake()->hexColor(),
            'sort_order' => fake()->numberBetween(0, 100),
        ];
    }
}
