<?php

use App\Http\Controllers\Api\LeadController;
use App\Http\Controllers\BlogController;
use App\Http\Controllers\Api\StudioSiteContentController;
use App\Http\Controllers\Api\StudioWebsiteMessagesController;
use App\Http\Middleware\AllowStudioWebsiteMessages;
use Illuminate\Support\Facades\Route;

Route::get('/blog', [BlogController::class, 'feed'])->name('api.blog.index');

Route::post('/leads', [LeadController::class, 'store'])
    ->middleware('throttle:5,1')
    ->name('api.leads.store');

Route::middleware(AllowStudioWebsiteMessages::class)->group(function (): void {
    Route::options('/studio/website-messages', fn () => response()->noContent());
    Route::get('/studio/website-messages', [StudioWebsiteMessagesController::class, 'index']);

    Route::options('/studio/site-content/{path?}', fn () => response()->noContent())->where('path', '.*');
    Route::get('/studio/site-content', [StudioSiteContentController::class, 'index']);
    Route::post('/studio/site-content/projects', [StudioSiteContentController::class, 'storeProject']);
    Route::put('/studio/site-content/projects/{project}', [StudioSiteContentController::class, 'updateProject']);
    Route::delete('/studio/site-content/projects/{project}', [StudioSiteContentController::class, 'destroyProject']);
    Route::put('/studio/site-content/projects/{project}/case-study', [StudioSiteContentController::class, 'saveCaseStudy']);
    Route::delete('/studio/site-content/projects/{project}/case-study', [StudioSiteContentController::class, 'deleteCaseStudy']);
    Route::post('/studio/site-content/images', [StudioSiteContentController::class, 'uploadImage']);
    Route::get('/studio/site-content/blog', [StudioSiteContentController::class, 'blogIndex']);
    Route::post('/studio/site-content/blog', [StudioSiteContentController::class, 'storeBlogPost']);
    Route::put('/studio/site-content/blog/{post}', [StudioSiteContentController::class, 'updateBlogPost']);
    Route::delete('/studio/site-content/blog/{post}', [StudioSiteContentController::class, 'destroyBlogPost']);
});
