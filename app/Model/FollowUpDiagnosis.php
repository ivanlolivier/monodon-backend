<?php

namespace App\Model;

class FollowUpDiagnosis extends FollowUp
{
    public function diagnosis()
    {
        return $this->hasOne(Diagnosis::class);
    }

    public static function transformer()
    {
        // TODO: Implement transformer() method.
    }
}
