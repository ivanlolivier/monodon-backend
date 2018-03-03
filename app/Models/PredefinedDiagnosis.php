<?php

namespace App\Models;

use App\Transformers\PredefinedDiagnosisTransformer;

class PredefinedDiagnosis extends _Model
{
    protected $table = 'predefined_diagnosis';

    public function diagnoses()
    {
        return $this->belongsToMany(Diagnosis::class);
    }

    public static function transformer()
    {
        return new PredefinedDiagnosisTransformer();
    }
}
