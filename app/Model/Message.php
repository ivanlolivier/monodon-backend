<?php

namespace App\Model;

class Message extends Model
{
    public function dentist()
    {
        return $this->belongsTo(Dentist::class);
    }

    public function clinic()
    {
        return $this->belongsTo(Clinic::class);
    }

    public function patients()
    {
        return $this->hasManyThrough(Patient::class, 'patient_messages');
    }
}
