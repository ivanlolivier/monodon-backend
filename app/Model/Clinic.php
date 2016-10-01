<?php

namespace App\Model;

use App\Transformers\ClinicTransformer;

class Clinic extends Model
{
    protected $fillable = [
        'name',
        'address',
        'phones'
    ];

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

    public static function transformer()
    {
        return new ClinicTransformer();
    }
}
