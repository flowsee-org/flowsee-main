<?php

namespace Tests\Feature;

use App\Models\Lead;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Http;
use Tests\TestCase;

class StudioWebsiteMessagesTest extends TestCase
{
    use RefreshDatabase;

    public function test_studio_superadmin_can_read_messages_without_a_separate_flowsee_account(): void
    {
        Http::fake([
            'studio.flowsee.ir/api/apps/flowsee-preview/entities/User/me' => Http::response([
                'email' => 'studio-superadmin@example.test',
                'role' => 'superadmin',
            ], 200),
        ]);

        $this->getJson('/api/studio/website-messages', [
            'Authorization' => 'Bearer studio-session-token',
            'Origin' => 'https://studio.flowsee.ir',
        ])->assertOk();
    }

    public function test_non_superadmin_is_denied(): void
    {
        Http::fake([
            'studio.flowsee.ir/api/apps/flowsee-preview/entities/User/me' => Http::response([
                'email' => 'admin@example.test',
                'role' => 'admin',
            ], 200),
        ]);

        $this->getJson('/api/studio/website-messages', [
            'Authorization' => 'Bearer studio-session-token',
        ])->assertForbidden();
    }

    public function test_admin_can_read_filtered_messages_without_private_tracking_fields(): void
    {
        Http::fake([
            'studio.flowsee.ir/api/apps/flowsee-preview/entities/User/me' => Http::response([
                'email' => 'admin@example.test',
                'role' => 'superadmin',
            ], 200),
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

        $this->getJson('/api/studio/website-messages?status=new&search=09123456789', [
            'Authorization' => 'Bearer studio-session-token',
            'Origin' => 'https://studio.flowsee.ir',
        ])->assertOk()
            ->assertHeader('Access-Control-Allow-Origin', 'https://studio.flowsee.ir')
            ->assertJsonPath('meta.total', 1)
            ->assertJsonPath('data.0.id', $wanted->id)
            ->assertJsonPath('data.0.email', 'lead@example.test')
            ->assertJsonMissingPath('data.0.ip_address')
            ->assertJsonMissingPath('data.0.user_agent');
    }

    public function test_expired_studio_session_and_preflight_behavior(): void
    {
        Http::fake([
            'studio.flowsee.ir/api/apps/flowsee-preview/entities/User/me' => Http::response([], 401),
        ]);

        $this->getJson('/api/studio/website-messages', [
            'Authorization' => 'Bearer expired-studio-session',
            'Origin' => 'https://studio.flowsee.ir',
        ])->assertUnauthorized()
            ->assertHeader('Access-Control-Allow-Origin', 'https://studio.flowsee.ir');

        $this->call('OPTIONS', '/api/studio/website-messages', [], [], [], [
            'HTTP_ORIGIN' => 'https://studio.flowsee.ir',
            'HTTP_ACCESS_CONTROL_REQUEST_METHOD' => 'GET',
            'HTTP_ACCESS_CONTROL_REQUEST_HEADERS' => 'authorization',
        ])->assertNoContent()
            ->assertHeader('Access-Control-Allow-Methods', 'GET, OPTIONS');
    }
}
