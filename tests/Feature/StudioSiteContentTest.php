<?php

namespace Tests\Feature;

use App\Models\Project;
use App\Models\Service;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Http;
use Tests\TestCase;

class StudioSiteContentTest extends TestCase
{
    use RefreshDatabase;

    public function test_site_content_api_requires_the_studio_session(): void
    {
        $this->withHeader('Origin', 'https://studio.flowsee.ir')
            ->getJson('/api/studio/site-content')
            ->assertUnauthorized()
            ->assertHeader('Access-Control-Allow-Origin', 'https://studio.flowsee.ir');
    }

    public function test_project_and_case_study_management_are_not_registered_in_the_laravel_admin_panel(): void
    {
        $this->get('/admin/projects')->assertNotFound();
        $this->get('/admin/case-studies')->assertNotFound();
    }

    public function test_site_content_api_is_limited_to_the_primary_studio_superadmin(): void
    {
        Http::fake([
            'studio.flowsee.ir/*' => Http::response([
                'id' => 'staff-1',
                'email' => 'staff@flowsee.local',
                'role' => 'admin',
            ]),
        ]);

        $this->withToken('valid-studio-session')->getJson('/api/studio/site-content')->assertForbidden();
    }

    public function test_primary_studio_superadmin_can_manage_site_projects_and_case_studies(): void
    {
        Http::fake([
            'studio.flowsee.ir/*' => Http::response([
                'id' => 'ceo-1',
                'email' => 'ceo@flowsee.local',
                'role' => 'superadmin',
            ]),
        ]);

        $service = Service::create([
            'slug' => 'branding',
            'title' => 'هویت بصری',
            'description' => 'خدمات برندینگ',
            'icon' => 'palette',
        ]);

        $projectResponse = $this->withToken('primary-admin-session')->postJson('/api/studio/site-content/projects', [
            'name' => 'پروژه آزمایشی سایت',
            'slug' => 'studio-content-test',
            'description' => 'توضیح پروژه',
            'cover_image' => 'projects/covers/test.webp',
            'service_id' => $service->id,
            'is_featured' => true,
            'has_case_study' => false,
            'is_active' => true,
            'sort_order' => 1,
            'gallery_images' => [['path' => 'projects/gallery/test.webp', 'layout' => 'full']],
        ])->assertCreated()->assertJsonPath('project.name', 'پروژه آزمایشی سایت');

        $projectId = $projectResponse->json('project.id');
        $this->assertDatabaseHas('projects', ['id' => $projectId, 'service_id' => $service->id]);
        $this->assertDatabaseHas('gallery_images', ['project_id' => $projectId, 'path' => 'projects/gallery/test.webp']);

        $this->putJson("/api/studio/site-content/projects/{$projectId}/case-study", [
            'slug' => 'studio-content-test',
            'title' => 'کیس‌استادی آزمایشی',
            'lead' => 'توضیحات کوتاه',
            'theme_color' => '#123456',
            'is_published' => true,
            'sections' => [[
                'slug' => 'strategy',
                'title' => 'استراتژی',
                'lead' => 'شرح بخش',
                'steps' => [['title' => 'پژوهش', 'description' => 'گام اول']],
                'images' => [['path' => 'case-studies/gallery.webp', 'layout' => 'half']],
            ]],
            'colors' => [['name' => 'آبی', 'hex' => '#123456']],
        ])->assertOk()->assertJsonPath('case_study.title', 'کیس‌استادی آزمایشی');

        $this->assertDatabaseHas('projects', ['id' => $projectId, 'has_case_study' => true]);
        $this->assertDatabaseHas('case_studies', ['project_id' => $projectId, 'slug' => 'studio-content-test']);
        $this->assertDatabaseHas('case_study_steps', ['title' => 'پژوهش']);
        $this->assertDatabaseHas('color_palette', ['name' => 'آبی', 'hex' => '#123456']);

        $this->deleteJson("/api/studio/site-content/projects/{$projectId}/case-study")->assertOk();
        $this->assertDatabaseMissing('case_studies', ['project_id' => $projectId]);
        $this->assertDatabaseHas('projects', ['id' => $projectId, 'has_case_study' => false]);
    }
}
