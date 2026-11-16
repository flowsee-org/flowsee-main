<?php

namespace Tests\Feature;

use App\Models\CaseStudy;
use App\Models\CaseStudySection;
use App\Models\CaseStudyStep;
use App\Models\ColorPalette;
use App\Models\GalleryImage;
use App\Models\Project;
use App\Models\Service;
use App\Support\PortfolioLocalization;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Lang;
use Tests\TestCase;

class EnglishPortfolioTest extends TestCase
{
    use RefreshDatabase;

    public function test_english_cards_and_nested_modal_content_share_translations_without_changing_persian_records(): void
    {
        $service = Service::factory()->create(['title' => 'هویت بصری و برندسازی']);
        $project = Project::factory()->create([
            'slug' => 'portfolio-language-test', 'name' => 'مرکز بازسازی خودرو ابراهیمی',
            'description' => 'هویت ابراهیمی در فضای کارگاه', 'cover_image' => '16.jpg',
            'service_id' => $service->id, 'has_case_study' => true, 'sort_order' => 1,
        ]);
        $study = CaseStudy::create([
            'project_id' => $project->id, 'slug' => $project->slug, 'title' => 'یک برند خودرویی، به‌دور از کلیشه.',
            'lead' => 'هویت ابراهیمی در فضای کارگاه', 'client_name' => $project->name,
            'industry' => 'بازسازی، تیون و آپشن خودرو', 'services_provided' => 'لوگو و هویت بصری',
            'cover_image' => '16.jpg', 'cover_caption' => 'هویت ابراهیمی در فضای کارگاه', 'is_published' => true,
        ]);
        $section = CaseStudySection::create([
            'case_study_id' => $study->id, 'slug' => 'overview', 'title' => 'خوانا در هر اندازه‌ای.',
            'eyebrow' => '۰۲ · مقیاس و خوانایی', 'index_label' => '۰۲',
        ]);
        CaseStudyStep::create(['section_id' => $section->id, 'title' => 'تحلیل بریف', 'description' => 'شناخت مخاطب، رقبا و جایگاه برند.', 'step_number' => '۰۱']);
        GalleryImage::create(['section_id' => $section->id, 'path' => '16.jpg', 'caption' => 'مقیاس‌پذیری نشان', 'alt' => 'نشان روی بدنهٔ خودرو']);
        ColorPalette::create(['case_study_id' => $study->id, 'name' => 'سرمه‌ای عمیق', 'hex' => '#012233']);
        $original = $project->fresh()->getRawOriginal();
        $originalStudy = $study->fresh()->getRawOriginal();

        $english = $this->get('/en')->assertOk()->assertSee('Ebrahimi Car Restoration Center')
            ->assertSee('lang="en" dir="ltr" class="case-dialog"', false)
            ->assertSee('id="preview-title" dir="ltr"', false);
        $copy = collect($english->viewData('projectsData'))->firstWhere('slug', $project->slug);
        $this->assertSame('Ebrahimi Car Restoration Center', $copy['name']);
        $this->assertSame('Brand identity and strategy', $copy['service']);
        $this->assertSame('Car restoration, tuning and accessories', $copy['case_study']['industry']);
        $this->assertSame('Scaling the brand symbol', $copy['case_study']['sections'][0]['images'][0]['caption']);
        $this->assertSame('The symbol on a car body', $copy['case_study']['sections'][0]['images'][0]['alt']);
        $this->assertSame('01', $copy['case_study']['sections'][0]['steps'][0]['step_number']);
        $this->assertSame('Brief analysis', $copy['case_study']['sections'][0]['steps'][0]['title']);
        $this->assertSame('02', $copy['case_study']['sections'][0]['index_label']);
        $this->assertSame('Deep navy', $copy['case_study']['colors'][0]['name']);
        $this->assertSame('#012233', $copy['case_study']['colors'][0]['hex']);

        $persian = $this->get('/')->assertOk()->assertSee('مرکز بازسازی خودرو ابراهیمی')
            ->assertSee('lang="fa" dir="rtl" class="case-dialog"', false);
        $source = collect($persian->viewData('projectsData'))->firstWhere('slug', $project->slug);
        $this->assertSame('۰۱', $source['case_study']['sections'][0]['steps'][0]['step_number']);
        $this->assertSame($source['cover_image'], $copy['cover_image']);
        $this->assertSame($source['case_study']['sections'][0]['images'][0]['path'], $copy['case_study']['sections'][0]['images'][0]['path']);
        $this->assertSame($original, $project->fresh()->getRawOriginal());
        $this->assertSame($originalStudy, $study->fresh()->getRawOriginal());
    }

    public function test_portfolio_catalog_covers_all_registered_copy_and_does_not_translate_identifiers_or_media(): void
    {
        $catalog = Lang::get('portfolio', [], 'en');
        $this->assertGreaterThanOrEqual(302, count($catalog));
        $rows = array_map(fn ($source) => ['name' => $source, 'slug' => $source, 'cover_image' => '/assets/original.webp'], array_keys($catalog));
        DB::enableQueryLog();
        try {
            DB::flushQueryLog();
            $english = PortfolioLocalization::localize($rows, 'en');
            $this->assertCount(0, DB::getQueryLog());
        } finally {
            DB::disableQueryLog();
        }
        foreach ($rows as $index => $source) {
            $this->assertSame($catalog[$source['name']], $english[$index]['name']);
            $this->assertSame($source['slug'], $english[$index]['slug']);
            $this->assertSame($source['cover_image'], $english[$index]['cover_image']);
            $this->assertDoesNotMatchRegularExpression('/[\x{0620}-\x{06ef}]/u', $english[$index]['name']);
        }
        $this->assertSame($rows, PortfolioLocalization::localize($rows, 'fa'));
    }

    public function test_new_editor_content_keeps_its_original_when_a_translation_is_not_registered(): void
    {
        $source = [['slug' => 'new-project', 'name' => 'طرح تازهٔ کارفرما', 'description' => 'توضیحات ویرایش‌شدهٔ کارفرما', 'case_study' => null, 'gallery_images' => []]];
        $this->assertSame($source, PortfolioLocalization::localize($source, 'en'));
    }
}
