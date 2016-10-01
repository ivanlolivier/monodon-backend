<?php

namespace App\Model;

use Illuminate\Foundation\Auth\User;

class Employee extends User implements Authenticatable
{
    public function clinic()
    {
        return $this->belongsTo(Clinic::class);
    }

    public static function transformer()
    {
        // TODO: Implement transformer() method.
    }
}
