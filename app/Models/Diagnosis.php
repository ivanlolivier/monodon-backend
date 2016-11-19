<?php

namespace App\Models;

use App\Transformers\DiagnosisTransformer;

class Diagnosis extends _Model
{
    public function derivation()
    {
        return $this->hasOne(Derivation::class);
    }

    public function treatments()
    {
        return $this->hasMany(Treatment::class);
    }

    public static function transformer()
    {
        return new DiagnosisTransformer();
    }
}
