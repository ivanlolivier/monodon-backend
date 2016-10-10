<?php

namespace App\Models;

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
        // TODO: Implement transformer() method.
    }
}
