<?php

use App\Http\Controllers\ClinicController;
use App\Http\Controllers\EmployeeController;
use Illuminate\Routing\Router;
use Illuminate\Support\Facades\Auth;

/** @var Router $router */

$router->group(['middleware' => 'auth:employee'], function (Router $router) {

    $router->group(['prefix' => '/me'], function (Router $router) {
        $router->get('/', EmployeeController::class . '@showMe');
        $router->put('/', EmployeeController::class . '@updateMe');

        $router->group(['prefix' => '/clinic'], function (Router $router) {

            $router->get('/', function () {
                return (new ClinicController)->show(Auth::user()->clinic);
            });
//            $router->get('/', EmployeeController::class . '@clinic');
            $router->put('/', EmployeeController::class . '@updateClinic');

//        - GET employees/me/clinics/appointments
//        - POST employees/me/clinics/appointments
//        - PUT employees/me/clinics/appointments
//        - DELETE employees/me/clinics/appointments
            $router->get('clinic/appointments', EmployeeController::class . '@clinicAppointments');
//
//        - GET employees/me/clinics/dentists
//        - POST employees/me/clinics/dentists
//
//        - GET employees/me/clinics/patients
//        - POST employees/me/clinics/patients
//        - PUT employees/me/clinics/patients
//
//        - GET employees/me/clinics/messages
//        - POST employees/me/clinics/messages

        });


    });
});
