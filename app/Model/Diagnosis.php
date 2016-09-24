<?php

namespace App\Model;

class Diagnosis extends Model
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
