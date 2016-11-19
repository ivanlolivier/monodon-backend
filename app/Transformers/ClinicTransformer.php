<?php

namespace App\Transformers;

use App\Models\Appointment;
use App\Models\Clinic;
use League\Fractal\TransformerAbstract;

class ClinicTransformer extends TransformerAbstract
{

    public function transform(Clinic $model)
    {
        $output = [
            'id'      => $model->id,
            'name'    => $model->name,
            'address' => $model->address,
            'phones'  => explode(';', $model->phones),
        ];

        if (isset($model->last_appointment)) {
            $output->last_appointment = $model->last_appointment? Appointment::transformer()->transform($model->last_appointment) : null;
        }

        return $output;
    }

}