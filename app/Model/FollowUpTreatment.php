<?php

namespace App\Model;

class FollowUpTreatment extends FollowUp
{
    public function treatment()
    {
        return $this->hasOne(Treatment::class);
    }
}
