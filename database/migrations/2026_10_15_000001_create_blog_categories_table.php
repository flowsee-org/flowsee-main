<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('blog_categories', function (Blueprint $table): void {
            $table->id();
            $table->string('name');
            $table->string('slug')->unique();
            $table->string('description', 500)->nullable();
            $table->unsignedInteger('sort_order')->default(0);
            $table->timestamps();
        });

        $now = now();
        DB::table('blog_categories')->insert([
            ['name' => 'برندینگ و هویت بصری', 'slug' => 'brand-identity', 'description' => 'ساخت و مدیریت هویت برندهای ماندگار', 'sort_order' => 1, 'created_at' => $now, 'updated_at' => $now],
            ['name' => 'تجربه کاربری و رابط کاربری', 'slug' => 'ux-ui', 'description' => 'طراحی تجربه‌های دیجیتال ساده و هدفمند', 'sort_order' => 2, 'created_at' => $now, 'updated_at' => $now],
            ['name' => 'طراحی بسته‌بندی', 'slug' => 'packaging', 'description' => 'طراحی بسته‌بندی و تجربه محصول', 'sort_order' => 3, 'created_at' => $now, 'updated_at' => $now],
            ['name' => 'محتوا و بازاریابی', 'slug' => 'content-marketing', 'description' => 'استراتژی محتوا و ارتباط با مخاطب', 'sort_order' => 4, 'created_at' => $now, 'updated_at' => $now],
            ['name' => 'استراتژی دیجیتال', 'slug' => 'digital-strategy', 'description' => 'تصمیم‌گیری و رشد در فضای دیجیتال', 'sort_order' => 5, 'created_at' => $now, 'updated_at' => $now],
        ]);
    }

    public function down(): void
    {
        Schema::dropIfExists('blog_categories');
    }
};
