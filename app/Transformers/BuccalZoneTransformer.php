<?php

namespace App\Transformers;

use App\Models\BuccalZone;

class BuccalZoneTransformer extends Transformer
{
    public function transform(BuccalZone $model)
    {
        $this->output = [
            'name' => $model->name,
        ];

        return $this->output;
    }
}