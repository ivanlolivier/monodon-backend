<?php

namespace App\Console\Commands;

use App\Models\NotificationScheduled;
use Illuminate\Console\Command;
use Symfony\Component\Console\Output\ConsoleOutput;

class SendPatientNotifications extends Command
{
    protected $signature = 'send:patient-notifications';
    protected $description = 'Sends push notifications to the patients';

    public function __construct()
    {
        parent::__construct();
        $this->output = new ConsoleOutput();
    }

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
