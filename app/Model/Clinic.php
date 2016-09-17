<?php

namespace App\Model;

class Clinic extends Model
{
    public function dentists()
    {
        return $this->hasManyThrough(Dentist::class, 'clinics_dentists');
    }
}
