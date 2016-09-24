<?php

namespace App\Model;

class Derivation extends Model
{
    public function diagnosis()
    {
        return $this->belongsTo(Diagnosis::class);
    }

    public static function transformer()
    {
        // TODO: Implement transformer() method.
    }
}
