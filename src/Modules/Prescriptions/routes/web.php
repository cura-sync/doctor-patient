<?php

use Illuminate\Support\Facades\Route;
use Modules\Prescriptions\Http\Controllers\AlarmController;
use Modules\Prescriptions\Http\Controllers\PrescriptionsController;

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

Route::prefix('prescriptions')->group(function () {
    Route::controller(PrescriptionsController::class)->group(function () {
        Route::get('/', 'index')->name('prescriptions.index');
        Route::post('/translate', 'translate')->name('jxDocumentTranslate');
        Route::post('/jxfetchData', 'fetchData')->name('jxfetchData');
        Route::get('/view/{id}', 'viewTransaction')->name('viewTransaction');
    });
});

Route::prefix('alarm')->group(function () {
    Route::controller(AlarmController::class)->group(function () {
        Route::get('/', 'index')->name('alarm.index');
        Route::post('/jxFetchDosage', 'fetchDosage')->name('jxFetchDosage');
        Route::post('/jxSaveDosage', 'saveDosage')->name('jxSaveDosage');
        Route::post('/jxGetCalendarDosage', 'getCalendarDosage')->name('jxGetCalendarDosage');
        Route::post('/jxAddDosageToGoogleCalendar', 'addDosageToGoogleCalendar')->name('jxAddDosageToGoogleCalendar');
    });
});
