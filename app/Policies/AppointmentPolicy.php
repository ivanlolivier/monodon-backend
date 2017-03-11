<?php

namespace App\Policies;

use App\Models\Appointment;
use App\Models\Clinic;
use App\Models\Employee;
use Illuminate\Auth\Access\HandlesAuthorization;

class AppointmentPolicy
{
    use HandlesAuthorization;

    public function listForClinic($user, Clinic $clinic)
    {
        if ($user instanceof Employee) {
            return $user->worksOn($clinic);
        }

        return false;
    }

    public function createForClinic($user, Clinic $clinic)
    {
        if ($user instanceof Employee) {
            return $user->worksOn($clinic);
        }

        return false;
    }

    public function updateForClinic($user, Appointment $appointment, Clinic $clinic)
    {
        if ($appointment->clinic_id != $clinic->id) {
            return false;
        }

        if ($user instanceof Employee) {
            return $user->worksOn($clinic);
        }

        return false;
    }

    public function deleteForClinic($user, Appointment $appointment, Clinic $clinic)
    {
        if ($appointment->clinic_id != $clinic->id) {
            return false;
        }

        if ($user instanceof Employee) {
            return $user->worksOn($clinic);
        }

        return false;
    }
}
