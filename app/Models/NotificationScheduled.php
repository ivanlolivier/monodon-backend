<?php

namespace App\Models;

use App\Transformers\NotificationScheduledTransformer;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use LaravelFCM\Facades\FCM;
use LaravelFCM\Message\OptionsBuilder;
use LaravelFCM\Message\PayloadDataBuilder;
use LaravelFCM\Message\PayloadNotificationBuilder;

class NotificationScheduled extends _Model
{
    protected $table = 'notifications';

    protected $fillable = [
        'title',
        'message',
        'possible_answers',
        'type',
        'time_to_send',
        'start_sending',
        'finish_sending',
        'patient_id',
    ];

    /**
     * RELATIONS
     */

    public function patient()
    {
        return $this->belongsTo(Patient::class);
    }

    public function visit()
    {
        return $this->belongsTo(Visit::class);
    }

    public function periodicity()
    {
        return $this->hasMany(NotificationPeriodicity::class, 'notification_id');
    }

    public function sents()
    {
        return $this->hasMany(NotificationSent::class, 'notification_id', 'id');
    }

    public static function transformer()
    {
        return new NotificationScheduledTransformer();
    }

    public function send()
    {
        $optionBuiler = new OptionsBuilder();
        $optionBuiler->setTimeToLive(60 * 20);
        $option = $optionBuiler->build();

        $notificationBuilder = new PayloadNotificationBuilder('Tienes una indicación de tu dentista');
        $notificationBuilder->setBody('Asunto: ' . $this->title);
        $notification = $notificationBuilder->build();

        $dataBuilder = new PayloadDataBuilder();
        $dataBuilder->addData([
            'type'             => 'notification',
            'id'               => $this->id,
            'title'            => $this->title,
            'message'          => $this->message,
            'possible_answers' => $this->possible_answers,
        ]);
        $data = $dataBuilder->build();

        /** @var Patient $patient */
        $patient = $this->patient()->with('fcmTokens')->first();
        $tokens = $patient->fcmTokens
            ->pluck('fcm_token')
            ->toArray();

        if (empty($tokens)) {
            return false;
        }

        $this->sents()->create(['sent_at' => $this->freshTimestamp()]);

        $result = FCM::sendTo($tokens, $option, $notification, $data);

        return $result;
    }

    public function scopeStarted(Builder $query)
    {
        return $query->where('start_sending', '<=', Carbon::now()->toDateString());
    }

    public function scopeNotFinished(Builder $query)
    {
        return $query->where('finish_sending', '>=', Carbon::now()->toDateString());
    }

    public function scopeActive(Builder $query)
    {
        return $query
            ->where('start_sending', '<=', Carbon::now()->toDateString())
            ->where('finish_sending', '>=', Carbon::now()->toDateString());
    }

    public function scopeThisHour(Builder $query)
    {
        return $query->where('time_to_send', '=', Carbon::now()->hour . ':00:00');
    }

    public function scopeThisDay(Builder $query)
    {
        return $query->where('time_to_send', '=', Carbon::now()->hour . ':00:00');
    }

    public function scopeNotSent(Builder $query)
    {
        return $query->whereDoesntHave('sents', function ($query) {
            $query->where('sent_at', '>=', Carbon::now()->format('Y-m-d H:00:00'));
        });
    }
}
