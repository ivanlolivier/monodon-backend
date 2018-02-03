<?php

namespace App\Models;

use App\Transformers\SubscriptionTransformer;
use Illuminate\Database\Eloquent\Model;

class Subscription extends Model
{
    protected $table = 'patient_subscriptions';

    protected $fillable = [
        'patient_id',
        'notification_topic_id',
        'subscribed'
    ];

    protected $casts = [
        'subscribed' => 'boolean'
    ];

    public function topic()
    {
        return $this->belongsTo(NotificationTopic::class, 'notification_topic_id');
    }

    public function patient()
    {
        return $this->belongsTo(Patient::class);
    }

    public static function transformer()
    {
        return new SubscriptionTransformer();
    }
}
