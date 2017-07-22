<?php

namespace App\Transformers;

use App\Models\Question;
use App\Models\Visit;
use App\Models\VisitInterrogatory;

class VisitInterrogatoryTransformer extends Transformer
{
    public function transform(VisitInterrogatory $model)
    {
        $this->output = [
            'id'          => $model->id,
            'question_id' => $model->question_id,
            'answer'      => $model->answer,
        ];

        $this->replaceRelationship($model, 'visit', Visit::transformer());
        $this->replaceRelationship($model, 'question', Question::transformer());

        return $this->output;
    }
}