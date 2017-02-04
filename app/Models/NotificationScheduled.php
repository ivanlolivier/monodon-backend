<?php

namespace App\Models;

class NotificationScheduled extends _Model
{
    protected $table = 'notifications';

    /**
     * RELATIONS
     */

    public function patient()
    {
        return $this->belongsTo(Patient::class);
    }

    public function sent()
    {
        return $this->hasOne(NotificationSent::class, 'id', 'notification_id');
    }

    public static function transformer()
    {
        // TODO: Implement transformer() method.
    }
}
