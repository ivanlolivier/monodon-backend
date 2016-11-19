<?php

namespace App\Models;

use App\Transformers\TreatmentTransformer;

class Treatment extends _Model
{
    public function diagnosis()
    {
        return $this->hasOne(Diagnosis::class);
    }

    public function visits()
    {
        return $this->belongsTo(FollowUpTreatment::class);
    }

    public static function transformer()
    {
        return new TreatmentTransformer();
    }
}
