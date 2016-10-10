<?php

namespace App\Models;

use App\Models\Auth\CanAuthenticate;

class Employee extends _Model
{
    use CanAuthenticate;

    public function clinic()
    {
        return $this->belongsTo(Clinic::class);
    }

    public static function transformer()
    {
        // TODO: Implement transformer() method.
    }
}
