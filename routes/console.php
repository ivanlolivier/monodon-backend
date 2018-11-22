<?php

use App\Console\Commands\SendPatientNotifications;

Artisan::command('send:patient-notifications', function () {
    (new SendPatientNotifications)->handle();
})->describe('Sends push notifications to patients');
