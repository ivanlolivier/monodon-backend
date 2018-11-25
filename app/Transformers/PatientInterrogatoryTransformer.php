<?php

namespace App\Transformers;

use App\Models\Question;
use App\Models\Patient;
use App\Models\PatientInterrogatory;

class PatientInterrogatoryTransformer extends Transformer
{
    public function transform(PatientInterrogatory $model)
    {
        $this->output = [
            'id'          => $model->id,
            'question_id' => $model->question_id,
            'answer'      => $model->answer,
        ];

        $this->replaceRelationship($model, 'patient', Patient::transformer());
        $this->replaceRelationship($model, 'question', Question::transformer());

        return $this->output;
    }
}