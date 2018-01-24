<?php

namespace App\Models;

class NotificationPeriodicity extends _Model
{
    protected $fillable = [
        'notification_scheduled_id',
        'value',
    ];

    public function notificationSchduled()
    {
        return $this->belongsTo(NotificationScheduled::class);
    }

    public static function transformer()
    {
        // TODO: Implement transformer() method.
    }
}
