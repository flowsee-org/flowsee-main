<?php

namespace Tests\Feature;

use App\Models\Lead;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class StudioWebsiteMessagesTest extends TestCase
{
    use RefreshDatabase;

    public function test_only_a_flowsee_admin_can_issue_a_read_only_studio_token(): void
    {
        $this->get('/admin/studio-messages-connect')
            ->assertRedirect('/admin/login?studio_messages=1');

        $regularUser = User::create([
            'name' => 'کاربر عادی',
            'email' => 'regular@example.test',
            'password' => 'a-secure-test-password',
            'is_admin' => false,
        ]);

        $this->actingAs($regularUser)
            ->get('/admin/studio-messages-connect')
            ->assertForbidden();
    }

    public function test_admin_can_read_filtered_messages_with_a_short_lived_studio_token(): void
    {
        $admin = User::create([
            'name' => 'مدیر سایت',
            'email' => 'admin@example.test',
            'password' => 'a-secure-test-password',
            'is_admin' => true,
        ]);

        $wanted = Lead::create([
            'name' => 'درخواست هویت بصری',
            'phone' => '09123456789',
            'email' => 'lead@example.test',
            'service' => 'branding',
            'details' => 'طراحی هویت بصری مجموعه',
            'status' => 'new',
            'ip_address' => '192.0.2.1',
            'user_agent' => 'private browser details',
        ]);
        Lead::create([
            'name' => 'درخواست قدیمی',
            'phone' => '09123456780',
            'service' => 'video',
            'details' => 'ساخت ویدیو',
            'status' => 'contacted',
        ]);

        $connect = $this->actingAs($admin)->get('/admin/studio-messages-connect');
        $connect->assertRedirect();
        $fragment = parse_url($connect->headers->get('Location'), PHP_URL_FRAGMENT);
        parse_str((string) $fragment, $fragmentValues);
        $token = $fragmentValues['leadToken'] ?? null;
        $this->assertIsString($token);

        $response = $this->getJson('/api/studio/website-messages?status=new&search=09123456789', [
            'Authorization' => 'Bearer '.$token,
            'Origin' => 'https://studio.flowsee.ir',
        ]);

        $response->assertOk()
            ->assertHeader('Access-Control-Allow-Origin', 'https://studio.flowsee.ir')
            ->assertJsonPath('meta.total', 1)
            ->assertJsonPath('data.0.id', $wanted->id)
            ->assertJsonPath('data.0.email', 'lead@example.test')
            ->assertJsonMissingPath('data.0.ip_address')
            ->assertJsonMissingPath('data.0.user_agent');
    }

    public function test_studio_api_rejects_invalid_tokens_and_allows_only_studio_preflight(): void
    {
        $this->getJson('/api/studio/website-messages', [
            'Authorization' => 'Bearer invalid.token',
            'Origin' => 'https://studio.flowsee.ir',
        ])->assertUnauthorized()
            ->assertHeader('Access-Control-Allow-Origin', 'https://studio.flowsee.ir');

        $this->call('OPTIONS', '/api/studio/website-messages', [], [], [], [
            'HTTP_ORIGIN' => 'https://studio.flowsee.ir',
            'HTTP_ACCESS_CONTROL_REQUEST_METHOD' => 'GET',
            'HTTP_ACCESS_CONTROL_REQUEST_HEADERS' => 'authorization',
        ])->assertNoContent()
            ->assertHeader('Access-Control-Allow-Methods', 'GET, OPTIONS');

        $this->call('OPTIONS', '/api/studio/website-messages', [], [], [], [
            'HTTP_ORIGIN' => 'https://untrusted.example',
        ])->assertNoContent()
            ->assertHeaderMissing('Access-Control-Allow-Credentials');
    }
}
