<?php

namespace App\Transformers;

use App\Models\Clinic;
use App\Models\Dentist;
use App\Models\Employee;
use App\Models\Invitation;

class InvitationTransformer extends Transformer
{
    public function transform(Invitation $model)
    {
        $this->output = [
            'clinic_id'   => $model->clinic_id,
            'dentist_id'  => $model->dentist_id,
            'employee_id' => $model->employee_id,

            'email'      => $model->email,
            'accepted'   => $model->accepted,
            'used_at'    => $model->used_at ? $model->used_at->toDateString() : null,
            'expired_at' => $model->expired_at ? $model->expired_at->toDateString() : null
        ];

        $this->replaceRelationship($model, 'clinic', Clinic::transformer());
        $this->replaceRelationship($model, 'dentist', Dentist::transformer());
        $this->replaceRelationship($model, 'employee', Employee::transformer());

        return $this->output;
    }
}