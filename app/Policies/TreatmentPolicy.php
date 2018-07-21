<?php

namespace App\Policies;

class TreatmentPolicy extends PolicyBase
{
    public function index($user)
    {
        return (self::user_is_dentist($user) || self::user_is_employee($user));
    }
}
