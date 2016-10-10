<?php

namespace App\Transformers;

use App\Models\Clinic;
use League\Fractal\TransformerAbstract;

class ClinicTransformer extends TransformerAbstract
{

    public function transform(Clinic $model)
    {
        return [
            'id'      => $model->id,
            'name'    => $model->name,
            'address' => $model->address,
            'phones'  => explode(';', $model->phones),
        ];
    }

}