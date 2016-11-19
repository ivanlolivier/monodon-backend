<?php

namespace App\Transformers;

use App\Models\Appointment;
use App\Models\Clinic;
use App\Models\Dentist;
use App\Models\Patient;
use League\Fractal\TransformerAbstract;

class AppointmentTransformer extends TransformerAbstract
{

    public function transform(Appointment $model)
    {
        $output = [
            'id'          => $model->id,
            'title'       => $model->title,
            'description' => $model->description,
            'datetime'    => $model->datetime->toDateTimeString(),
            'clinic_id'   => $model->clinic_id,
            'dentist_id'  => $model->dentist_id,
            'patient_id'  => $model->patient_id,
        ];

        if ($this->isRelationshipLoaded($model, 'clinic')) {
            $output['clinic'] = Clinic::transformer()->transform($model->clinic);
            unset($output->clinic_id);
        }

        if ($this->isRelationshipLoaded($model, 'dentist')) {
            $output['dentist'] = Dentist::transformer()->transform($model->dentist);
            unset($output->dentist_id);
        }

        if ($this->isRelationshipLoaded($model, 'patient')) {
            $output['patient'] = Patient::transformer()->transform($model->patient);
            unset($output->patient_id);
        }

        return $output;
    }

    public function isRelationshipLoaded($model, $relation)
    {
        return isset($model->relations[$relation]);
    }

}