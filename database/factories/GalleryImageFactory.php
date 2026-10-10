<?php

namespace Database\Factories;

use App\Models\CaseStudySection;
use App\Models\GalleryImage;
use Illuminate\Database\Eloquent\Factories\Factory;

class GalleryImageFactory extends Factory
{
    protected $model = GalleryImage::class;

    public function definition(): array
    {
        return [
            'section_id' => CaseStudySection::factory(),
            'path' => fake()->unique()->numberBetween(1, 99).'.jpg',
            'caption' => fake()->sentence(),
            'alt' => fake()->sentence(),
            'width' => 1920,
            'height' => 1080,
            'layout' => fake()->randomElement(['full', 'half', 'third']),
            'sort_order' => fake()->numberBetween(0, 100),
        ];
    }
}
