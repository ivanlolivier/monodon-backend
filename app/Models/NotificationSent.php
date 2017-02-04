<?php

namespace App\Models;

use App\Transformers\NotificationSentTransformer;

class NotificationSent extends _Model
{

    protected $dates = [
        'sent_at',
        'read_at',
        'answer_at',
        'created_at',
        'updated_at',
        'answered_at',
    ];

    /**
     * RELATIONS
     */

    public function patient()
    {
        return $this->belongsTo(Patient::class);
    }

    public function scheduled()
    {
        return $this->hasOne(NotificationScheduled::class, 'id', 'notification_id');
    }

    public static function transformer()
    {
        return new NotificationSentTransformer();
    }
}
