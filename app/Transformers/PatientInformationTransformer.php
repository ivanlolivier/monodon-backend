<?php

namespace App\Transformers;

use App\Models\Patient;
use App\Models\PatientInformation;

class PatientInformationTransformer extends Transformer
{

    public function transform(PatientInformation $model)
    {
        $this->output = [
            'id'          => $model->id,
            'information' => $model->information,
            'patient_id'  => $model->patient_id,
            'created_at'  => $model->created_at->toDateTimeString(),
            'read_at'     => $model->read_at->toDateTimeString(),
        ];

        $this->replaceRelationship($model, 'patient', Patient::transformer());

        return $this->output;
    }

}