<?php

namespace Tests\Feature;

use App\Models\Service;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Cache;
use Tests\TestCase;

class HomePageTest extends TestCase
{
    use RefreshDatabase;

    public function test_homepage_reads_service_models_even_when_legacy_cache_contains_labels(): void
    {
        $service = Service::factory()->create([
            'slug' => 'cache-regression',
            'title' => 'خدمت زنده از دیتابیس',
            'is_active' => true,
            'is_highlighted' => true,
        ]);
        Service::factory()->create([
            'slug' => 'inactive-regression',
            'title' => 'خدمت غیرفعال',
            'is_active' => false,
        ]);

        Cache::put('flowsee.home.services', collect([
            'cache-regression' => 'برچسب قدیمی کش',
        ]), now()->addMinutes(5));

        try {
            $this->get('/')
                ->assertOk()
                ->assertViewHas('services', fn ($services) =>
                    $services->count() === 1
                    && $services->first() instanceof Service
                    && $services->first()->id === $service->id
                )
                ->assertSee('خدمت زنده از دیتابیس')
                ->assertDontSee('خدمت غیرفعال')
                ->assertDontSee('برچسب قدیمی کش');
        } finally {
            Cache::forget('flowsee.home.services');
        }
    }

    public function test_home_page_renders_service_dialog_icon_container(): void
    {
        $response = $this->get('/');
        $response->assertOk();
        $response->assertSee('id="service-dialog-icon"', false);
    }

    public function test_projects_data_is_properly_json_escaped_against_xss(): void
    {
        $response = $this->get('/');
        $response->assertOk();
        $response->assertSee('window.projectsData = ', false);
        $response->assertDontSee('window.projectsData = {!!', false);
    }

    public function test_projects_data_is_rendered_as_json_array_not_double_encoded_string(): void
    {
        \App\Models\Project::factory()->create([
            'is_active' => true,
            'name' => 'Test Project',
            'slug' => 'test-project',
        ]);

        $response = $this->get('/');
        $response->assertOk();

        $this->assertSame(1, preg_match('/window\.projectsData = (.+);/', $response->getContent(), $matches));
        $projectsData = json_decode($matches[1], true, flags: JSON_THROW_ON_ERROR);

        $this->assertIsArray($projectsData);
        $this->assertTrue(array_is_list($projectsData));
        $this->assertContains('test-project', array_column($projectsData, 'slug'));
    }
}
