<?php

use Database\Seeders\ProgrammingStackArticlesSeeder;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    private array $slugs = [
        'javascript-guide', 'typescript-guide', 'nextjs-guide', 'go-guide',
        'laravel-guide', 'python-guide', 'vuejs-guide', 'svelte-guide',
        'flutter-guide', 'react-guide', 'livewire-guide', 'php-guide',
        'electronjs-guide',
    ];

    public function up(): void
    {
        app(ProgrammingStackArticlesSeeder::class)->run();
    }

    public function down(): void
    {
        DB::table('blog_posts')->whereIn('slug', $this->slugs)->delete();

        $category = DB::table('blog_categories')->where('slug', 'programming-stacks')->first();
        if ($category && ! DB::table('blog_posts')->where('blog_category_id', $category->id)->exists()) {
            DB::table('blog_categories')->where('id', $category->id)->delete();
        }
    }
};
