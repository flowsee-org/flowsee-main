<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        DB::table('projects')->where('slug', 'ima')->update(['name' => 'ایما موویز']);
        DB::table('projects')->where('slug', 'exloot')->update(['name' => 'اکسلوت']);
    }

    public function down(): void
    {
        // Keep the approved Persian project names when rolling back application code.
    }
};
