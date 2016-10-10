<?php

namespace App\Models;

use App\Models\Auth\CanAuthenticate;
use Illuminate\Database\Eloquent\SoftDeletes;

class Dentist extends _Model
{
    use SoftDeletes, CanAuthenticate;

    public function clinics()
    {
        return $this->belongsToMany(Clinic::class);
    }

    public static function transformer()
    {
        // TODO: Implement transformer() method.
    }
}
