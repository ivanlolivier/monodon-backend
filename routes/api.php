<?php

/** @var Router $router */

use App\Http\Controllers\Auth\ForgotPasswordController;
use App\Http\Controllers\Auth\ResetPasswordController;
use App\Http\Controllers\EmployeeTypeController;
use Illuminate\Routing\Router;

$router->post('password/email', ForgotPasswordController::class . '@sendResetLinkEmail');
$router->put('password/reset', ResetPasswordController::class . '@reset');

$router->get('employee_types', EmployeeTypeController::class . '@index');

$router->group(['prefix' => '/employees'], function (Router $router) {
    require 'api/employees.php';
});

$router->group(['prefix' => '/clinics'], function (Router $router) {
    require 'api/clinics.php';
});

$router->group(['prefix' => '/patients'], function (Router $router) {
    require 'api/patients.php';
});


use LaravelFCM\Facades\FCM;
use LaravelFCM\Message\OptionsBuilder;
use LaravelFCM\Message\PayloadDataBuilder;
use LaravelFCM\Message\PayloadNotificationBuilder;

$router->get('push', function () {
//    $notification = (new PayloadNotificationBuilder('Se te cayo un diente'))
//        ->setBody('Hola, soy el cuerpo de la notificación de nuevo diente')
//        ->setSound('default')
//        ->build();

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

    $downstreamResponse = FCM::sendTo($token, $option, $notification, $data);

    dd($downstreamResponse);
});
