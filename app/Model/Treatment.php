<?php

namespace App\Model;

class Treatment extends Model
{
    public function diagnosis()
    {
        return $this->hasOne(Diagnosis::class);
    }

    public function visits()
    {
        return $this->belongsTo(FollowUpTreatment::class);
    }
}
