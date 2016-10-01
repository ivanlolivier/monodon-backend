<?php

namespace App\Model;

use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Dentist extends Authenticatable
{
    use SoftDeletes;

    public function clinics()
    {
        return $this->belongsToMany(Clinic::class);
    }
}
