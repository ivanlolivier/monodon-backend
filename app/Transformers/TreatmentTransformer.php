<?php

namespace App\Transformers;

use App\Models\Diagnosis;
use App\Models\Treatment;

class TreatmentTransformer extends Transformer
{
    public function transform(Treatment $model)
    {
        $this->output = [
            'id'   => $model->id,
            'name' => $model->name,
            'code' => $model->code,
        ];

        return $this->output;
    }
}