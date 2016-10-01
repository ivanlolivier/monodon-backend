<?php

use App\Http\Controllers\ClinicController;
use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| Dentists API Routes
|--------------------------------------------------------------------------
*/

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:employees');

/*
|--------------------------------------------------------------------------
| Employees API Routes
|--------------------------------------------------------------------------
*/

Route::post('clinics', ClinicController::class . '@store');
Route::get('/clinics/{clinic}', ClinicController::class . '@show');
Route::put('/clinics/{clinic}', ClinicController::class . '@update');