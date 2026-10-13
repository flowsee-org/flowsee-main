<?php

namespace Tests\Feature;

use App\Models\CaseStudy;
use App\Models\CaseStudySection;
use App\Models\CaseStudyStep;
use App\Models\ColorPalette;
use App\Models\GalleryImage;
use App\Models\Project;
use App\Models\Service;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class FlowseePageTest extends TestCase
{
    use RefreshDatabase;

    protected function seedCaseStudyData(): void
    {
        Service::create(['slug' => 'branding', 'title' => 'برندسازی', 'description' => 'طراحی هویت بصری', 'icon' => 'branding', 'sort_order' => 0]);

        $project = Project::create([
            'slug' => 'ebrahimi',
            'name' => 'EBRAHIMI',
            'cover_image' => '16.jpg',
            'asset_id' => '16',
            'service_id' => 1,
            'is_featured' => true,
            'has_case_study' => true,
            'sort_order' => 3,
        ]);

        $caseStudy = CaseStudy::create([
            'project_id' => $project->id,
            'slug' => 'ebrahimi',
            'title' => 'مرکز بازسازی خودرو ابراهیمی',
            'lead' => 'خلق هویتی لوکس، دقیق و متمایز.',
            'eyebrow' => 'کیس‌استادی · طراحی لوگو و هویت بصری',
            'client_name' => 'مرکز بازسازی خودرو ابراهیمی',
            'industry' => 'بازسازی، تیون و آپشن خودرو',
            'services_provided' => 'لوگو و هویت بصری',
            'cover_image' => '16.jpg',
            'cover_caption' => 'هویت ابراهیمی در فضای کارگاه',
            'theme_color' => '#012233',
        ]);

        ColorPalette::create(['case_study_id' => $caseStudy->id, 'name' => 'سرمه‌ای عمیق', 'hex' => '#012233', 'sort_order' => 0]);

        $section = CaseStudySection::create([
            'case_study_id' => $caseStudy->id,
            'slug' => 'overview',
            'title' => 'یک برند خودرویی، به‌دور از کلیشه.',
            'eyebrow' => '۰۰ · درباره پروژه',
            'index_label' => '۰۰',
            'sort_order' => 0,
        ]);

        CaseStudyStep::create(['section_id' => $section->id, 'title' => 'تحلیل بریف', 'description' => 'شناخت مخاطب.', 'step_number' => '۰۱', 'sort_order' => 0]);
    }

    public function test_homepage_preserves_content_and_instagram_and_loads_mobile_styles(): void
    {
        $response = $this->get('/')->assertOk()->assertSee('طراحی برای')->assertSee('https://www.instagram.com/flowsee.ir/', false)
            ->assertSee('اطلاعات پروژه برای پیگیری در پایگاه دادهٔ فلوسی ثبت می‌شود.')
            ->assertSee('ارسال درخواست')
            ->assertSee('پیام شما با موفقیت ارسال شد')
            ->assertSee('class="required-marker"', false)
            ->assertSee('assets/css/mobile.css', false)->assertSee('assets/js/site.js', false)->assertSee('class="hero-logo-glass"', false)->assertDontSee('<model-viewer', false)->assertSee('felosi-logo-sculpture.png', false);
        $this->assertSame(1, substr_count($response->getContent(), 'assets/js/site.js'));
        $this->assertStringNotContainsString('localStorage', file_get_contents(public_path('assets/js/site.js')));
    }

    public function test_search_engine_files_and_homepage_metadata_are_available(): void
    {
        $this->assertFileExists(public_path('robots.txt'));
        $this->assertFileExists(public_path('sitemap.xml'));
        $this->assertStringContainsString('Sitemap: https://flowsee.ir/sitemap.xml', file_get_contents(public_path('robots.txt')));
        $this->assertStringContainsString('<loc>https://flowsee.ir/</loc>', file_get_contents(public_path('sitemap.xml')));

        $this->get('/')->assertOk()
            ->assertSee('name="google-site-verification" content="UAQcvYOs7dLeVV987bTILlMz0EU8I0LTdyOlBlKpfeA"', false)
            ->assertSee('<link rel="canonical" href="https://flowsee.ir/">', false)
            ->assertSee('application/ld+json', false)
            ->assertSee('ProfessionalService', false)
            ->assertSee('<h1 id="hero-title"', false)
            ->assertSee('rel="icon" href="/favicon.svg"', false)
            ->assertSee('width="1200" height="630"', false)
            ->assertSee('id="lightbox-img" width="1920" height="1080"', false);
        $this->assertFileExists(public_path('favicon.svg'));
        $this->assertFileExists(public_path('llm.txt'));
        $this->assertFileExists(public_path('llms.txt'));
    }

    public function test_ima_movies_case_study_and_refined_service_cards_are_available(): void
    {
        Service::create([
            'slug' => 'marketing',
            'title' => 'بازاریابی شبکه‌های اجتماعی',
            'description' => 'تولید محتوا و ارتباط مؤثر با مخاطبان در شبکه‌های اجتماعی.',
            'icon' => 'marketing',
            'sort_order' => 1,
        ]);
        Service::create([
            'slug' => 'uiux',
            'title' => 'طراحی رابط و تجربه کاربری',
            'description' => 'طراحی تجربه‌های دیجیتال ساده، روان و هدفمند.',
            'icon' => 'uiux',
            'sort_order' => 0,
        ]);

        app(\Database\Seeders\ImaMoviesCaseStudySeeder::class)->run();

        $this->get('/')->assertOk()
            ->assertSee('طراحی رابط و تجربه کاربری')
            ->assertSee('طراحی تجربه‌های دیجیتال ساده، روان و هدفمند.')
            ->assertSee('بازاریابی شبکه‌های اجتماعی')
            ->assertSee('/assets/ima-case-study/ima-movies.webp')
            ->assertDontSee('class="about-values"', false);

        $project = Project::with('caseStudy.sections.steps', 'caseStudy.sections.images')
            ->where('slug', 'ima')
            ->firstOrFail();

        $this->assertTrue($project->has_case_study);
        $this->assertTrue($project->caseStudy->is_published);
        $this->assertCount(3, $project->caseStudy->sections);
        $this->assertCount(5, $project->caseStudy->sections->flatMap->images);
        $this->assertFileExists(public_path('assets/ima-case-study/ima-account-flow.webp'));
    }

    public function test_portfolio_cards_keep_the_original_layout_and_open_database_case_studies(): void
    {
        $this->seedCaseStudyData();
        app(\Database\Seeders\ExlootCaseStudySeeder::class)->run();

        $html = $this->get('/')->assertOk()
            ->assertSee('class="project-copy"', false)
            ->assertSee('class="project-image"', false)
            ->assertSee('data-project-slug="ebrahimi"', false)
            ->assertSee('class="portfolio-view-all"', false)
            ->assertSee('class="service-grid"', false)
            ->assertSee('class="service-icon"', false)
            ->assertSee('<button class="project-card', false)
            ->assertDontSee('<a class="project-card', false)
            ->assertSee('aria-label="مشاهدهٔ کیس‌استادی اکسلوت"', false)
            ->assertSee('مشاهدهٔ کیس‌استادی EBRAHIMI')
            ->assertDontSee('id="articles"', false)
            ->assertSee('window.projectsData', false)
            ->getContent();

        $this->assertStringContainsString('function renderCaseStudy(project)', file_get_contents(public_path('assets/js/site.js')));
        $this->assertStringContainsString('aria-label="مشاهدهٔ کیس‌استادی EBRAHIMI"', $html);
    }

    public function test_legacy_addresses_redirect_and_case_study_renders(): void
    {
        $this->seedCaseStudyData();
        app(\Database\Seeders\ExlootCaseStudySeeder::class)->run();
        $this->get('/felosi-home-before-about-v2.html')->assertRedirect('/');
        $this->get('/ebrahimi-case-study.html')->assertRedirect('/projects/ebrahimi');
        $this->get('/projects/ebrahimi')->assertOk()
            ->assertViewIs('case-study')
            ->assertSee('مرکز بازسازی خودرو ابراهیمی')
            ->assertSee('<link rel="canonical" href="https://flowsee.ir/projects/ebrahimi">', false)
            ->assertSee('name="robots" content="index,follow,max-image-preview:large"', false)
            ->assertSee('BreadcrumbList', false)
            ->assertSee('aria-label="مسیر صفحه"', false);
        $this->get('/?case=ebrahimi')->assertOk()->assertSee('window.projectsData', false);
        $this->get('/projects/exloot')->assertOk()
            ->assertViewIs('case-study')
            ->assertSee('اکسلوت؛ خریدوفروش امن‌تر در بازار آیتم‌های بازی')
            ->assertSee('assets/exloot-case-study/exloot-cover.jpg')
            ->assertSee('پرداخت امانی را به مراحلی قابل‌فهم تبدیل کردیم.')
            ->assertSee('آزادسازی مبلغ')
            ->assertSee('assets/exloot-case-study/exloot-7.jpg');
        $this->get('/up')->assertOk();
        $this->get('/not-a-page')->assertNotFound()
            ->assertSee('<title>صفحه پیدا نشد | استودیو فلوسی</title>', false)
            ->assertSee('name="robots" content="noindex,follow"', false)
            ->assertSee('این صفحه پیدا نشد.')
            ->assertSee('href="/#portfolio"', false);
    }

    public function test_project_lead_api_route_is_registered_and_validates_empty_requests(): void
    {
        $this->postJson('/api/leads', [])
            ->assertUnprocessable()
            ->assertJsonValidationErrors(['name', 'phone', 'service', 'details']);
    }

    public function test_project_lead_api_persists_a_valid_submission(): void
    {
        $this->postJson('/api/leads', [
            'name' => 'تست CI',
            'phone' => '09123456789',
            'email' => null,
            'service' => 'branding',
            'details' => 'درخواست آزمایشی در دیتابیس موقت تست.',
        ])
            ->assertOk()
            ->assertJsonPath('success', true);

        $this->assertDatabaseHas('leads', [
            'name' => 'تست CI',
            'phone' => '09123456789',
            'service' => 'branding',
            'details' => 'درخواست آزمایشی در دیتابیس موقت تست.',
        ]);
    }

    public function test_homepage_local_images_and_styles_are_present_in_public_directory(): void
    {
        $html = $this->get('/')->getContent();
        preg_match_all('/(?:src|data-src)=["\']([^"\']+)["\']/', $html, $matches);
        foreach ($matches[1] as $url) {
            if (str_starts_with($url, 'data:') || str_starts_with($url, 'https:') || $url === '') {
                continue;
            }
            $path = parse_url($url, PHP_URL_PATH);
            if (str_starts_with($path, '/livewire-')) {
                continue;
            }
            $this->assertFileExists(public_path(ltrim($path, '/')), $url);
        }
        $this->assertFileExists(public_path('assets/css/mobile.css'));
    }
}
