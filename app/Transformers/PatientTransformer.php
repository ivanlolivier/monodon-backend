<?php

namespace App\Transformers;

use App\Models\Patient;

class PatientTransformer extends Transformer
{

    public function transform(Patient $model)
    {
        $this->output = [
            'id'        => $model->id,
            'name'      => $model->name,
            'surname'   => $model->surname,
            'document'  => [
                'type'   => $model->document_type,
                'number' => $model->document,
            ],
            'birthdate' => $model->birthdate->toDateString(),
            'sex'       => $model->sex,
            'photo'     => $model->photo ? url('/patients/me/photo') : null,
            'phones'    => explode(';', $model->phones),
            'email'     => $model->email,
            'tags'      => explode(';', $model->tags),
        ];

        return $this->output;
    }

}