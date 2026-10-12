<?php

namespace Database\Seeders;

use App\Models\CaseStudy;
use App\Models\CaseStudySection;
use App\Models\CaseStudyStep;
use App\Models\GalleryImage;
use App\Models\Project;
use App\Models\Service;
use Illuminate\Database\Seeder;

class ImaMoviesCaseStudySeeder extends Seeder
{
    public function run(): void
    {
        $marketing = Service::query()->where('slug', 'marketing')->first();
        $project = Project::query()->updateOrCreate(['slug' => 'ima'], [
            'name' => 'ایما موویز',
            'description' => 'طراحی محصول یک پلتفرم پخش آنلاین فیلم و سریال؛ از کشف محتوا تا شروع تماشا.',
            'cover_image' => 'assets/ima-case-study/ima-movies.webp',
            'asset_id' => null,
            'service_id' => $marketing?->id,
            'has_case_study' => true,
            'is_active' => true,
            'sort_order' => 1,
        ]);

        $caseStudy = CaseStudy::query()->updateOrCreate(['project_id' => $project->id], [
            'slug' => 'ima-movies',
            'title' => 'ایما موویز؛ از کشف فیلم تا شروع تماشا',
            'lead' => 'ایما موویز یک پلتفرم پخش آنلاین فیلم و سریال برای وب و موبایل است که از صفر طراحی شد. مسئلهٔ اصلی، ساخت تجربه‌ای سریع و یکپارچه بود تا مخاطب بدون پیچیدگی در ناوبری و انتظار برای بارگذاری، محتوای مناسب را پیدا کند و زودتر به تماشا برسد.',
            'eyebrow' => 'کیس‌استادی · طراحی محصول دیجیتال',
            'client_name' => 'ایما موویز',
            'industry' => 'سرگرمی دیجیتال · ویدئو بر اساس تقاضا',
            'services_provided' => 'مدیریت محصول، طراحی تجربه کاربری و رابط کاربری',
            'cover_image' => 'assets/ima-case-study/ima-movies.webp',
            'cover_caption' => 'ایما موویز؛ تجربهٔ پخش آنلاین فیلم و سریال در وب و موبایل',
            'meta_title' => 'کیس‌استادی ایما موویز — طراحی محصول پخش آنلاین فیلم و سریال | استودیو فلوسی',
            'meta_description' => 'طراحی محصول ایما موویز از صفر؛ تجربهٔ کشف محتوا و تماشای فیلم و سریال در وب و موبایل، با تمرکز بر سرعت، واکنش‌گرایی و دسترسی ساده.',
            'theme_color' => '#075744',
            'is_published' => true,
        ]);

        $sections = [
            [
                'slug' => 'product-brief',
                'title' => 'یک مسیر کوتاه از ورود تا تماشا.',
            'lead' => 'ایما موویز به‌عنوان یک محصول تازه تعریف شد. هدف این بود که تجربهٔ تماشا در موبایل و دسکتاپ یکپارچه بماند، جست‌وجو و دسته‌بندی محتوا در دسترس باشد و رابط، حتی روی اینترنت ناپایدار، سبک و قابل‌استفاده بماند.',
                'eyebrow' => '۰۰ · صورت مسئله',
                'index_label' => '۰۰',
                'sort_order' => 0,
                'steps' => [
                    ['title' => 'کاهش اصطکاک', 'description' => 'کم‌کردن گام‌های میان ورود، پیدا کردن فیلم و شروع پخش.', 'step_number' => '۰۱'],
                    ['title' => 'هماهنگی دستگاه‌ها', 'description' => 'طراحی تجربه‌ای پیوسته برای موبایل، تبلت و نمایشگر دسکتاپ.', 'step_number' => '۰۲'],
                    ['title' => 'تمرکز بر محتوای درست', 'description' => 'نمایش اطلاعات و پیشنهادهای لازم برای انتخاب سریع‌تر.', 'step_number' => '۰۳'],
                ],
                'images' => [
                    ['path' => 'assets/ima-case-study/ima-discovery.webp', 'caption' => 'نمایش کاتالوگ و دسته‌بندی برای کشف سریع‌تر محتوا', 'alt' => 'رابط کاتالوگ فیلم و سریال ایما موویز', 'layout' => 'full'],
                ],
            ],
            [
                'slug' => 'experience-design',
                'title' => 'کشف محتوا، بدون لایه‌های اضافه.',
                'lead' => 'ساختار صفحه‌ها با ناوبری روشن، اطلاعات کلیدی و مسیرهای کوتاه شکل گرفت. برای نسخهٔ دسکتاپ از چیدمان Bento Grid استفاده شد و در موبایل، هیروی ثابت و متمرکز جای اسلایدرهای سنگین را گرفت. نسبت‌های استاندارد تصاویر نیز به ثبات چیدمان هنگام بارگذاری کمک می‌کنند.',
                'eyebrow' => '۰۱ · معماری تجربه',
                'index_label' => '۰۱',
                'sort_order' => 1,
                'steps' => [
                    ['title' => 'دسترسی سریع', 'description' => 'پیوندهای اصلی و دسته‌بندی‌ها از هدر در دسترس‌اند.', 'step_number' => '۰۱'],
                    ['title' => 'تصمیم‌گیری آگاهانه', 'description' => 'خلاصهٔ داستان و اطلاعات تکمیلی کنار محتوای شاخص قرار می‌گیرند.', 'step_number' => '۰۲'],
                    ['title' => 'پیشنهادهای مرتبط', 'description' => 'محتوای مشابه، مسیر کشف فیلم‌های تازه را ادامه می‌دهد.', 'step_number' => '۰۳'],
                ],
                'images' => [
                    ['path' => 'assets/ima-case-study/ima-responsive-experience.webp', 'caption' => 'هم‌نشینی نسخهٔ دسکتاپ و موبایل در یک تجربهٔ یکپارچه', 'alt' => 'ماکاپ واکنش‌گرای پلتفرم ایما موویز روی چند دستگاه', 'layout' => 'full'],
                    ['path' => 'assets/ima-case-study/ima-product-details.webp', 'caption' => 'صفحهٔ جزئیات محتوا با اطلاعات لازم برای انتخاب و تماشا', 'alt' => 'نمای صفحهٔ جزئیات فیلم در ایما موویز', 'layout' => 'half'],
                    ['path' => 'assets/ima-case-study/ima-content-page.webp', 'caption' => 'صفحهٔ محتوا با مسیر روشن برای مشاهده و خرید', 'alt' => 'نمای صفحهٔ پخش و جزئیات محتوا در ایما موویز', 'layout' => 'half'],
                ],
            ],
            [
                'slug' => 'design-system',
                'title' => 'سیستمی آمادهٔ تحویل و توسعه.',
                'lead' => 'توکن‌های فاصله‌گذاری و تایپوگرافی، نسبت‌های ثابت تصویر و قواعد واکنش‌گرایی، زبان مشترک طراحی و پیاده‌سازی را ساختند. هم‌زمان تیم سه‌نفرهٔ توسعه با تیم طراحی هماهنگ بود تا نسخهٔ اولیه در بازهٔ یک‌ماهه به مرحلهٔ تحویل برسد.',
                'eyebrow' => '۰۲ · سیستم طراحی و تحویل',
                'index_label' => '۰۲',
                'sort_order' => 2,
                'steps' => [
                    ['title' => 'زبان بصری منسجم', 'description' => 'مقیاس‌های نسبی و قواعد روشن برای تایپوگرافی و فاصله‌ها.', 'step_number' => '۰۱'],
                    ['title' => 'ثبات چیدمان', 'description' => 'نسبت‌های مشخص برای کاورها و تصاویر شاخص.', 'step_number' => '۰۲'],
                    ['title' => 'تحویل در یک ماه', 'description' => 'هماهنگی طراحی محصول با تیم فرانت‌اند و بک‌اند در چرخهٔ فشردهٔ MVP.', 'step_number' => '۰۳'],
                ],
                'images' => [
                    ['path' => 'assets/ima-case-study/ima-account-flow.webp', 'caption' => 'وضعیت‌های حساب کاربری و اشتراک در رابط ایما موویز', 'alt' => 'صفحهٔ تنظیمات و اشتراک کاربر در ایما موویز', 'layout' => 'full'],
                ],
            ],
        ];

        foreach ($sections as $data) {
            $section = CaseStudySection::query()->updateOrCreate(
                ['case_study_id' => $caseStudy->id, 'slug' => $data['slug']],
                collect($data)->except(['steps', 'images'])->all(),
            );

            $section->steps()->delete();
            foreach ($data['steps'] as $index => $step) {
                CaseStudyStep::query()->create(['section_id' => $section->id, ...$step, 'sort_order' => $index]);
            }

            $section->images()->delete();
            foreach ($data['images'] as $index => $image) {
                GalleryImage::query()->create(['section_id' => (string) $section->id, 'project_id' => $project->id, ...$image, 'sort_order' => $index]);
            }
        }
    }
}
