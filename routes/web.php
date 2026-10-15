<?php

use App\Http\Controllers\ProjectController;
use App\Http\Controllers\BlogController;
use Illuminate\Support\Facades\Route;

Route::get('/', [ProjectController::class, 'index'])->name('home');
Route::get('/blog-sitemap.xml', [BlogController::class, 'sitemap'])->name('blog.sitemap');
Route::get('/blog', [BlogController::class, 'index'])->name('blog.index');
Route::get('/blog/{slug}', [BlogController::class, 'show'])->name('blog.show');
Route::get('/projects/{slug}', [ProjectController::class, 'show'])->name('projects.show');

Route::redirect('/felosi-home-before-about-v2.html', '/', 301);
Route::redirect('/felosi-home.html', '/', 301);
Route::redirect('/felosi-home-v2.html', '/', 301);
Route::redirect('/ebrahimi-case-study.html', '/projects/ebrahimi', 301);
