<?php

namespace App\Policies;

use App\Models\Dentist;
use Illuminate\Auth\Access\HandlesAuthorization;

class DentistPolicy
{
    use HandlesAuthorization;

    public function me($user)
    {
        return self::user_is_dentist($user);
    }

    public function clinics($user)
    {
        return self::user_is_dentist($user);
    }

    static private function user_is_dentist($user)
    {
        return ($user instanceof Dentist);
    }
}
