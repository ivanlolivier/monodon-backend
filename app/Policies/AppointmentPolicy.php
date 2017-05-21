<?php

namespace App\Policies;

use App\Models\Appointment;
use App\Models\Clinic;
use App\Models\Dentist;
use App\Models\Employee;
use App\Models\Patient;
use Carbon\Carbon;
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

    public function cancel($user, Appointment $appointment)
    {
        if ($user instanceof Patient && $user->id != $appointment->patient_id) {
            return false;
        }

        if ($user instanceof Dentist && $user->id != $appointment->dentist_id) {
            return false;
        }

        if ($user instanceof Employee && $user->clinic_id != $appointment->clinic_id) {
            return false;
        }

        return true;
    }

}
