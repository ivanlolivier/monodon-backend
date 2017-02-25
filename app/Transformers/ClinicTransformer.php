<?php

namespace App\Transformers;

use App\Models\Clinic;
use App\Models\Visit;

class ClinicTransformer extends Transformer
{
    public function transform(Clinic $model)
    {
        $this->output = [
            'id'      => $model->id,
            'name'    => $model->name,
            'address' => $model->address,
            'phones'  => explode(';', $model->phones),
            'email'   => $model->email,
            'logo'    => url('/storage/' . $model->logo),
        ];

        if (isset($model->last_visit)) {
            $this->output['last_visit'] = Visit::transformer()->transform($model->last_visit);
        }

        return $this->output;
    }
}