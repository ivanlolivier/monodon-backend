<?php

/** @var Router $router */

use App\Http\Controllers\Auth\ForgotPasswordController;
use App\Http\Controllers\Auth\ResetPasswordController;
use App\Http\Controllers\EmployeeTypeController;
use App\Http\Controllers\QuestionController;
use App\Http\Controllers\TreatmentController;
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
    $router->get('/treatments', TreatmentController::class . '@index');
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
use LaravelFCM\Message\Topics;

$router->get('push', function () {
    $optionBuiler = new OptionsBuilder();
    $optionBuiler->setTimeToLive(60 * 20);

    $notificationBuilder = new PayloadNotificationBuilder('my title');
    $notificationBuilder->setBody('Hello world')
        ->setSound('default');

    $dataBuilder = new PayloadDataBuilder();
    $dataBuilder->addData([
        'id'               => 1,
        'title'            => 'Puntos en las encias',
        'message'          => 'del 1 al 10 como describirias el dolor en la zona de los puntos ? ',
        'possible_answers' => 'OK',
        'read_at'          => 'hace 9 dias'
    ]);

    $option = $optionBuiler->build();
    $notification = $notificationBuilder->build();
    $data = $dataBuilder->build();

    $token = "fLur_i7rLco:APA91bFYKQkFqkEBUWBAB9thZ4ddAkQmgrMs372Abpqqpcnabi4-Xu7OvLOfz4SoxjN3dJQzUglfc-rexZzGD1ExOKK-QANeDoVXgUhIHYv3bDX-zNtEl0LIHkp6G3UK2GM_hcptigCk";

//    $a = FCM::sendTo($token, $option, $notification, $data);

    $topic = new Topics();
    $topic->topic('global');

    $topicResponse = FCM::sendToTopic($topic, $option, $notification, $data);

    dd($topicResponse);
});
