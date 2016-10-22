<?php

use App\Http\Controllers\ClinicController;
use Illuminate\Support\Facades\Auth;

/*
|--------------------------------------------------------------------------
| Clinics API Routes
|--------------------------------------------------------------------------
*/
Route::post('/clinics', ClinicController::class . '@store');
Route::group(['middleware' => 'auth:employees'], function () {
    Route::get('/clinics/{clinic}', ClinicController::class . '@show');
    Route::put('/clinics/{clinic}', ClinicController::class . '@update');
});


//Route::group(['middleware' => 'auth:employee'], function () {
//    Route::get('/login/employee', function(){
//        dd(Auth::user());
//    });
//});
//Route::group(['middleware' => 'auth:patient'], function () {
//    Route::get('/login/patient', function(){
//        dd(Auth::user());
//    });
//});
//Route::group(['middleware' => 'auth:dentist'], function () {
//    Route::get('/login/dentist', function(){
//        dd(Auth::user());
//    });
//});

/*
|--------------------------------------------------------------------------
| Patients API Routes
|--------------------------------------------------------------------------
*/


/*
|--------------------------------------------------------------------------
| Dentists API Routes
|--------------------------------------------------------------------------
*/


/*
|--------------------------------------------------------------------------
| Employees API Routes
|--------------------------------------------------------------------------
*/