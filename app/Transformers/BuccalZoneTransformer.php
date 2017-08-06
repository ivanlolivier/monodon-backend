<?php

namespace App\Transformers;

use App\Models\BuccalZone;

class BuccalZoneTransformer extends Transformer
{
    public function transform(BuccalZone $model)
    {
        $this->output = [
            'id'   => $model->id,
            'name' => $model->name,
        ];

        return $this->output;
    }
}