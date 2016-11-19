<?php

namespace App\Transformers;

use App\Models\Clinic;
use App\Models\Employee;
use App\Models\EmployeeType;

class EmployeeTransformer extends Transformer
{
    public function transform(Employee $model)
    {
        $this->output = [
            'id'        => $model->id,
            'name'      => $model->name,
            'email'     => $model->email,
            'clinic_id' => $model->clinic_id,
            'type_id'   => $model->employee_type_id,
        ];

        $this->replaceRelationship($model, 'clinic', Clinic::transformer());
        $this->replaceRelationship($model, 'type', EmployeeType::transformer());

        return $this->output;
    }
}