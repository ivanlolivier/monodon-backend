<?php

namespace App\Models;

use App\Transformers\AppointmentTransformer;

class Appointment extends _Model
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
        return new AppointmentTransformer();
    }
}
