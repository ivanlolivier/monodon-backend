<?php

namespace App\Transformers;

use App\Models\Clinic;
use App\Models\Dentist;
use App\Models\Diagnosis;
use App\Models\Exploratory;
use App\Models\NotificationScheduled;
use App\Models\Patient;
use App\Models\Treatment;
use App\Models\Visit;
use App\Models\VisitInterrogatory;

class VisitTransformer extends Transformer
{
    public function transform(Visit $model)
    {
        $this->output = [
            'id'         => $model->id,
            'type'       => $model->type,
            'created_at' => $model->created_at->toDateTimeString(),

            'patient_id'   => $model->patient_id,
            'dentist_id'   => $model->dentist_id,
            'clinic_id'    => $model->clinic_id,
            'diagnosis_id' => $model->diagnosis_id,
            'parent_id'    => $model->parent_visit_id,

            'indications' => $model->notificationsScheduled->transform(function ($item) {
                return (NotificationScheduled::transformer())->transform($item);
            })
        ];

        $this->replaceRelationship($model, 'patient', Patient::transformer());
        $this->replaceRelationship($model, 'dentist', Dentist::transformer());
        $this->replaceRelationship($model, 'clinic', Clinic::transformer());
        $this->replaceRelationship($model, 'diagnosis', Diagnosis::transformer());
        $this->replaceRelationship($model, 'parent', Visit::transformer());
        $this->replaceRelationship($model, 'exploratory', Exploratory::transformer());
        $this->replaceRelationship($model, 'interrogatory', VisitInterrogatory::transformer());

        return $this->output;
    }
}