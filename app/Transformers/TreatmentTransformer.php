<?php

namespace App\Transformers;

use App\Models\Diagnosis;
use App\Models\Treatment;

class TreatmentTransformer extends Transformer
{
    public function transform(Treatment $model)
    {
        $this->output = [
            'id'           => $model->id,
            'name'         => $model->name,
            'code'         => $model->code,
            'diagnosis_id' => $model->diagnosis_id,
        ];

        $this->replaceRelationship($model, 'diagnosis', Diagnosis::transformer());

        return $this->output;
    }
}