<?php

namespace App\Transformers;

use App\Models\Clinic;
use App\Models\Dentist;
use App\Models\Diagnosis;
use App\Models\Patient;
use App\Models\Treatment;
use App\Models\Visit;

class VisitTransformer extends Transformer
{
    public function transform(Visit $model)
    {
        $this->output = [
            'id'   => $model->id,
            'type' => $model->type,

            'patient_id'   => $model->patient_id,
            'dentist_id'   => $model->dentist_id,
            'clinic_id'    => $model->clinic_id,
            'diagnosis_id' => $model->diagnosis_id,
            'treatment_id' => $model->treatment_id,
            'parent_id'    => $model->parent_visit_id,
        ];

        $this->replaceRelationship($model, 'patient', Patient::transformer());
        $this->replaceRelationship($model, 'dentist', Dentist::transformer());
        $this->replaceRelationship($model, 'clinic', Clinic::transformer());
        $this->replaceRelationship($model, 'diagnosis', Diagnosis::transformer());
        $this->replaceRelationship($model, 'treatment', Treatment::transformer());
        $this->replaceRelationship($model, 'parent', Visit::transformer());

        return $this->output;
    }
}