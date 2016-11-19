<?php

namespace App\Transformers;

use App\Models\Dentist;
use League\Fractal\TransformerAbstract;

class DentistTransformer extends TransformerAbstract
{

    public function transform(Dentist $model)
    {
        $output = [
            'id'           => $model->id,
            'affiliate_id' => $model->affiliate_id,
            'name'         => $model->name,
            'surname'      => $model->surname,
            'email'        => $model->email,
            'phones'       => explode(';', $model->phones),
            'sex'          => $model->sex,
        ];

        return $output;
    }

}