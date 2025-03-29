<?php

use Illuminate\Support\Facades\Route;
use Modules\Bills\Http\Controllers\BillsController;

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

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::prefix('bills')->group(function () {
        Route::controller(BillsController::class)->group(function () {
            Route::get('/', 'index')->name('bills.index');
        });
    });
});
