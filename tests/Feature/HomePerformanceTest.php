<?php

namespace Tests\Feature;

use App\Models\BlogCategory;
use App\Models\BlogPost;
use App\Models\CaseStudy;
use App\Models\CaseStudySection;
use App\Models\CaseStudyStep;
use App\Models\ColorPalette;
use App\Models\GalleryImage;
use App\Models\Project;
use App\Models\Service;
use App\Support\WebsiteMediaUrl;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\DB;
use Tests\TestCase;

class HomePerformanceTest extends TestCase
{
    use RefreshDatabase;

    public function test_portfolio_query_count_does_not_grow_with_projects_and_nested_sections(): void
    {
        $service = Service::factory()->create();
        $createProject = function () use ($service): void {
            $project = Project::factory()->create(['service_id' => $service->id, 'has_case_study' => true]);
            $study = CaseStudy::factory()->create(['project_id' => $project->id]);
            $section = CaseStudySection::factory()->create(['case_study_id' => $study->id]);
            CaseStudyStep::factory()->create(['section_id' => $section->id]);
            ColorPalette::factory()->create(['case_study_id' => $study->id]);
            GalleryImage::factory()->create(['section_id' => $section->id, 'project_id' => $project->id]);
        };

        $createProject();
        $createProject();
        DB::enableQueryLog();
        try {
            DB::flushQueryLog();
            $this->get('/')->assertOk();
            $smallCount = count(DB::getQueryLog());
            for ($index = 0; $index < 4; $index++) {
                $createProject();
            }
            DB::flushQueryLog();
            $response = $this->get('/')->assertOk();
            $largeCount = count(DB::getQueryLog());

            $this->assertLessThanOrEqual($smallCount, $largeCount);
            $project = $response->viewData('projects')->first();
            $this->assertTrue($project->relationLoaded('galleryImages'));
            $this->assertTrue($project->caseStudy->relationLoaded('colors'));
            $this->assertTrue($project->caseStudy->sections->first()->relationLoaded('steps'));
            $this->assertTrue($project->caseStudy->sections->first()->relationLoaded('images'));
        } finally {
            DB::disableQueryLog();
            DB::flushQueryLog();
        }
    }

    public function test_technology_grid_uses_local_symbols_without_loading_article_bodies(): void
    {
        $category = BlogCategory::create(['name' => 'فناوری', 'slug' => 'programming-stacks']);
        BlogPost::create([
            'blog_category_id' => $category->id,
            'slug' => 'react-guide',
            'title' => 'راهنمای ری‌اکت',
            'content' => str_repeat('ARTICLE_BODY_NOT_NEEDED_ON_HOME ', 1000),
            'cover_image' => 'https://cdn.simpleicons.org/react/61dafb',
            'is_published' => true,
            'published_at' => now()->subMinute(),
        ]);

        $response = $this->get('/')->assertOk()
            ->assertSee('class="stack-logo-grid"', false)
            ->assertSee(config('website-media.stack_sprite').'#react', false)
            ->assertDontSee('cdn.simpleicons.org', false)
            ->assertDontSee('ARTICLE_BODY_NOT_NEEDED_ON_HOME');
        $this->assertArrayNotHasKey('content', $response->viewData('stackPosts')->first()->getAttributes());
        $sprite = public_path(config('website-media.stack_sprite'));
        $this->assertFileExists($sprite);
        $xml = simplexml_load_file($sprite);
        $xml->registerXPathNamespace('svg', 'http://www.w3.org/2000/svg');
        $this->assertCount(14, $xml->xpath('//svg:symbol'));
    }

    public function test_optimized_covers_preserve_uploaded_and_external_media_fallbacks(): void
    {
        foreach (config('website-media.previews') as $source => $preview) {
            $this->assertFileExists(public_path($preview.'-640.webp'));
            $this->assertFileExists(public_path($preview.'-1120.webp'));
            $this->assertStringEndsWith($preview.'-640.webp', WebsiteMediaUrl::previewFor($source, 640));
            $this->assertStringEndsWith($preview.'-1120.webp', WebsiteMediaUrl::previewFor('https://flowsee.ir/'.$source));
            $this->assertStringContainsString('640w', WebsiteMediaUrl::previewSrcsetFor($source));
        }
        foreach (['case-studies/new-upload.webp', 'https://example.test/assets/cover.jpg'] as $source) {
            $this->assertSame(WebsiteMediaUrl::for($source), WebsiteMediaUrl::previewFor($source));
            $this->assertNull(WebsiteMediaUrl::previewSrcsetFor($source));
        }
    }
}
