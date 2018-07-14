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
            'message'          => $model->scheduled->message,
            'possible_answers' => $model->scheduled->possible_answers,
            'sent_at'          => $model->sent_at ? $model->sent_at->toDateTimeString() : null,
            'read_at'          => $model->read_at ? $model->read_at->toDateTimeString() : null,
            'answer'           => $model->answer,
            'answered_at'      => $model->answered_at ? $model->answered_at->toDateTimeString() : null,
        ];
        
        return $this->output;
    }
}
//