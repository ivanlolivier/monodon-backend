<?php

namespace App\Models;

use App\Transformers\NotificationTopicTransformer;
use Illuminate\Database\Eloquent\Model;

class NotificationTopic extends Model
{
    public function subscriptions()
    {
        return $this->hasMany(Subscription::class);
    }

    public static function transformer()
    {
        return new NotificationTopicTransformer();
    }
}
