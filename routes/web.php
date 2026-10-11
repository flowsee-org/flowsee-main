<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::view('/', 'home')->name('home');
Route::redirect('/felosi-home-before-about-v2.html', '/', 301);
Route::redirect('/felosi-home.html', '/', 301);
Route::redirect('/felosi-home-v2.html', '/', 301);
Route::redirect('/ebrahimi-case-study.html', '/projects/ebrahimi', 301);

Route::view('/projects/ebrahimi', 'case-study')->name('projects.ebrahimi');

// Issue a short-lived, read-only credential for Studio. The credential is
// returned in a URL fragment and is never sent in an HTTP request or access log.
Route::get('/admin/studio-messages-connect', function (Request $request) {
    $user = $request->user();

    if (! $user) {
        return redirect('/admin/login?studio_messages=1');
    }

    abort_unless($user->is_admin, 403);

    $payload = rtrim(strtr(base64_encode(json_encode([
        'sub' => (string) $user->getAuthIdentifier(),
        'scope' => 'website-messages:read',
        'exp' => now()->addMinutes(60)->timestamp,
    ], JSON_THROW_ON_ERROR)), '+/', '-_'), '=');
    $signature = hash_hmac('sha256', $payload, (string) config('app.key'));

    return redirect()->away('https://studio.flowsee.ir/website-messages#leadToken='.$payload.'.'.$signature);
})->name('admin.studio-messages-connect');
