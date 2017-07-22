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

    public function treatment_assigned()
    {
        return $this->hasMany(Treatment::class);
    }

    public function isDerivation()
    {
        return $this->type == 'derivation';
    }

    public static function transformer()
    {
        return new DiagnosisTransformer();
    }
}
