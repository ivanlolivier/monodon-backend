<?php

namespace App\Models;

class NewReason extends _Visit
{
    public function diagnosis()
    {
        return $this->hasOne(Diagnosis::class);
    }

    public function interrogation()
    {
        return $this->hasMany(VisitInterrogatory::class);
    }

    public static function transformer()
    {
        // TODO: Implement transformer() method.
    }
}
