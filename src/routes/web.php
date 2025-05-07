<?php

use App\Http\Controllers\GoogleCalendarController;
use Illuminate\Support\Facades\Route;
use Modules\Home\Http\Controllers\HomeController;

Route::get('/', [HomeController::class, 'index'])->name('home');

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');

    // to be configured

    Route::get('/about', function () {
        return view('about');
    })->name('about');

    Route::get('/services', function () {
        return view('services');
    })->name('services');

    Route::get('/contact', function () {
        return view('contact');
    })->name('contact');

    Route::get('/curalex', function () {
        return view('curalex');
    })->name('curalex');

    Route::get('/curavox', function () {
        return view('curavox');
    })->name('curavox');

    Route::get('/curatempus', function () {
        return view('curatempus');
    })->name('curatempus');

    Route::get('/blog', function () {
        return view('blog');
    })->name('blog');

    Route::get('/docs', function () {
        return view('docs');
    })->name('docs');

    Route::get('/support', function () {
        return view('support');
    })->name('support');

    Route::get('/terms', function () {
        return view('terms');
    })->name('terms');

    Route::get('/help', function () {
        return view('help');
    })->name('help');

    Route::get('/privacy', function () {
        return view('privacy');
    })->name('privacy');

    Route::get('/cookies', function () {
        return view('cookies');
    })->name('cookies');

    Route::get('/terms', function () {
        return view('terms');
    })->name('terms');
});

Route::get('/auth/google', [GoogleCalendarController::class, 'redirectToGoogle']);
Route::get('/auth/google/callback', [GoogleCalendarController::class, 'handleGoogleCallback']);