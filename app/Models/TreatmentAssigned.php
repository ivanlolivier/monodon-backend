<?php

namespace App\Models;

use App\Transformers\TreatmentAssignedTransformer;

class TreatmentAssigned extends _Model
{
    public function treatment()
    {
        return $this->belongsTo(Treatment::class);
    }

    public static function transformer()
    {
        return new TreatmentAssignedTransformer();
    }
}