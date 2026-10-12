<?php

use Database\Seeders\ImaMoviesCaseStudySeeder;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    public function up(): void
    {
        app(ImaMoviesCaseStudySeeder::class)->run();
    }

    public function down(): void
    {
        // Keep case-study content on rollback so a deployment rollback cannot
        // remove work already visible or editable in Flowsee Studio.
    }
};
