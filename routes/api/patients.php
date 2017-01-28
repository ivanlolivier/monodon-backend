<?php

use App\Http\Controllers\PatientController;

Route::group([
    'middleware' => 'auth:patient',
    'prefix'     => '/me'
], function () {
    Route::get('/', PatientController::class . '@me');
    Route::put('/', PatientController::class . '@updateMe');

    Route::get('/photo', PatientController::class . '@photoMe');
    Route::post('/information', PatientController::class . '@information');

    Route::get('/clinics', PatientController::class . '@clinicsMe');
    Route::get('/clinics/{clinic}', PatientController::class . '@clinicMe');

    Route::get('/notifications', PatientController::class . '@notifications');
});

Route::group(['middleware' => 'auth:dentist,employee'], function () {
    Route::get('/{patient}', PatientController::class . '@show');
    Route::post('/', PatientController::class . '@store');
    Route::put('/{patient}', PatientController::class . '@update');
});
