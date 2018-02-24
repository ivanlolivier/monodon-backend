<?php

namespace App\Transformers;

use App\Models\DiagnosisType;

class DiagnosisTypeTransformer extends Transformer
{
    public function transform(DiagnosisType $model)
    {
        $this->output = [
            'id'   => $model->id,
            'name' => $model->name,
        ];

        return $this->output;
    }
}