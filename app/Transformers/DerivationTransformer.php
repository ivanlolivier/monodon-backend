<?php

namespace App\Transformers;

use App\Models\Derivation;
use App\Models\Diagnosis;

class DerivationTransformer extends Transformer
{
    public function transform(Derivation $model)
    {
        $this->output = [
            'id'      => $model->id,
            'reason'  => $model->reason,
            'contact' => [
                'name'  => $model->contact_name,
                'phone' => $model->contact_phone,
                'email' => $model->contact_email,
            ],
        ];

        $this->replaceRelationship($model, 'diagnosis', Diagnosis::transformer());

        return $this->output;
    }
}