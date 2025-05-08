<?php

use Illuminate\Support\Facades\Route;
use Modules\AudioTranslation\Http\Controllers\AudioTranslatorController;
use Modules\AudioTranslation\Http\Controllers\PrescriptionTemplateController;

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

Route::prefix('audioTranslation')->group(function () {
    Route::controller(AudioTranslatorController::class)->group(function () {
        Route::get('/', 'index')->name('audioTranslation.index');
        Route::post('/jxProcessUploadedAudio', 'processUploadedAudio')->name('jxProcessUploadedAudio');
        Route::post('/jxfetchData', 'fetchData')->name('jxfetchData');
        Route::get('/view/{id}', 'viewTransaction')->name('audioTranslation.view');
    });

    Route::prefix('prescriptionTemplate')->group(function () {
        Route::controller(PrescriptionTemplateController::class)->group(function () {
            Route::get('/', 'index')->name('prescriptionTemplate.index');
        });
    });
});