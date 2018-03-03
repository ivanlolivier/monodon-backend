<?php

namespace App\Transformers;

use App\Models\PredefinedDiagnosis;

class PredefinedDiagnosisTransformer extends Transformer
{
    public function transform(PredefinedDiagnosis $model)
    {
        $this->output = [
            'id'   => $model->id,
            'name' => $model->name,
        ];

        return $this->output;
    }
}