<?php

namespace Tests\Feature;

use App\Events\LeadCreated;
use App\Jobs\SendLeadNotification;
use App\Listeners\DispatchLeadNotification;
use App\Models\Lead;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Queue;
use Tests\TestCase;

class DispatchLeadNotificationTest extends TestCase
{
    use RefreshDatabase;

    public function test_dispatch_lead_notification_listener_dispatches_job_with_integer_id(): void
    {
        Queue::fake();

        $lead = Lead::create([
            'name' => 'تست لید',
            'phone' => '09120000000',
            'service' => 'branding',
            'details' => 'جزئیات تستی',
        ]);

        $event = new LeadCreated($lead);
        $listener = new DispatchLeadNotification();
        $listener->handle($event);

        Queue::assertPushed(SendLeadNotification::class, function (SendLeadNotification $job) use ($lead) {
            return $job->leadId === $lead->id;
        });
    }
}
