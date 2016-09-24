<?php

namespace App\Model;

use Laravel\Passport\HasApiTokens;

class Employee extends Model
{
    use HasApiTokens;

    public function clinic()
    {
        return $this->belongsTo(Clinic::class);
    }

    public static function transformer()
    {
        // TODO: Implement transformer() method.
    }
}
