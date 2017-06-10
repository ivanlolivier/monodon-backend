<?php

namespace App\Transformers;

use App\Models\Treatment;
use App\Models\TreatmentAssigned;

class TreatmentAssignedTransformer extends Transformer
{
    public function transform(TreatmentAssigned $model)
    {
        $this->output = [
            'id'           => $model->id,
            'treatment_id' => $model->treatment_id,
            'is_finished'  => $model->is_finished,
        ];

        $this->replaceRelationship($model, 'treatment', Treatment::transformer());

        return $this->output;
    }
}