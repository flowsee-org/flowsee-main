<?php

use Database\Seeders\MapiAndHadisnaillineCaseStudiesSeeder;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    public function up(): void
    {
        app(MapiAndHadisnaillineCaseStudiesSeeder::class)->run();
    }

    public function down(): void
    {
        // Keep published portfolio records if this migration is rolled back.
    }
};
