<?php

namespace App\Models;

use App\Transformers\ClinicTransformer;

class Clinic extends _Model
{
    protected $fillable = [
        'name',
        'address',
        'phones'
    ];


    /*************
     * RELATIONS *
     *************/

    public function dentists()
    {
        return $this->belongsToMany(Dentist::class);
    }

    public function patients()
    {
        return $this->belongsToMany(Patient::class);
    }

    public function employees()
    {
        return $this->hasMany(Employee::class);
    }


    /***************
     * TRANSFORMER *
     ***************/

    public static function transformer()
    {
        return new ClinicTransformer();
    }
}
