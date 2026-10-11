<?php

use Illuminate\Support\Facades\Route;

Route::view('/', 'home')->name('home');
Route::redirect('/felosi-home-before-about-v2.html', '/', 301);
Route::redirect('/felosi-home.html', '/', 301);
Route::redirect('/felosi-home-v2.html', '/', 301);
Route::redirect('/ebrahimi-case-study.html', '/projects/ebrahimi', 301);

Route::view('/projects/ebrahimi', 'case-study')->name('projects.ebrahimi');
