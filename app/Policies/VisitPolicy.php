<?php

namespace App\Policies;

use App\Models\Dentist;
use App\Models\Employee;
use Illuminate\Auth\Access\HandlesAuthorization;

class VisitPolicy
{
    use HandlesAuthorization;

    public function create($user)
    {
        return ($user instanceof Dentist || $user instanceof Employee);
    }
}
