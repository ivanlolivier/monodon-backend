<?php

namespace App\Model;

class File extends Model
{
    public function patient()
    {
        return $this->belongsTo(Patient::class);
    }
}
