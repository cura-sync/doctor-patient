<?php

use Illuminate\Support\Facades\Route;
use Modules\Playground\Http\Controllers\PlaygroundController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::prefix('playground')->group(function () {
    Route::controller(PlaygroundController::class)->group(function () {
        Route::get('/', 'index')->name('playground.index');
    });
});