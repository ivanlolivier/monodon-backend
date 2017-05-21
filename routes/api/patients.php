<?php

use App\Http\Controllers\PatientController;
use Illuminate\Routing\Router;

/** @var Router $router */

$router->group([
    'middleware' => 'auth:patient',
    'prefix'     => '/me'
], function (Router $router) {
    $router->get('/', PatientController::class . '@me');
    $router->put('/', PatientController::class . '@updateMe');

    $router->get('/photo', PatientController::class . '@photoMe');
    $router->post('/information', PatientController::class . '@information');

    $router->get('/clinics', PatientController::class . '@clinicsMe');
    $router->get('/clinics/{clinic}', PatientController::class . '@clinicMe');

    $router->get('/notifications', PatientController::class . '@notifications');
    $router->put('/notifications/{notificationSent}', PatientController::class . '@updateNotification');

    $router->get('/appointments', PatientController::class . '@nextAppointments');
    $router->delete('/appointments/{appointment}', PatientController::class . '@cancelAppointment');
});

$router->group(['middleware' => 'auth:dentist,employee'], function (Router $router) {
    $router->get('/{patient}', PatientController::class . '@show');
    $router->post('/', PatientController::class . '@store');
    $router->put('/{patient}', PatientController::class . '@update');
});
