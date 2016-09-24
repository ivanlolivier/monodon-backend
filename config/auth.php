<?php

use App\Model\Dentist;
use App\Model\Employee;

return [

    'defaults' => [
        'guard' => 'dentists',
        'passwords' => 'dentists',
    ],

    'guards' => [
        'dentists' => [
            'driver' => 'passport',
            'provider' => 'dentist',
        ],

        'employees' => [
            'driver' => 'passport',
            'provider' => 'employee',
        ],
    ],

    'providers' => [
        'dentist' => [
            'driver' => 'eloquent',
            'model' => Dentist::class
        ],

        'users' => [
            'driver' => 'eloquent',
            'model' => Dentist::class
        ],

        'employees' => [
            'driver' => 'eloquent',
            'model' => Employee::class,
        ],
    ],

    'passwords' => [
        'dentists' => [
            'provider' => 'dentists',
            'table' => 'password_resets',
            'expire' => 60,
        ],

        'employees' => [
            'provider' => 'employees',
            'table' => 'password_resets',
            'expire' => 60,
        ],
    ],

];
