<?php

namespace App\Models;

use App\Transformers\MessageTransformer;
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
        $optionBuiler = new OptionsBuilder();
        $optionBuiler->setTimeToLive(60 * 20);

        $notificationBuilder = new PayloadNotificationBuilder('Tienes un mensaje de tu clinica');
        $notificationBuilder->setBody('Asunto: ' . $this->title);

        $dataBuilder = new PayloadDataBuilder();
        $dataBuilder->addData([
            'id'               => 1,
            'title'            => 'Mensaje de ',
            'message'          => $this->message,
            'possible_answers' => 'OK'
        ]);

        $option = $optionBuiler->build();
        $notification = $notificationBuilder->build();
        $data = $dataBuilder->build();

        $topic = new Topics();
        $topic->topic('global');

        FCM::sendToTopic($topic, $option, $notification, $data);
    }
}
