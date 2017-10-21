<?php

namespace App\Models;

use App\Transformers\MessageTransformer;
use Illuminate\Support\Facades\Config;
use LaravelFCM\Facades\FCM;
use LaravelFCM\Message\OptionsBuilder;
use LaravelFCM\Message\PayloadDataBuilder;
use LaravelFCM\Message\PayloadNotificationBuilder;
use LaravelFCM\Message\Topics;

class Message extends _Model
{
    protected $fillable = [
        'title',
        'message',
        'is_broadcast',
    ];

    protected $dates = [
        'sent_at'
    ];

    protected $casts = [
        'is_broadcast' => 'boolean'
    ];

    public function dentist()
    {
        return $this->belongsTo(Dentist::class);
    }

    public function clinic()
    {
        return $this->belongsTo(Clinic::class);
    }

    public function employee()
    {
        return $this->belongsTo(Employee::class);
    }

    public function patients()
    {
        return $this->belongsToMany(Patient::class, 'message_patient');
    }

    public static function transformer()
    {
        return new MessageTransformer();
    }

    public function send()
    {
        $this->sent_at = $this->freshTimestamp();
        $this->save();

        //OPTIONS
        $optionBuiler = new OptionsBuilder();
        $optionBuiler->setTimeToLive(60 * 20);
        $option = $optionBuiler->build();

        //NOTIFICATION
        $notificationBuilder = new PayloadNotificationBuilder('Tienes un mensaje de tu clinica');
        $notificationBuilder->setBody('Asunto: ' . $this->title);
        $notification = $notificationBuilder->build();

        //DATA
        $dataBuilder = new PayloadDataBuilder();
        $dataBuilder->addData([
            'type'             => 'message',
            'id'               => $this->id,
            'title'            => $this->title,
            'message'          => $this->message,
            'possible_answers' => 'OK'
        ]);
        $data = $dataBuilder->build();

        /**
         * SENDING THE MESSAGE
         */

        if ($this->is_broadcast) {
            $global_topic = Config::get('message-topics.global');

            $topic = new Topics();
            $topic->topic($global_topic);

            return FCM::sendToTopic($topic, $option, $notification, $data);
        }

        $tokens = array_filter($this->patients()->with('fcmTokens')->get()->reduce(function ($carry, Patient $patient) {
            return array_merge($carry, $patient->fcmTokens->pluck('fcm_token')->toArray());
        }, []));

        if (empty($tokens)) {
            return false;
        }

        return FCM::sendTo($tokens, $option, $notification, $data);
    }
}
