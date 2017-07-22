<?php

namespace App\Transformers;

use App\Models\Exploratory;
use App\Models\Visit;

class ExploratoryTransformer extends Transformer
{
    public function transform(Exploratory $model)
    {
        $this->output = [
            'id'          => $model->id,
            'mouth_photo' => $model->mouth_photo,
        ];

        $this->replaceRelationship($model, 'visit', Visit::transformer());

        return $this->output;
    }
}