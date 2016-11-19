<?php

namespace App\Transformers;

use App\Models\EmployeeType;
use League\Fractal\TransformerAbstract;

class EmployeeTypeTransformer extends TransformerAbstract
{

    public function transform(EmployeeType $model)
    {
        $output = [
            'name'        => $model->name,
            'description' => $model->description,
        ];

        return $output;
    }

}