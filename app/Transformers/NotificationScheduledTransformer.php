<?php

namespace App\Transformers;

use App\Models\Appointment;
use App\Models\Clinic;
use App\Models\Dentist;
use App\Models\NotificationScheduled;
use App\Models\Patient;

class NotificationScheduledTransformer extends Transformer
{
    public function transform(NotificationScheduled $model)
    {
        $this->output = [
            'id'               => $model->id,
            'title'            => $model->title,
            'possible_answers' => $model->possible_answers,
            'type'             => $model->type,
            'time_to_send'     => $model->time_to_send,
            'start_sending'    => $model->start_sending,
            'finish_sending'   => $model->finish_sending,
            'pediodicity'      => $model->periodicity->map(function ($period) {
                return $period->value;
            })->toArray()
        ];

        return $this->output;
    }
}