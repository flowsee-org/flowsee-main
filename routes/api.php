<?php

use App\Http\Controllers\Api\LeadController;
use Illuminate\Support\Facades\Route;

Route::post('/leads', [LeadController::class, 'store'])
    ->middleware('throttle:5,1')
    ->name('api.leads.store');
