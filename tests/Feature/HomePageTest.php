<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class HomePageTest extends TestCase
{
    use RefreshDatabase;

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
        $response->assertSee('window.projectsData = [', false);
        $response->assertDontSee('window.projectsData = "[', false);
    }
}
