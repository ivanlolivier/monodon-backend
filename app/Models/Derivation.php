<?php

namespace App\Models;

class Derivation extends _Model
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
