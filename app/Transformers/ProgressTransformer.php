<?php

namespace App\Transformers;

use App\Models\Progress;
use App\Models\TreatmentAssigned;

class ProgressTransformer extends Transformer
{
    public function transform(Progress $model)
    {
        $this->output = [
            'id'                    => $model->id,
            'description'           => $model->description,
            'parent_progress_id'    => $model->parent_progress_id,
            'treatment_assigned_id' => $model->treatment_assigned_id,
            'created_at'            => $model->created_at->toDateTimeString(),
        ];

        $this->replaceRelationship($model, 'treatment_assigned', TreatmentAssigned::transformer());
        $this->replaceRelationship($model, 'parent_progress', Progress::transformer());

        return $this->output;
    }
}