<?php

namespace App\Transformers;

use App\Models\Clinic;
use App\Models\Employee;
use App\Models\EmployeeType;
use League\Fractal\TransformerAbstract;

class EmployeeTransformer extends TransformerAbstract
{

    public function transform(Employee $model)
    {
        $output = [
            'id'        => $model->id,
            'name'      => $model->name,
            'email'     => $model->email,
            'clinic_id' => $model->clinic_id,
            'type_id'   => $model->employee_type_id,
        ];

        if ($this->isRelationshipLoaded($model, 'clinic')) {
            $output['clinic'] = Clinic::transformer()->transform($model->clinic);
            unset($output['clinic_id']);
        }

        if ($this->isRelationshipLoaded($model, 'type')) {
            $output['type'] = EmployeeType::transformer()->transform($model->type);
            unset($output['type_id']);
        }

        return $output;
    }

    public function isRelationshipLoaded($model, $relation)
    {
        return array_key_exists($relation, $model->getRelations());
    }

}