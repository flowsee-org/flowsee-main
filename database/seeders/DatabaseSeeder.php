<?php

namespace Database\Seeders;

use App\Models\CaseStudy;
use App\Models\CaseStudySection;
use App\Models\CaseStudyStep;
use App\Models\ColorPalette;
use App\Models\ContactMessage;
use App\Models\GalleryImage;
use App\Models\Project;
use App\Models\Service;
use App\Models\SiteSetting;
use App\Models\SocialLink;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        \Illuminate\Support\Facades\Schema::disableForeignKeyConstraints();
        \App\Models\ContactMessage::query()->delete();
        \App\Models\Lead::query()->delete();
        \App\Models\SiteSetting::query()->delete();
        \App\Models\SocialLink::query()->delete();
        \App\Models\ColorPalette::query()->delete();
        \App\Models\GalleryImage::query()->delete();
        \App\Models\CaseStudyStep::query()->delete();
        \App\Models\CaseStudySection::query()->delete();
        \App\Models\CaseStudy::query()->delete();
        \App\Models\Project::query()->delete();
        \App\Models\Service::query()->delete();
        \Illuminate\Support\Facades\Schema::enableForeignKeyConstraints();

        $this->seedServices();
        $this->seedProjects();
        $this->seedCaseStudy();
        $this->seedSocialLinks();
        $this->seedSiteSettings();
    }

    private function seedServices(): void
    {
        $services = [
            ['slug' => 'branding', 'title' => 'برندسازی و', 'description' => 'طراحی هویت بصری', 'icon' => 'img52837428315365567501', 'sort_order' => 2],
            ['slug' => 'marketing', 'title' => 'سوشال مدیا و', 'description' => 'دیجیتال مارکتینگ', 'icon' => 'imgMarketingIconContainer', 'sort_order' => 1, 'is_highlighted' => true],
            ['slug' => 'uiux', 'title' => 'توسعه نرم‌افزار و', 'description' => 'طراحی رابط و تجربه کاربری', 'icon' => 'imgIconUiux', 'sort_order' => 0],
            ['slug' => 'packaging', 'title' => 'طراحی، چاپ و', 'description' => 'بسته‌بندی محصول', 'icon' => 'imgIconPrint', 'sort_order' => 5, 'is_highlighted' => true],
            ['slug' => 'video', 'title' => 'تدوین ویدیو و', 'description' => 'تولید محتوای تبلیغاتی', 'icon' => 'imgVideoIconContainer', 'sort_order' => 4],
            ['slug' => 'academy', 'title' => 'آکادمی، آموزش و', 'description' => 'توسعه سرمایه انسانی', 'icon' => 'imgAcademyIconContainer', 'sort_order' => 3, 'is_highlighted' => true],
        ];

        foreach ($services as $service) {
            Service::create($service);
        }
    }

    private function seedProjects(): void
    {
        $brandingService = Service::where('slug', 'branding')->first();
        $marketingService = Service::where('slug', 'marketing')->first();

        $projects = [
            ['slug' => 'shopero', 'name' => 'SHOPERO', 'cover_image' => 'imgShopero1', 'asset_id' => 'imgShopero1', 'service_id' => $marketingService?->id, 'sort_order' => 0],
            ['slug' => 'ima', 'name' => 'IMA MOVIES', 'cover_image' => 'imgIma2', 'asset_id' => 'imgIma2', 'service_id' => $marketingService?->id, 'sort_order' => 1],
            ['slug' => 'exloot', 'name' => 'EXLOOT', 'cover_image' => 'imgExloot2', 'asset_id' => 'imgExloot2', 'service_id' => $marketingService?->id, 'sort_order' => 2],
            ['slug' => 'ebrahimi', 'name' => 'EBRAHIMI', 'cover_image' => '16.jpg', 'asset_id' => '16', 'service_id' => $brandingService?->id, 'is_featured' => true, 'has_case_study' => true, 'sort_order' => 3],
        ];

        foreach ($projects as $project) {
            Project::create($project);
        }
    }

    private function seedCaseStudy(): void
    {
        $ebrahimi = Project::where('slug', 'ebrahimi')->first();

        $caseStudy = CaseStudy::create([
            'project_id' => $ebrahimi->id,
            'slug' => 'ebrahimi',
            'title' => 'مرکز بازسازی خودرو ابراهیمی',
            'lead' => 'خلق هویتی لوکس، دقیق و متمایز برای یک مرکز تخصصی بازسازی، تیون ظاهری و نصب آپشن خودرو.',
            'eyebrow' => 'کیس‌استادی · طراحی لوگو و هویت بصری',
            'client_name' => 'مرکز بازسازی خودرو ابراهیمی',
            'industry' => 'بازسازی، تیون و آپشن خودرو',
            'services_provided' => 'لوگو و هویت بصری',
            'cover_image' => '16.jpg',
            'cover_caption' => 'هویت ابراهیمی در فضای کارگاه',
            'meta_title' => 'کیس‌استادی ابراهیمی — طراحی لوگو و هویت بصری | استودیو فلوسی',
            'meta_description' => 'کیس‌استادی ابراهیمی — طراحی لوگو و هویت بصری برای مرکز تخصصی بازسازی، تیون ظاهری و نصب آپشن خودرو.',
            'theme_color' => '#012233',
        ]);

        // Color palette
        $colors = [
            ['name' => 'سرمه‌ای عمیق', 'hex' => '#012233'],
            ['name' => 'آبی الکتریک', 'hex' => '#4140C0'],
            ['name' => 'زرد تأکیدی', 'hex' => '#FFBE00'],
            ['name' => 'مشکی', 'hex' => '#000000'],
            ['name' => 'سفید', 'hex' => '#FFFFFF'],
            ['name' => 'خاکستری', 'hex' => '#CCCCCC'],
        ];

        foreach ($colors as $i => $color) {
            ColorPalette::create([
                'case_study_id' => $caseStudy->id,
                'name' => $color['name'],
                'hex' => $color['hex'],
                'sort_order' => $i,
            ]);
        }

        // Section: Overview
        $overview = CaseStudySection::create([
            'case_study_id' => $caseStudy->id,
            'slug' => 'overview',
            'title' => 'یک برند خودرویی، به‌دور از کلیشه.',
            'eyebrow' => '۰۰ · درباره پروژه',
            'index_label' => '۰۰',
            'sort_order' => 0,
        ]);

        $overviewSteps = [
            ['title' => 'تحلیل بریف', 'description' => 'شناخت مخاطب، رقبا و جایگاه برند.', 'step_number' => '۰۱', 'sort_order' => 0],
            ['title' => 'مسیر بصری', 'description' => 'تعریف یک زبان بصری متمایز و به‌دور از کلیشه.', 'step_number' => '۰۲', 'sort_order' => 1],
            ['title' => 'طراحی لوگو', 'description' => 'طراحی وردمارک و لترفرم با تناسبات طلایی.', 'step_number' => '۰۳', 'sort_order' => 2],
            ['title' => 'توسعهٔ هویت', 'description' => 'بسط سیستم بصری روی همهٔ نقاط تماس.', 'step_number' => '۰۴', 'sort_order' => 3],
        ];

        foreach ($overviewSteps as $step) {
            CaseStudyStep::create(['section_id' => $overview->id, ...$step]);
        }

        // Section: Structure
        $structure = CaseStudySection::create([
            'case_study_id' => $caseStudy->id,
            'slug' => 'structure',
            'title' => 'از حرف تا نشان، با هندسه‌ای دقیق.',
            'lead' => 'لوگو در قامل وردمارک و لترفرم طراحی شد؛ فرمی مینیمال و مرتبط با خودرو که حس دقت، خاص‌بودن و کیفیت را منتقل می‌کند.',
            'eyebrow' => '۰۱ · لوگو و ساختار',
            'index_label' => '۰۱',
            'band_image' => '02.jpg',
            'band_caption' => 'بخش‌بندی: نسبت طلایی',
            'sort_order' => 1,
        ]);

        $structureImages = [
            ['path' => '03.jpg', 'caption' => 'ساختار هندسی لوگو بر پایهٔ نسبت طلایی', 'layout' => 'third'],
            ['path' => '05.jpg', 'caption' => 'ساختار لوگو و نوشتار CAR RESTORATION CENTER', 'layout' => 'third'],
            ['path' => '04.jpg', 'caption' => 'حاشیهٔ ایمن لوگو (Safe Zone)', 'layout' => 'third'],
            ['path' => '01.jpg', 'caption' => 'جلد دفتر هویت برند ابراهیمی', 'layout' => 'full'],
        ];

        foreach ($structureImages as $i => $img) {
            GalleryImage::create(['section_id' => $structure->id, ...$img, 'sort_order' => $i]);
        }

        // Section: Scale
        $scale = CaseStudySection::create([
            'case_study_id' => $caseStudy->id,
            'slug' => 'scale',
            'title' => 'خوانا در هر اندازه‌ای.',
            'lead' => 'نشان و وردمارک در اندازه‌های گوناگون، از آیکون کوچک تا تابلوی بزرگ، متعادل و خوانا باقی می‌مانند.',
            'eyebrow' => '۰۲ · مقیاس و خوانایی',
            'index_label' => '۰۲',
            'band_image' => '06.jpg',
            'band_caption' => 'بخش‌بندی: مقیاس',
            'sort_order' => 2,
        ]);

        $scaleImages = [
            ['path' => '07.jpg', 'caption' => 'مقیاس‌پذیری نشان', 'layout' => 'half'],
            ['path' => '08.jpg', 'caption' => 'مقیاس‌پذیری وردمارک EBRAHIMI', 'layout' => 'half'],
        ];

        foreach ($scaleImages as $i => $img) {
            GalleryImage::create(['section_id' => $scale->id, ...$img, 'sort_order' => $i]);
        }

        // Section: Color
        $color = CaseStudySection::create([
            'case_study_id' => $caseStudy->id,
            'slug' => 'color',
            'title' => 'پالتی از عمق، انرژی و خنثی.',
            'lead' => 'پالت برند بر پایهٔ یک سرمه‌ای عمیق بنا شده است؛ رنگ تأکیدی زرد انرژی و توجه می‌آورد و آبی الکتریک حس مدرن‌بودن را تقویت می‌کند.',
            'eyebrow' => '۰۳ · رنگ',
            'index_label' => '۰۳',
            'band_image' => '09.jpg',
            'band_caption' => 'بخش‌بندی: رنگ',
            'sort_order' => 3,
        ]);

        $colorImages = [
            ['path' => '10.jpg', 'caption' => 'نسبت رنگ‌های پالت برند (۶۰/۳۰/۱۰)', 'layout' => 'full'],
            ['path' => '11.jpg', 'caption' => 'مقیاس خاکستری رنگ اصلی', 'layout' => 'third'],
            ['path' => '13.jpg', 'caption' => 'نشان روی صفحهٔ گوشی و پالت رنگ', 'layout' => 'third'],
            ['path' => '14.jpg', 'caption' => 'نسخه‌های رنگی نشان', 'layout' => 'third'],
            ['path' => '15.jpg', 'caption' => 'نسخه‌های رنگی وردمارک EBRAHIMI', 'layout' => 'full'],
        ];

        foreach ($colorImages as $i => $img) {
            GalleryImage::create(['section_id' => $color->id, ...$img, 'sort_order' => $i]);
        }

        // Section: Typography
        $typography = CaseStudySection::create([
            'case_study_id' => $caseStudy->id,
            'slug' => 'typography',
            'title' => 'دو زبان، یک شخصیت.',
            'lead' => 'نوشتار لاتین برند با یک تایپ‌فیس هندسی و مینیمال همراه است؛ برای متون فارسی از IRANSans استفاده می‌شود تا خوانایی در کنار شخصیت بصری حفظ شود.',
            'eyebrow' => '۰۴ · تایپوگرافی',
            'index_label' => '۰۴',
            'band_image' => '26.jpg',
            'band_caption' => 'بخش‌بندی: تایپوگرافی',
            'sort_order' => 4,
        ]);

        $typographyImages = [
            ['path' => '27.jpg', 'caption' => 'مقیاس تایپوگرافی لاتین برند', 'layout' => 'half'],
            ['path' => '28.jpg', 'caption' => 'مقیاس تایپوگرافی فارسی با IRANSans', 'layout' => 'half'],
        ];

        foreach ($typographyImages as $i => $img) {
            GalleryImage::create(['section_id' => $typography->id, ...$img, 'sort_order' => $i]);
        }

        // Section: Touchpoints
        $touchpoints = CaseStudySection::create([
            'case_study_id' => $caseStudy->id,
            'slug' => 'touchpoints',
            'title' => 'هویت در دنیای واقعی.',
            'lead' => 'هویت طراحی‌شده، شخصیت لوکس و کاریزماتیک برند را در نقاط تماس مختلف منتقل می‌کند.',
            'eyebrow' => '۰۵ · نقاط تماس برند',
            'index_label' => '۰۵',
            'band_image' => '12.jpg',
            'band_caption' => 'بخش‌بندی: ماکاپ',
            'sort_order' => 5,
        ]);

        $touchpointImages = [
            ['path' => '17.jpg', 'caption' => 'نشان روی بدنهٔ خودرو', 'layout' => 'full'],
            ['path' => '18.jpg', 'caption' => 'تابلو و سایناژ مرکز بازسازی', 'layout' => 'half'],
            ['path' => '19.jpg', 'caption' => 'تابلو و صندلی مسابقه‌ای با نشان برند', 'layout' => 'half'],
            ['path' => '20.jpg', 'caption' => 'تابلوی کلاسیک با نشان و وردمارک', 'layout' => 'half'],
            ['path' => '21.jpg', 'caption' => 'نشان سه‌بعدی نصب‌شده روی دیوار', 'layout' => 'half'],
            ['path' => '22.jpg', 'caption' => 'کارت ویزیت طلایی و پرچم تبلیغاتی', 'layout' => 'half'],
            ['path' => '23.jpg', 'caption' => 'بروشور و پوشهٔ برند', 'layout' => 'half'],
            ['path' => '25.jpg', 'caption' => 'کلاه با نشان برند', 'layout' => 'half'],
        ];

        foreach ($touchpointImages as $i => $img) {
            GalleryImage::create(['section_id' => $touchpoints->id, ...$img, 'sort_order' => $i]);
        }

        // Section: Icon
        $icon = CaseStudySection::create([
            'case_study_id' => $caseStudy->id,
            'slug' => 'icon',
            'title' => 'یک زبان، همهٔ نمادها.',
            'lead' => 'مجموعه‌ای از آیکون‌ها با زبان هندسی و هم‌خوان با لوگو طراحی شد تا در رابط‌های دیجیتال و اقلام چاپی یکدست بماند.',
            'eyebrow' => '۰۶ · سیستم آیکون',
            'index_label' => '۰۶',
            'band_image' => '29.jpg',
            'band_caption' => 'بخش‌بندی: آیکون',
            'sort_order' => 6,
        ]);

        GalleryImage::create([
            'section_id' => $icon->id,
            'path' => '30.jpg',
            'caption' => 'مجموعهٔ آیکون‌های برند',
            'layout' => 'full',
            'sort_order' => 0,
        ]);

        // Section: Guides
        $guides = CaseStudySection::create([
            'case_study_id' => $caseStudy->id,
            'slug' => 'guides',
            'title' => 'قواعدی که هویت را منسجم نگه می‌دارد.',
            'lead' => 'قواعد استفاده، رفتار نشان روی زمینه‌های رنگی و تصویری، و نسخه‌های تک‌رنگ لوگو تعریف شد تا هویت در همهٔ کاربردها یکدست بماند.',
            'eyebrow' => '۰۷ · راهنمای برند',
            'index_label' => '۰۷',
            'band_image' => '33.jpg',
            'band_caption' => 'بخش‌بندی: راهنما',
            'sort_order' => 7,
        ]);

        $guideImages = [
            ['path' => '32.jpg', 'caption' => 'رفتار نشان روی زمینه‌های رنگی و فرم‌های گرد', 'layout' => 'half'],
            ['path' => '34.jpg', 'caption' => 'قواعد استفاده از نسخهٔ تک‌رنگ لوگو', 'layout' => 'half'],
        ];

        foreach ($guideImages as $i => $img) {
            GalleryImage::create(['section_id' => $guides->id, ...$img, 'sort_order' => $i]);
        }
    }

    private function seedSocialLinks(): void
    {
        $links = [
            ['name' => 'Gmail', 'url' => 'mailto:hello@flowsee.ir', 'icon' => 'imgGmail1', 'sort_order' => 0],
            ['name' => 'WhatsApp', 'url' => 'https://wa.me/989109027628', 'icon' => 'imgWhatsapp', 'sort_order' => 1],
            ['name' => 'Telegram', 'url' => 'https://t.me/flowsee', 'icon' => 'imgTelegram', 'sort_order' => 2],
        ];

        foreach ($links as $link) {
            SocialLink::create($link);
        }
    }

    private function seedSiteSettings(): void
    {
        $settings = [
            ['key' => 'site_name', 'value' => 'استودیو فلوسی', 'type' => 'string'],
            ['key' => 'site_tagline', 'value' => 'خلاقیت در دنیای دیجیتال', 'type' => 'string'],
            ['key' => 'site_description', 'value' => 'استودیو فلوسی؛ طراحی برای رشد، استراتژی برای ماندگاری.', 'type' => 'string'],
            ['key' => 'phone', 'value' => '+989109027628', 'type' => 'string'],
            ['key' => 'phone_display', 'value' => '۰۹۱۰۹۰۲۷۶۲۸', 'type' => 'string'],
            ['key' => 'email', 'value' => 'hello@flowsee.ir', 'type' => 'string'],
            ['key' => 'og_image', 'value' => 'https://flowsee.ir/assets/flowsee-social.jpg', 'type' => 'string'],
            ['key' => 'theme_color', 'value' => '#FE5400', 'type' => 'string'],
        ];

        foreach ($settings as $setting) {
            SiteSetting::create($setting);
        }
    }
}
