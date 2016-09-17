<?php

namespace App\Model;

class Patient extends Model
{
    public function visits()
    {
        return $this->hasMany(Visit::class);
    }

    public function files()
    {
        return $this->hasMany(File::class);
    }

    public function interrogation()
    {
        return $this->hasMany(PatientInterrogatory::class);
    }

}
