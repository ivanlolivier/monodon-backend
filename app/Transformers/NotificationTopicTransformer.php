<?php

namespace App\Transformers;

use App\Models\NotificationTopic;

class NotificationTopicTransformer extends Transformer
{
    public function transform(NotificationTopic $model)
    {
        $this->output = [
            'id'   => $model->id,
            'name' => $model->name,
            'code' => $model->code,
        ];

        return $this->output;
    }
}