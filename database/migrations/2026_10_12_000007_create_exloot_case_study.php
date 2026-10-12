<?php

use Database\Seeders\ExlootCaseStudySeeder;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    public function up(): void
    {
        app(ExlootCaseStudySeeder::class)->run();
    }

    public function down(): void
    {
        // Preserve published case-study content if a release is rolled back.
    }
};
