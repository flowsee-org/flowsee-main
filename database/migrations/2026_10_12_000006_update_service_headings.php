<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        $services = [
            'branding' => ['هویت بصری و برندسازی', 'ساخت چهره‌ای متمایز و منسجم برای برند شما.'],
            'marketing' => ['بازاریابی شبکه‌های اجتماعی', 'تولید محتوا و ارتباط مؤثر با مخاطبان در شبکه‌های اجتماعی.'],
            'uiux' => ['طراحی رابط و تجربه کاربری', 'طراحی تجربه‌های دیجیتال ساده، روان و هدفمند.'],
            'packaging' => ['طراحی بسته‌بندی محصول', 'تبدیل شخصیت برند به بسته‌بندی متمایز و آمادهٔ تولید.'],
            'video' => ['تدوین و تولید ویدیو', 'ساخت محتوای ویدیویی برای معرفی و رشد برند.'],
            'academy' => ['آموزش و توسعه سرمایه انسانی', 'توانمندسازی تیم‌ها با آموزش‌های کاربردی و هدفمند.'],
        ];

        foreach ($services as $slug => [$title, $description]) {
            DB::table('services')->where('slug', $slug)->update(compact('title', 'description'));
        }
    }

    public function down(): void
    {
        // Keep the edited service copy visible on rollback.
    }
};
