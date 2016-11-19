<?php

namespace App\Transformers;

use App\Models\Dentist;

class DentistTransformer extends Transformer
{
    public function transform(Dentist $model)
    {
        $this->output = [
            'id'           => $model->id,
            'affiliate_id' => $model->affiliate_id,
            'name'         => $model->name,
            'surname'      => $model->surname,
            'email'        => $model->email,
            'phones'       => explode(';', $model->phones),
            'sex'          => $model->sex,
        ];

        return $this->output;
    }
}