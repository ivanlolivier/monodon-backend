<?php

namespace App\Models;

use App\Transformers\PatientInformationTransformer;

class PatientInformation extends _Model
{
    protected $fillable = ['information'];

    public function patient()
    {
        return $this->belongsTo(Patient::class);
    }

    /***************
     * TRANSFORMER *
     ***************/

    public static function transformer()
    {
        return new PatientInformationTransformer();
    }
}
