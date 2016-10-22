<?php

use App\Http\Controllers\ClinicController;

Route::post('/', ClinicController::class . '@store');

Route::group(['middleware' => 'auth:employee,dentist,patient'], function () {
    Route::get('/{clinic}', ClinicController::class . '@show');
});

Route::group(['middleware' => 'auth:employee'], function () {
    Route::put('/{clinic}', ClinicController::class . '@update');
});