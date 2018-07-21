<?php

namespace App\Policies;

use App\Models\Appointment;
use App\Models\Clinic;
use App\Models\Dentist;
use App\Models\Employee;
use App\Models\Patient;

class AppointmentPolicy extends PolicyBase
{
    public function listForClinic($user, Clinic $clinic)
    {
        if ($user instanceof Employee) {
            return $user->worksOn($clinic);
        }

        return false;
    }

    public function createForClinic($user, Clinic $clinic)
    {
        if ($user instanceof Employee || $user instanceof Dentist) {
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

        if ($user instanceof Dentist) {
            return $user->worksOn($clinic) && $appointment->dentist->id == $user->id;
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

        if ($user instanceof Dentist) {
            return $user->worksOn($clinic) && $appointment->dentist_id == $user->id;
        }

        return false;
    }

    public function cancel($user, Appointment $appointment)
    {
        if ($user instanceof Patient) {
            return $user->id == $appointment->patient_id;
        }

        if ($user instanceof Dentist) {
            return $user->id == $appointment->dentist_id;
        }

        if ($user instanceof Employee) {
            return $user->clinic_id != $appointment->clinic_id;
        }

        return false;
    }

}
