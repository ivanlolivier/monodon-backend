<?php

namespace App\Models;

class PatientInformation extends _Model
{
    protected $fillable = ['information'];

    public function patient()
    {
        return $this->belongsTo(Patient::class);
    }

    public static function transformer()
    {
        // TODO: Implement transformer() method.
    }
}
