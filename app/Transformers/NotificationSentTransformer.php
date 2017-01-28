<?php

namespace App\Transformers;

use App\Models\NotificationSent;

class NotificationSentTransformer extends Transformer
{
    public function transform(NotificationSent $model)
    {
        $this->output = [
            'id'               => $model->id,
            'title'            => $model->scheduled->title,
            'message'          => $model->scheduled->title,
            'possible_answers' => $model->scheduled->title,
            'sent_at'          => $model->sent_at ? $model->sent_at->diffForHumans() : null,
            'read_at'          => $model->read_at ? $model->read_at->diffForHumans() : null,
            'answered_at'      => $model->answered_at ? $model->answered_at->diffForHumans() : null,
        ];

        return $this->output;
    }
}