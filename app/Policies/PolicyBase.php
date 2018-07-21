<?php

namespace App\Policies;

use App\Models\Dentist;
use App\Models\Employee;
use App\Models\Patient;
use Illuminate\Auth\Access\HandlesAuthorization;

class PolicyBase
{
    use HandlesAuthorization;
    
    static protected function user_is_dentist($user)
    {
        return ($user instanceof Dentist);
    }
    
    static protected function user_is_employee($user)
    {
        return ($user instanceof Employee);
    }
    
    static protected function user_is_patient($user)
    {
        return ($user instanceof Patient);
    }
}