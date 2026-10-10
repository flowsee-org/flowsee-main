<?php

namespace Tests\Feature;

use App\Filament\Resources\Leads\Pages\ListLeads;
use App\Models\Lead;
use App\Models\User;
use Carbon\CarbonImmutable;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;
use Tests\TestCase;

class AdminLeadsTest extends TestCase
{
    use RefreshDatabase;

    public function test_lead_panel_requires_login_and_does_not_allow_regular_users(): void
    {
        $this->get('/admin/login')->assertOk();
        $this->get('/admin/leads')->assertRedirect('/admin/login');

        $user = User::create([
            'name' => 'کاربر عادی',
            'email' => 'user@example.test',
            'password' => 'a-secure-test-password',
            'is_admin' => false,
        ]);

        $this->actingAs($user)->get('/admin/leads')->assertForbidden();
    }

    public function test_admin_can_open_lead_list_with_service_and_status_filters(): void
    {
        $admin = User::create([
            'name' => 'مدیر تست',
            'email' => 'admin@example.test',
            'password' => 'a-secure-test-password',
            'is_admin' => true,
        ]);

        $lead = Lead::create([
            'name' => 'مشتری تست',
            'phone' => '09123456789',
            'service' => 'branding',
            'details' => 'درخواست طراحی هویت بصری',
        ]);

        $this->actingAs($admin)
            ->get('/admin/leads')
            ->assertOk()
            ->assertSee('درخواست‌ها')
            ->assertSee('خدمت درخواستی')
            ->assertSee('09123456789')
            ->assertSee('درخواست طراحی هویت بصری');

        $this->assertSame('fa', app()->getLocale());

        Livewire::actingAs($admin)
            ->test(ListLeads::class)
            ->assertTableFilterExists('service')
            ->assertTableFilterExists('status')
            ->assertTableFilterExists('created_at')
            ->assertCanSeeTableRecords([$lead])
            ->call('updateTableColumnState', 'status', (string) $lead->getKey(), 'contacted');

        $this->assertDatabaseHas('leads', [
            'id' => $lead->getKey(),
            'status' => 'contacted',
        ]);
    }

    public function test_lead_list_filters_by_requested_service_and_submission_date(): void
    {
        $admin = User::create([
            'name' => 'مدیر فیلتر',
            'email' => 'filter-admin@example.test',
            'password' => 'a-secure-test-password',
            'is_admin' => true,
        ]);

        $recentBrandingLead = Lead::create([
            'name' => 'درخواست نزدیک',
            'phone' => '09123456789',
            'service' => 'branding',
            'details' => 'درخواست جدید',
        ]);
        $oldUiLead = Lead::create([
            'name' => 'درخواست قدیمی',
            'phone' => '09123456780',
            'service' => 'uiux',
            'details' => 'درخواست قدیمی',
        ]);
        $oldUiLead->forceFill([
            'created_at' => CarbonImmutable::now()->subDays(10),
            'updated_at' => CarbonImmutable::now()->subDays(10),
        ])->save();

        Livewire::actingAs($admin)
            ->test(ListLeads::class)
            ->filterTable('service', 'branding')
            ->assertCanSeeTableRecords([$recentBrandingLead])
            ->assertCanNotSeeTableRecords([$oldUiLead]);

        Livewire::actingAs($admin)
            ->test(ListLeads::class)
            ->filterTable('created_at', [
                'from' => CarbonImmutable::now()->subDay()->format('Y-m-d'),
                'until' => CarbonImmutable::now()->format('Y-m-d'),
            ])
            ->assertCanSeeTableRecords([$recentBrandingLead])
            ->assertCanNotSeeTableRecords([$oldUiLead]);
    }
}
