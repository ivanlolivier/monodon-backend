<?php

use App\Http\Controllers\AppointmentController;
use App\Http\Controllers\ClinicController;
use App\Http\Controllers\Clinics\MessageController;
use App\Http\Controllers\PatientController;
use Illuminate\Routing\Router;

/** @var Router $router */

$router->post('/', ClinicController::class . '@store');

$router->group(['prefix' => '/{clinic}'], function (Router $router) {

    $router->group(['middleware' => 'auth:employee,dentist,patient'], function (Router $router) {
        $router->get('/', ClinicController::class . '@show');
    });

    $router->get('/invitations/{token}', ClinicController::class . '@invitation');
    $router->patch('/invitations/{token}', ClinicController::class . '@updateInvitation');

    $router->patch('/linkdentists', ClinicController::class . '@linkDentist');
    $router->group(['prefix' => '/dentists'], function (Router $router) {
        $router->post('/', ClinicController::class . '@registerDentistAndJoinClinic');
    });

    $router->group(['middleware' => 'auth:employee,dentist'], function (Router $router) {
        $router->group(['prefix' => '/patients'], function (Router $router) {
            $router->get('/', ClinicController::class . '@patients');
            $router->post('/', PatientController::class . '@createForClinic');
            $router->get('/{patient}', PatientController::class . '@showForClinic');
            $router->put('/{patient}', PatientController::class . '@updateForClinic');
        });
    });

    $router->group(['middleware' => 'auth:employee,dentist'], function (Router $router) {
        $router->put('/', ClinicController::class . '@update');

        $router->group(['prefix' => '/invitations'], function (Router $router) {
            $router->get('/', ClinicController::class . '@invitations');
            $router->post('/', ClinicController::class . '@sendInvitationToDentist');
        });

        $router->group(['prefix' => '/dentists'], function (Router $router) {
            $router->get('/', ClinicController::class . '@dentists');
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


