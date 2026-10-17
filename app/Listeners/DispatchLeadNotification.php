<?php

namespace App\Listeners;

use App\Events\LeadCreated;
use App\Jobs\SendLeadNotification;

class DispatchLeadNotification
{
    public function handle(LeadCreated $event): void
    {
        SendLeadNotification::dispatch($event);
    }
}
