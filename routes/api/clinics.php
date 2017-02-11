<?php

use App\Http\Controllers\AppointmentController;
use App\Http\Controllers\ClinicController;
use Illuminate\Routing\Router;

/** @var Router $router */

$router->post('/', ClinicController::class . '@store');

$router->group(['middleware' => 'auth:employee,dentist,patient'], function (Router $router) {
    $router->get('/{clinic}', ClinicController::class . '@show');
});

$router->group(['middleware' => 'auth:employee'], function (Router $router) {
    $router->put('/{clinic}', ClinicController::class . '@update');
    $router->get('/{clinic}/patients', ClinicController::class . '@patients');
    $router->get('/{clinic}/dentists', ClinicController::class . '@dentists');

    $router->get('/{clinic}/appointments', AppointmentController::class . '@listForClinic');
    $router->post('/{clinic}/appointments', AppointmentController::class . '@createForClinic');
});
