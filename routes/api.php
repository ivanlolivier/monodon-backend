<?php

use App\Http\Controllers\EmployeeTypeController;
use LaravelFCM\Facades\FCM;
use LaravelFCM\Message\PayloadNotificationBuilder;

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
    $notification = (new PayloadNotificationBuilder('Titulo de la notificacion'))
        ->setBody('Hola, soy el cuerpo de la notificación')
        ->setSound('default')
        ->build();

    $token = "eZviev6PkkM:APA91bHP-cKhWelKXO3LXQb4T3Oa8Fw1a2yz8pHdpWhUadei2xmTFfnifNpuQR1uyXjpuW7eAC8k2NFmcXGriNl1MnayBogdlZ_ETAET9hO8429YKceZIurVCg8T7K-s8R2VPzgo7d3z";

    $downstreamResponse = FCM::sendTo($token, null, $notification);

    dd($downstreamResponse);
});
