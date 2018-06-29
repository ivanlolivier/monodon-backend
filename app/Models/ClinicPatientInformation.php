<?php

namespace App\Models;

use App\Models\Auth\CanAuthenticate;
use App\Transformers\PatientTransformer;

class ClinicPatientInformation extends _Model
{
    use CanAuthenticate;

    protected $fillable = [
        'patient_id',
        'clinic_id',
        'name',
        'surname',
        'document_type',
        'document',
        'birthdate',
        'sex',
        'photo',
        'phones',
        'email',
        'tags',
    ];

    protected $dates = [
        'created_at',
        'updated_at',
        'birthdate',
    ];

    public function setPhonesAttribute($value)
    {
        $this->attributes['phones'] = implode(';', $value);
    }


    /*************
     * RELATIONS *
     *************/

    public function patient()
    {
        return $this->belongsTo(Patient::class);
    }

    public function clinics()
    {
        return $this->belongsTo(Clinic::class);
    }

    /***************
     * TRANSFORMER *
     ***************/

    public static function transformer()
    {
        return new PatientTransformer();
    }
}
