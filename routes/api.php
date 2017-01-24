<?php

use App\Http\Controllers\Auth\ForgotPasswordController;
use App\Http\Controllers\Auth\ResetPasswordController;
use App\Http\Controllers\EmployeeTypeController;
use LaravelFCM\Facades\FCM;
use LaravelFCM\Message\OptionsBuilder;
use LaravelFCM\Message\PayloadDataBuilder;
use LaravelFCM\Message\PayloadNotificationBuilder;

Route::post('password/email', ForgotPasswordController::class . '@sendResetLinkEmail');
Route::put('password/reset', ResetPasswordController::class . '@reset');


Route::group(['prefix' => '/clinics'], function () {
    require 'api/clinics.php';
});

Route::group(['prefix' => '/patients'], function () {
    require 'api/patients.php';
});

Route::group(['prefix' => '/employees'], function () {
    require 'api/employees.php';
});

Route::get('employee_types', EmployeeTypeController::class . '@index');

Route::get('push', function () {
//    $notification = (new PayloadNotificationBuilder('Se te cayo un diente'))
//        ->setBody('Hola, soy el cuerpo de la notificación de nuevo diente')
//        ->setSound('default')
//        ->build();

    $optionBuiler = new OptionsBuilder();
    $optionBuiler->setTimeToLive(60*20);

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
