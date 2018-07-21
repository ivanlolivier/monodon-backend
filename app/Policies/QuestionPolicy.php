<?php

namespace App\Policies;

class QuestionPolicy extends PolicyBase
{
    public function index($user)
    {
        return (self::user_is_dentist($user) || self::user_is_employee($user));
    }
}
