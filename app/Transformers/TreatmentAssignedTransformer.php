<?php

namespace App\Transformers;

use App\Models\BuccalZone;
use App\Models\Treatment;
use App\Models\TreatmentAssigned;

class TreatmentAssignedTransformer extends Transformer
{
    public function transform(TreatmentAssigned $model)
    {
        $this->output = [
            'id'             => $model->id,
            'patient_id'     => $model->patient_id,
            'treatment_id'   => $model->treatment_id,
            'diagnosis_id'   => $model->diagnosis_id,
            'buccal_zone_id' => $model->buccal_zone_id,
            'is_finished'    => $model->is_finished,
        ];

        $this->replaceRelationship($model, 'treatment', Treatment::transformer());
        $this->replaceRelationship($model, 'buccal_zone', BuccalZone::transformer());

        return $this->output;
    }
}