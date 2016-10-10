<?php

namespace App\Models;

class FollowUpTreatment extends _FollowUp
{
    public function treatment()
    {
        return $this->hasOne(Treatment::class);
    }

    public static function transformer()
    {
        // TODO: Implement transformer() method.
    }
}
