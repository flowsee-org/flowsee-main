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
}
