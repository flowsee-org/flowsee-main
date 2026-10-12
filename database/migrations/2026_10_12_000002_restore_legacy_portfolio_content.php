<?php

use Database\Seeders\LegacyPortfolioSeeder;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    public function up(): void
    {
        // Production deployment runs migrations, not db:seed. Restore this
        // legacy public content once as part of that normal deployment path.
        if (app()->environment('production')) {
            app(LegacyPortfolioSeeder::class)->run();
        }
    }

    public function down(): void
    {
        // Keep restored and subsequently edited website content on rollback.
    }
};
