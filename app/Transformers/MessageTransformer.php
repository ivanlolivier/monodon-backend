<?php

namespace App\Transformers;

use App\Models\Clinic;
use App\Models\Dentist;
use App\Models\Employee;
use App\Models\Message;
use App\Models\Patient;

class MessageTransformer extends Transformer
{
    public function transform(Message $model)
    {
        $this->output = [
            'id'           => $model->id,
            'title'        => $model->title,
            'message'      => $model->message,
            'is_broadcast' => $model->is_broadcast,
            'created_at'   => $model->created_at->toDateTimeString(),
            'sent_at'      => $model->sent_at ? $model->sent_at->toDateTimeString() : null,
            'clinic_id'    => $model->clinic_id,
            'dentist_id'   => $model->dentist_id,
            'employee_id'  => $model->employee_id,
        ];

        $this->replaceRelationship($model, 'clinic', Clinic::transformer());
        $this->replaceRelationship($model, 'dentist', Dentist::transformer());
        $this->replaceRelationship($model, 'patients', Patient::transformer());
        $this->replaceRelationship($model, 'employee', Employee::transformer());

        return $this->output;
    }
}