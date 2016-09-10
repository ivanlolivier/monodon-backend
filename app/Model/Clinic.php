<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Clinic extends Model
{
    public function dentists()
    {
        return $this->hasManyThrough(Dentist::class, 'clinics_dentists');
    }
}
