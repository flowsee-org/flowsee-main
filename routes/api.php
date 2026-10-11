<?php

use App\Http\Controllers\Api\LeadController;
use App\Http\Controllers\Api\StudioWebsiteMessagesController;
use App\Http\Middleware\AllowStudioWebsiteMessages;
use Illuminate\Support\Facades\Route;

Route::post('/leads', [LeadController::class, 'store'])
    ->middleware('throttle:5,1')
    ->name('api.leads.store');

Route::middleware(AllowStudioWebsiteMessages::class)->group(function (): void {
    Route::options('/studio/website-messages', fn () => response()->noContent());
    Route::get('/studio/website-messages', [StudioWebsiteMessagesController::class, 'index']);
});
