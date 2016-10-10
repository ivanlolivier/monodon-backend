<?php

namespace App\Transformers;

use App\Models\Patient;
use League\Fractal\TransformerAbstract;

class PatientTransformer extends TransformerAbstract
{

    public function transform(Patient $model)
    {
        return [
            'id'        => $model->id,
            'name'      => $model->name,
            'surname'   => $model->surname,
            'document'  => [
                'type'   => $model->document_type,
                'number' => $model->document,
            ],
            'birthdate' => $model->birthdate->toDateString(),
            'sex'       => $model->sex,
            'photo'     => $model->id,
            'phones'    => explode(';', $model->phones),
            'email'     => $model->email,
            'tags'      => explode(';', $model->tags),
        ];
    }

}