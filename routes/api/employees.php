<?php

use App\Http\Controllers\EmployeeController;

Route::group(['middleware' => 'auth:employee'], function () {
    Route::get('/me', EmployeeController::class . '@showMe');
    Route::put('/me', EmployeeController::class . '@updateMe');
});
