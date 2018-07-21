<?php

namespace App\Policies;

use App\Models\Dentist;

class DentistPolicy extends PolicyBase
{
    public function me($user)
    {
        return self::user_is_dentist($user);
    }

    public function clinics($user)
    {
        return self::user_is_dentist($user);
    }

}
