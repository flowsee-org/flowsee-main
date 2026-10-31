<?php

namespace Database\Seeders;

use App\Models\CaseStudy;
use App\Models\CaseStudySection;
use App\Models\GalleryImage;
use App\Models\Project;
use Illuminate\Database\Seeder;

class MapiAndHadisnaillineCaseStudiesSeeder extends Seeder
{
    public function run(): void
    {
        $this->seedProject(
            slug: 'mapi-shop',
            name: 'Mapi Shop',
            description: 'طراحی فروشگاه اینترنتی Mapi Shop؛ تجربهٔ خرید آنلاین برای فروشگاه تخصصی تجهیزات شنا.',
            cover: 'assets/case-studies/mapi-shop/cover.jpg',
            title: 'Mapi Shop؛ طراحی تجربهٔ یک فروشگاه اینترنتی تخصصی',
            lead: 'Mapi Shop فروشگاه تخصصی تجهیزات شناست. در این پروژه، مسیر جست‌وجو و دسته‌بندی محصولات، نمایش پیشنهادهای ویژه و تجربهٔ خرید در موبایل و دسکتاپ طراحی شد. ساختارهای روشن فروشگاه و صفحهٔ محصول، الگوهایی هستند که برای فروشگاه‌های تخصصی آرایشی و بهداشتی نیز قابل استفاده و بومی‌سازی‌اند.',
            eyebrow: 'کیس‌استادی · طراحی فروشگاه اینترنتی',
            industry: 'تجارت الکترونیک · تجهیزات شنا',
            services: 'طراحی تجربه کاربری و رابط کاربری فروشگاه آنلاین',
            theme: '#e83183',
            sections: [
                [
                    'slug' => 'storefront-experience', 'title' => 'فروشگاه، از نگاه مشتری', 'eyebrow' => '۰۱ · تجربهٔ خرید', 'index_label' => '۰۱', 'sort_order' => 1,
                    'lead' => 'صفحهٔ اصلی با اولویت دسترسی به دسته‌بندی‌ها، محصولات شاخص و پیشنهادهای فروش چیده شد. رابط فروشگاه به‌گونه‌ای طراحی شد که در نمایشگرهای مختلف، مسیر کشف محصول قابل‌فهم بماند.',
                    'images' => [
                        ['path' => 'assets/case-studies/mapi-shop/home-page.jpg', 'caption' => 'صفحهٔ اصلی فروشگاه Mapi Shop', 'alt' => 'طراحی صفحهٔ اصلی فروشگاه آنلاین Mapi Shop', 'layout' => 'full', 'width' => 679, 'height' => 2200],
                        ['path' => 'assets/case-studies/mapi-shop/mega-menu.jpg', 'caption' => 'دسته‌بندی محصولات در منوی باز فروشگاه', 'alt' => 'منوی دسته‌بندی فروشگاه اینترنتی Mapi Shop', 'layout' => 'half', 'width' => 1440, 'height' => 1024],
                    ],
                ],
                [
                    'slug' => 'conversion-details', 'title' => 'جزئیاتی که خرید را ساده‌تر می‌کنند', 'eyebrow' => '۰۲ · پیشنهاد و تبدیل', 'index_label' => '۰۲', 'sort_order' => 2,
                    'lead' => 'نمایش پیشنهادهای مناسبتی و تجربهٔ دریافت هدیه، در کنار رابط اصلی فروشگاه طراحی شد تا پیام فروش در زمان درست و بدون پیچیدگی به مشتری برسد.',
                    'images' => [
                        ['path' => 'assets/case-studies/mapi-shop/gift-modal.jpg', 'caption' => 'طراحی پنجرهٔ هدیه و پیشنهاد خرید', 'alt' => 'پنجرهٔ پیشنهاد هدیه در فروشگاه آنلاین Mapi Shop', 'layout' => 'full', 'width' => 1440, 'height' => 1024],
                    ],
                ],
            ],
        );

        $this->seedProject(
            slug: 'hadisnailline',
            name: 'Hadisnailline',
            description: 'طراحی تراکت و کارت ویزیت برای معرفی خدمات و رزرو نوبت Hadisnailline.',
            cover: 'assets/case-studies/hadisnailline/flyer.jpg',
            title: 'Hadisnailline؛ هویت چاپی برای خدمات ناخن',
            lead: 'برای Hadisnailline دو خروجی چاپی هماهنگ طراحی شد: تراکتی برای معرفی خدمات و کارت ویزیتی برای نگه‌داشتن راه ارتباطی و دسترسی به صفحهٔ اینستاگرام. رنگ صورتی، تایپوگرافی شاخص و QR کد، اجزای یکپارچهٔ این مجموعه‌اند.',
            eyebrow: 'کیس‌استادی · طراحی اقلام چاپی',
            industry: 'زیبایی و مراقبت ناخن',
            services: 'طراحی تراکت و کارت ویزیت',
            theme: '#cf438a',
            sections: [
                [
                    'slug' => 'service-flyer', 'title' => 'تراکت معرفی خدمات', 'eyebrow' => '۰۱ · معرفی خدمات', 'index_label' => '۰۱', 'sort_order' => 1,
                    'lead' => 'تراکت، خدمات کاشت، ترمیم و طراحی ناخن را همراه با راه‌های تماس و نشانی اینستاگرام در یک ترکیب خوانا معرفی می‌کند.',
                    'images' => [
                        ['path' => 'assets/case-studies/hadisnailline/flyer.jpg', 'caption' => 'ماکاپ تراکت معرفی خدمات Hadisnailline', 'alt' => 'تراکت خدمات زیبایی و طراحی ناخن Hadisnailline با QR کد اینستاگرام', 'layout' => 'full', 'width' => 2200, 'height' => 1760],
                    ],
                ],
                [
                    'slug' => 'business-card', 'title' => 'کارت ویزیت با دسترسی سریع', 'eyebrow' => '۰۲ · ارتباط با مشتری', 'index_label' => '۰۲', 'sort_order' => 2,
                    'lead' => 'کارت ویزیت با حفظ زبان بصری تراکت، شمارهٔ تماس و QR کد اینستاگرام را در دسترس قرار می‌دهد.',
                    'images' => [
                        ['path' => 'assets/case-studies/hadisnailline/business-card.jpg', 'caption' => 'ماکاپ کارت ویزیت Hadisnailline', 'alt' => 'کارت ویزیت صورتی Hadisnailline با QR کد صفحهٔ اینستاگرام', 'layout' => 'full', 'width' => 2200, 'height' => 1467],
                    ],
                ],
            ],
        );
    }

    private function seedProject(
        string $slug,
        string $name,
        string $description,
        string $cover,
        string $title,
        string $lead,
        string $eyebrow,
        string $industry,
        string $services,
        string $theme,
        array $sections,
    ): void {
        $project = Project::query()->updateOrCreate(['slug' => $slug], [
            'name' => $name,
            'description' => $description,
            'cover_image' => $cover,
            'has_case_study' => true,
            'is_active' => true,
            'is_featured' => false,
            'sort_order' => $slug === 'mapi-shop' ? 3 : 4,
        ]);

        $caseStudy = CaseStudy::query()->updateOrCreate(['project_id' => $project->id], [
            'slug' => $slug,
            'title' => $title,
            'lead' => $lead,
            'eyebrow' => $eyebrow,
            'client_name' => $name,
            'industry' => $industry,
            'services_provided' => $services,
            'cover_image' => $cover,
            'cover_caption' => $description,
            'meta_title' => $title . ' | استودیو فلوسی',
            'meta_description' => $lead,
            'theme_color' => $theme,
            'is_published' => true,
        ]);

        foreach ($sections as $sectionData) {
            $section = CaseStudySection::query()->updateOrCreate(
                ['case_study_id' => $caseStudy->id, 'slug' => $sectionData['slug']],
                collect($sectionData)->except('images')->all(),
            );

            $section->images()->delete();
            foreach ($sectionData['images'] as $index => $image) {
                GalleryImage::query()->create([
                    'section_id' => $section->id,
                    'project_id' => $project->id,
                    ...$image,
                    'sort_order' => $index,
                ]);
            }
        }
    }
}
