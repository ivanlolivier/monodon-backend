<?php

namespace App\Transformers;

use App\Models\Derivation;
use App\Models\Diagnosis;
use App\Models\PredefinedDiagnosis;
use App\Models\TreatmentAssigned;

class DiagnosisTransformer extends Transformer
{
    public function transform(Diagnosis $model)
    {
        $this->output = [
            'id'          => $model->id,
            'description' => $model->description,
            'type'        => $model->type,
        ];

        $this->replaceRelationship($model, 'predefined', PredefinedDiagnosis::transformer());
        $this->replaceRelationship($model, 'derivation', Derivation::transformer());
        $this->replaceRelationship($model, 'treatments_assigned', TreatmentAssigned::transformer());

        return $this->output;
    }
}