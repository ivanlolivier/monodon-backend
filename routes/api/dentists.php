<?php

use App\Http\Controllers\DentistController;
use Illuminate\Routing\Router;

/** @var Router $router */

$router->group([
    'middleware' => 'auth:dentist',
    'prefix'     => '/me'
], function (Router $router) {
    $router->get('/', DentistController::class . '@me');
    $router->put('/', DentistController::class . '@updateMe');

    $router->get('/clinics', DentistController::class . '@clinics');
});
