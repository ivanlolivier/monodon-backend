<?php

namespace App\Model;

class Derivation extends Model
{
    public function diagnosis()
    {
        return $this->belongsTo(Diagnosis::class);
    }
}
