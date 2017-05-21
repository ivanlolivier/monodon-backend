<?php

/** @var Router $router */

use App\Http\Controllers\Auth\ForgotPasswordController;
use App\Http\Controllers\Auth\ResetPasswordController;
use App\Http\Controllers\EmployeeTypeController;
use App\Http\Controllers\QuestionController;
use Illuminate\Routing\Router;

/******************
 * AUTH ENDPOINTS *
 ******************/
$router->post('password/email', ForgotPasswordController::class . '@sendResetLinkEmail');
$router->put('password/reset', ResetPasswordController::class . '@reset');

/*******************
 * LISTS ENDPOINTS *
 *******************/
$router->get('employee_types', EmployeeTypeController::class . '@index');
$router->group(['middleware' => 'auth:dentist'], function (Router $router) {
    $router->get('/questions', QuestionController::class . '@index');
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


use LaravelFCM\Facades\FCM;
use LaravelFCM\Message\OptionsBuilder;
use LaravelFCM\Message\PayloadDataBuilder;
use LaravelFCM\Message\PayloadNotificationBuilder;

$router->get('push', function () {
    $optionBuiler = new OptionsBuilder();
    $optionBuiler->setTimeToLive(60 * 20);

    $notificationBuilder = new PayloadNotificationBuilder('my title');
    $notificationBuilder->setBody('Hello world')
        ->setSound('default');

    $dataBuilder = new PayloadDataBuilder();
    $dataBuilder->addData(['a_data' => 'my_data']);

    $option = $optionBuiler->build();
    $notification = $notificationBuilder->build();
    $data = $dataBuilder->build();

    $token = "fLur_i7rLco:APA91bFYKQkFqkEBUWBAB9thZ4ddAkQmgrMs372Abpqqpcnabi4-Xu7OvLOfz4SoxjN3dJQzUglfc-rexZzGD1ExOKK-QANeDoVXgUhIHYv3bDX-zNtEl0LIHkp6G3UK2GM_hcptigCk";

    FCM::sendTo($token, $option, $notification, $data);
});
