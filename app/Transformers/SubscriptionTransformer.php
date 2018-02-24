<?php

namespace App\Transformers;

use App\Models\NotificationTopic;
use App\Models\Subscription;

class SubscriptionTransformer extends Transformer
{
    public function transform(Subscription $model)
    {
        $this->output = [
            'topic_id'   => $model->notification_topic_id,
            'subscribed' => $model->subscribed,
        ];

        $this->replaceRelationship($model, 'topic', NotificationTopic::transformer());

        return $this->output;
    }
}