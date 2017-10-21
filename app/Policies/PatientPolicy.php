<?php

namespace App\Policies;

use App\Models\Clinic;
use App\Models\Dentist;
use App\Models\Employee;
use App\Models\Patient;
use Illuminate\Auth\Access\HandlesAuthorization;

class PatientPolicy
{
    use HandlesAuthorization;

    public function addFCMToken($user)
    {
        return $user instanceof Patient;
    }

    public function createForClinic($user, Clinic $clinic)
    {
        if ($user instanceof Employee || $user instanceof Dentist) {
            return $user->worksOn($clinic);
        }

        return false;
    }

}
