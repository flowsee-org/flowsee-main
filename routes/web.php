<?php

use App\Http\Controllers\ProjectController;
use Illuminate\Support\Facades\Route;

Route::get('/', [ProjectController::class, 'index'])->name('home');
Route::get('/projects/{slug}', [ProjectController::class, 'show'])->name('projects.show');

Route::redirect('/felosi-home-before-about-v2.html', '/', 301);
Route::redirect('/felosi-home.html', '/', 301);
Route::redirect('/felosi-home-v2.html', '/', 301);
Route::redirect('/ebrahimi-case-study.html', '/projects/ebrahimi', 301);
