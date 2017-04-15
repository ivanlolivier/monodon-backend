<?php

use App\Http\Controllers\AppointmentController;
use App\Http\Controllers\ClinicController;
use App\Http\Controllers\Clinics\MessageController;
use Illuminate\Routing\Router;

/** @var Router $router */

$router->post('/', ClinicController::class . '@store');

$router->group(['prefix' => '/{clinic}'], function (Router $router) {

    $router->group(['middleware' => 'auth:employee,dentist,patient'], function (Router $router) {
        $router->get('/', ClinicController::class . '@show');
    });

    $router->group(['middleware' => 'auth:employee'], function (Router $router) {
        $router->put('/', ClinicController::class . '@update');

        $router->group(['prefix' => '/patients'], function (Router $router) {
            $router->get('/', ClinicController::class . '@patients');
            //TODO: ver como dar de alta un paciente
//            $router->post('/', AppointmentController::class . '@createForClinic');
//            $router->put('/{appointment}', AppointmentController::class . '@updateForClinic');
//            $router->delete('/{appointment}', AppointmentController::class . '@deleteForClinic');
        });

        $router->group(['prefix' => '/invitations'], function (Router $router) {
            $router->get('/{token}', ClinicController::class . '@invitation');
            $router->get('/', ClinicController::class . '@invitations');
            $router->post('/', ClinicController::class . '@sendInvitationToDentist');
        });

        $router->patch('/linkdentists', ClinicController::class . '@linkDentist');
        $router->group(['prefix' => '/dentists'], function (Router $router) {
            $router->get('/', ClinicController::class . '@dentists');
            $router->post('/', ClinicController::class . '@createDentist');
        });

        $router->group(['prefix' => '/appointments'], function (Router $router) {
            $router->get('/', AppointmentController::class . '@listForClinic');
            $router->post('/', AppointmentController::class . '@createForClinic');
            $router->put('/{appointment}', AppointmentController::class . '@updateForClinic');
            $router->delete('/{appointment}', AppointmentController::class . '@deleteForClinic');
        });

        $router->group(['prefix' => '/messages'], function (Router $router) {
            $router->get('/', MessageController::class . '@listof');
            $router->get('/{message}', MessageController::class . '@show');
            $router->post('/', MessageController::class . '@create');
        });

    });

});


