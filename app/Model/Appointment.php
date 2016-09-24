<?php

namespace App\Model;

class Appointment extends Model
{
    public function dentist()
    {
        return $this->belongsTo(Dentist::class);
    }

    public function patient()
    {
        return $this->belongsTo(Patient::class);
    }

    public static function transformer()
    {
        // TODO: Implement transformer() method.
    }
}
