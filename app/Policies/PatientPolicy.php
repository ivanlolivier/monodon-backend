<?php

namespace App\Policies;

use App\Models\Patient;
use Illuminate\Auth\Access\HandlesAuthorization;

class PatientPolicy
{
    use HandlesAuthorization;

    public function addFCMToken($user)
    {
        return $user instanceof Patient;
    }

}
