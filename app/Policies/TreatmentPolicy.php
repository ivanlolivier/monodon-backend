<?php

namespace App\Policies;

use App\Models\Dentist;
use Illuminate\Auth\Access\HandlesAuthorization;

class TreatmentPolicy
{
    use HandlesAuthorization;

    public function index($user)
    {
        return ($user instanceof Dentist);
    }
}
