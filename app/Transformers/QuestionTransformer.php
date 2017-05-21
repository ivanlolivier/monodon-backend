<?php

namespace App\Transformers;

use App\Models\Question;

class QuestionTransformer extends Transformer
{
    public function transform(Question $model)
    {
        $this->output = [
            'id'       => $model->id,
            'question' => $model->question,
            'type'     => $model->type,
            'group'    => $model->group
        ];

        return $this->output;
    }
}