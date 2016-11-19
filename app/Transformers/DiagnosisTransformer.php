<?php

namespace App\Transformers;

use App\Models\Diagnosis;

class DiagnosisTransformer extends Transformer
{
    public function transform(Diagnosis $model)
    {
        $this->output = [
            'id'          => $model->id,
            'description' => $model->description,
            'type'        => $model->type,
        ];

        return $this->output;
    }
}