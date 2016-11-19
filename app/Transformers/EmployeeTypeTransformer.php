<?php

namespace App\Transformers;

use App\Models\EmployeeType;

class EmployeeTypeTransformer extends Transformer
{
    public function transform(EmployeeType $model)
    {
        $this->output = [
            'name'        => $model->name,
            'description' => $model->description,
        ];

        return $this->output;
    }
}