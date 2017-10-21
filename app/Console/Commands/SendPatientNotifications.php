<?php

namespace App\Console\Commands;

use App\Models\NotificationScheduled;
use Illuminate\Console\Command;

class SendPatientNotifications extends Command
{
    protected $signature = 'command:send-patient-notifications';
    protected $description = 'Sends push notifications to the patients';

    public function handle()
    {
        $notifications = NotificationScheduled::active()
            ->thisHour()
            ->notSent()
            ->get();

        $notifications->each(function (NotificationScheduled $notification) {
            $notification->send();
        });
    }
}
