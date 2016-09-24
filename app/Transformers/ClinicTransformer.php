<?php

namespace App\Transformers;

use App\Model\Clinic;
use League\Fractal\TransformerAbstract;

class ClinicTransformer extends TransformerAbstract
{

    public function transform(Clinic $model)
    {
        return [
            'name'    => $model->name,
            'address' => $model->address,
            'phones'  => explode(';', $model->phones),
        ];
    }

}