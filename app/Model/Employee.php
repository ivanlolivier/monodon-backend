<?php

namespace App\Model;

class Employee extends Model
{
    public function clinic()
    {
        return $this->belongsTo(Clinic::class);
    }
}
