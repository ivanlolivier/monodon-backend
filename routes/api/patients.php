<?php

use App\Http\Controllers\PatientController;

Route::group(['middleware' => 'auth:patient'], function () {
    Route::get('/me', PatientController::class . '@me');
    Route::put('/me', PatientController::class . '@updateMe');
    Route::get('/me/photo', PatientController::class . '@photoMe');
});

Route::group(['middleware' => 'auth:dentist,employee'], function () {
    Route::get('/{patient}', PatientController::class . '@show');
    Route::post('/', PatientController::class . '@store');
    Route::put('/{patient}', PatientController::class . '@update');
});

