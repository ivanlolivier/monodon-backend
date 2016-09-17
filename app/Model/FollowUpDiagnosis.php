<?php

namespace App\Model;

class FollowUpDiagnosis extends FollowUp
{
    public function diagnosis()
    {
        return $this->hasOne(Diagnosis::class);
    }
}
