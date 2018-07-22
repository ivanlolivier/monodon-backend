<?php

namespace App\Policies;

use App\Models\Clinic;
use App\Models\Dentist;
use App\Models\Employee;
use App\Models\Patient;

class PatientPolicy extends PolicyBase
{
    public function addFCMToken($user)
    {
        return self::user_is_patient($user);
    }
    
    public function showForClinic($user, Patient $patient, Clinic $clinic)
    {
        if ($user instanceof Employee || $user instanceof Dentist) {
            return $user->worksOn($clinic) && $patient->isSeenAt($clinic);
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
    
    public function updateForClinic($user, Patient $patient, Clinic $clinic)
    {
        if ($user instanceof Employee || $user instanceof Dentist) {
            return $user->worksOn($clinic) && $patient->isSeenAt($clinic);
        }
        
        return false;
    }
    
    public function generateCda($user, Patient $patient)
    {
        if ($user instanceof Dentist) {
            //TODO: agregar que el paciente se atienda con el dentista
            return true;
        }
        
        return false;
    }
    
}
