<?php

namespace App\Policies;

class VisitPolicy extends PolicyBase
{
    public function create($user)
    {
        return (self::user_is_dentist($user) || self::user_is_employee($user));
    }
}
