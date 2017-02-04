<?php

use App\Models\NotificationScheduled;
use Carbon\Carbon;
use Illuminate\Database\Seeder;

class NotificationsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(NotificationScheduled::class, 50)->create([
            'send_at' => Carbon::create()->format('Y-m-d H:i:s')
        ])->each(function (NotificationScheduled $notification) {

            $notification_sent = [
                'notification_id' => $notification->id,
                'sent_at'         => $notification->sent_at,
            ];

            $read = rand(0, 1);
            $answered = rand(0, 1);

            if ($read) {
                $notification_sent['read_at'] = Carbon::create()->format('Y-m-d H:i:s');
            }

            if ($read && $answered) {

                $answer = '';

                if ($notification->possible_answers == 'YES-NO') {
                    $answer = rand(0, 1) ? 'YES' : 'NO';
                }

                if ($notification->possible_answers == 'OK') {
                    $answer = 'OK';
                }

                if ($notification->possible_answers == 'RANGE') {
                    $answer = rand(0, 100);
                }

                $notification_sent['answered_at'] = Carbon::create()->format('Y-m-d H:i:s');
                $notification_sent['answer'] = $answer;
            }

            $notification->sent()->create($notification_sent);
        });
    }
}
