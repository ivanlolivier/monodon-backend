<?php

namespace App\Transformers;

use App\Models\Appointment;
use App\Models\Clinic;
use App\Models\Dentist;
use App\Models\Patient;

class AppointmentTransformer extends Transformer
{
    public function transform(Appointment $model)
    {
        $this->output = [
            'id'          => $model->id,
            'title'       => $model->title,
            'description' => $model->description,
            'date'        => $model->datetime->toDateString(),
            'time'        => $model->datetime->format('h:i'),
            'duration'    => $model->duration,
            'clinic_id'   => $model->clinic_id,
            'dentist_id'  => $model->dentist_id,
            'patient_id'  => $model->patient_id,
        ];

        $this->replaceRelationship($model, 'clinic', Clinic::transformer());
        $this->replaceRelationship($model, 'dentist', Dentist::transformer());
        $this->replaceRelationship($model, 'patient', Patient::transformer());

        return $this->output;
    }
}