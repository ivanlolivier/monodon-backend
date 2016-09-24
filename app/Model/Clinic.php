<?php

namespace App\Model;

use App\Transformers\ClinicTransformer;

class Clinic extends Model
{
    public function dentists()
    {
        return $this->hasManyThrough(Dentist::class, 'clinics_dentists');
    }

    public static function transformer()
    {
        return new ClinicTransformer();
    }
}
