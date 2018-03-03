<?php

namespace App\Models;

use App\Transformers\DiagnosisTransformer;

class Diagnosis extends _Model
{
    protected $table = 'diagnosis';

    protected $fillable = ['type', 'description', 'parent_diagnosis_id'];

    public function derivation()
    {
        return $this->hasOne(Derivation::class);
    }

    public function predefined()
    {
        return $this->belongsToMany(PredefinedDiagnosis::class);
    }

    public function isDerivation()
    {
        return $this->type == 'derivation';
    }

    public function isPredefined()
    {
        return $this->type == 'predefined';
    }

    public static function transformer()
    {
        return new DiagnosisTransformer();
    }
}
