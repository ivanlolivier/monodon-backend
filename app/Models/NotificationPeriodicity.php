<?php

namespace App\Models;

class NotificationPeriodicity extends _Model
{

    public function notificationSchduled()
    {
        return $this->belongsTo(NotificationScheduled::class);
    }

    public static function transformer()
    {
        // TODO: Implement transformer() method.
    }
}
