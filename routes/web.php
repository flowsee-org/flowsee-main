<?php

use App\Http\Controllers\ProjectController;
use App\Http\Controllers\BlogController;
use Illuminate\Support\Facades\Route;

Route::get('/', [ProjectController::class, 'index'])->name('home');
Route::get('/product/e-learning', function () {
    $pageTitle = 'طراحی محصول آموزش آنلاین | استودیو فلوسی';
    $pageDescription = 'از طراحی مسیر یادگیری و هویت آموزشی تا ساخت تجربهٔ دیجیتال دوره؛ محصول آموزشی خود را با همراهی استودیو فلوسی آمادهٔ رشد کنید.';
    $pageUrl = 'https://flowsee.ir/product/e-learning';
    $structuredData = [
        '@context' => 'https://schema.org',
        '@type' => 'Service',
        'name' => 'طراحی محصول آموزش آنلاین',
        'serviceType' => 'طراحی تجربهٔ یادگیری و محصول آموزشی دیجیتال',
        'provider' => ['@type' => 'Organization', 'name' => 'استودیو فلوسی', 'url' => 'https://flowsee.ir/'],
        'url' => $pageUrl,
        'description' => $pageDescription,
        'areaServed' => ['@type' => 'Country', 'name' => 'ایران'],
    ];

    return view('product.e-learning', compact('pageTitle', 'pageDescription', 'pageUrl', 'structuredData'));
})->name('product.e-learning');
Route::get('/blog-sitemap.xml', [BlogController::class, 'sitemap'])->name('blog.sitemap');
Route::get('/blog', [BlogController::class, 'index'])->name('blog.index');
Route::get('/blog/{slug}', [BlogController::class, 'show'])->name('blog.show');
Route::get('/projects/{slug}', [ProjectController::class, 'show'])->name('projects.show');

Route::redirect('/felosi-home-before-about-v2.html', '/', 301);
Route::redirect('/felosi-home.html', '/', 301);
Route::redirect('/felosi-home-v2.html', '/', 301);
Route::redirect('/ebrahimi-case-study.html', '/projects/ebrahimi', 301);
