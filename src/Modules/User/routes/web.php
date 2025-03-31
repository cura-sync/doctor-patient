<?php

use Illuminate\Support\Facades\Route;
use Modules\User\Http\Controllers\UserController;

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
    Route::prefix('user')->group(function () {
        Route::controller(UserController::class)->group(function () {
            Route::get('/', 'index')->name('user.index');
            Route::post('/jxFetchUserTransactions', 'fetchUserTransactions')->name('jxFetchUserTransactions');
            Route::post('/jxDeleteTransaction', 'deleteTransaction')->name('jxDeleteTransaction');
            Route::post('/jxToggleGoogleConnection', 'toggleGoogleConnection')->name('jxToggleGoogleConnection');
            Route::post('/jxCheckGoogleConnection', 'checkGoogleConnection')->name('jxCheckGoogleConnection');
            Route::get('/transactions', 'transactions')->name('user.transactions');
        });
    });
});