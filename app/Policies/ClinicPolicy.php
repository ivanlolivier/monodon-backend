<?php

namespace App\Policies;

use App\Models\Clinic;
use App\Models\Dentist;
use App\Models\Employee;
use App\Models\Patient;

class ClinicPolicy extends PolicyBase
{
    public function show($user, Clinic $clinic)
    {
        if ($user instanceof Employee) {
            return $user->worksOn($clinic);
        }

        if (
            $user instanceof Patient ||
            $user instanceof Dentist
        ) {
            return $user->clinics()->get()->contains('id', $clinic->id);
        }

        return false;
    }

    public function update($user, Clinic $clinic)
    {
        if ($user instanceof Employee) {
            return $user->worksOn($clinic);
        }

        return false;
    }

    public function patients($user, Clinic $clinic)
    {
        if ($user instanceof Employee) {
            return $user->worksOn($clinic);
        }

        if ($user instanceof Dentist) {
            return $user->clinics()->get()->contains('id', $clinic->id);
        }

        return false;
    }

    public function dentists($user, Clinic $clinic)
    {
        if ($user instanceof Employee) {
            return $user->worksOn($clinic);
        }

        return false;
    }

    public function appointments($user, Clinic $clinic)
    {
        if ($user instanceof Employee) {
            return $user->worksOn($clinic);
        }

        return false;
    }

    public function invite_dentist($user, Clinic $clinic)
    {
        if ($user instanceof Employee) {
            return $user->worksOn($clinic);
        }

        return false;
    }

    public function see_invitations($user, Clinic $clinic)
    {
        if ($user instanceof Employee) {
            return $user->worksOn($clinic);
        }

        return false;
    }
}
