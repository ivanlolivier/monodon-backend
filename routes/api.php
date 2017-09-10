<?php

/** @var Router $router */

use App\Http\Controllers\Auth\ForgotPasswordController;
use App\Http\Controllers\Auth\ResetPasswordController;
use App\Http\Controllers\BuccalZoneController;
use App\Http\Controllers\EmployeeTypeController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\QuestionController;
use App\Http\Controllers\TreatmentController;
use Illuminate\Routing\Router;

/******************
 * AUTH ENDPOINTS *
 ******************/
$router->post('password/email', ForgotPasswordController::class . '@sendResetLinkEmail');
$router->put('password/reset', ResetPasswordController::class . '@reset');

/***********************
 * ENDPOINTS FOR LISTS *
 ***********************/
$router->get('employee_types', EmployeeTypeController::class . '@index');
$router->group(['middleware' => 'auth:dentist'], function (Router $router) {
    $router->get('/questions', QuestionController::class . '@index');
    $router->get('/treatments', TreatmentController::class . '@index');
    $router->get('/buccal_zones', BuccalZoneController::class . '@index');
    $router->get('/notifications/answer_types', NotificationController::class . '@answer_types');
});


/**********************
 * EMPLOYEE ENDPOINTS *
 **********************/
$router->group(['prefix' => '/employees'], function (Router $router) {
    require 'api/employees.php';
});

/********************
 * CLINIC ENDPOINTS *
 ********************/
$router->group(['prefix' => '/clinics'], function (Router $router) {
    require 'api/clinics.php';
});

/*********************
 * PATIENT ENDPOINTS *
 *********************/
$router->group(['prefix' => '/patients'], function (Router $router) {
    require 'api/patients.php';
});

/*********************
 * DENTIST ENDPOINTS *
 *********************/
$router->group(['prefix' => '/dentists'], function (Router $router) {
    require 'api/dentists.php';
});
