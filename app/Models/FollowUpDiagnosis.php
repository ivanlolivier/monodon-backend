<?php

namespace App\Models;

class FollowUpDiagnosis extends _FollowUp
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
