<?php

namespace App\Model;

abstract class Visit extends Model
{
    protected $table = 'visits';

    public function patient()
    {
        return $this->belongsTo(Patient::class);
    }

    public function dentist()
    {
        return $this->belongsTo(Dentist::class);
    }

    public function clinic()
    {
        return $this->belongsTo(Clinic::class);
    }
}
