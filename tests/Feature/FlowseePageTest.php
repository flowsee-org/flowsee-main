<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class FlowseePageTest extends TestCase
{
    use RefreshDatabase;

    public function test_homepage_preserves_content_and_instagram_and_loads_mobile_styles(): void
    {
        $this->get('/')->assertOk()->assertSee('طراحی برای')->assertSee('https://www.instagram.com/flowsee.ir/', false)
            ->assertSee('اطلاعات پروژه برای پیگیری در پایگاه دادهٔ فلوسی ثبت می‌شود.')
            ->assertSee('ارسال درخواست')
            ->assertSee('پیام شما با موفقیت ارسال شد')
            ->assertSee('class="required-marker"', false)
            ->assertSee('assets/css/mobile.css', false)->assertSee('assets/js/site.js', false);
        $this->assertStringNotContainsString('localStorage', file_get_contents(public_path('assets/js/site.js')));
    }

    public function test_legacy_addresses_redirect_and_case_study_renders(): void
    {
        $this->get('/felosi-home-before-about-v2.html')->assertRedirect('/');
        $this->get('/ebrahimi-case-study.html')->assertRedirect('/projects/ebrahimi');
        $this->get('/projects/ebrahimi')->assertOk();
        $this->get('/up')->assertOk();
        $this->get('/not-a-page')->assertNotFound();
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
            $this->assertFileExists(public_path(ltrim($path, '/')), $url);
        }
        $this->assertFileExists(public_path('assets/css/mobile.css'));
    }
}
