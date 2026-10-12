<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        DB::table('projects')->where('slug', 'shopero')->update(['name' => 'شاپیرو']);
        DB::table('projects')->where('slug', 'ebrahimi')->update(['name' => 'مرکز بازسازی خودرو ابراهیمی']);
    }

    public function down(): void
    {
        DB::table('projects')->where('slug', 'shopero')->update(['name' => 'SHOPERO']);
        DB::table('projects')->where('slug', 'ebrahimi')->update(['name' => 'EBRAHIMI']);
    }
};
