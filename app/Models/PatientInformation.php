<?php

namespace App\Models;

use App\Transformers\PatientInformationTransformer;

class PatientInformation extends _Model
{
    protected $fillable = ['information'];

    protected $dates = [
        'read_at',
        'created_at',
        'updated_at',
    ];

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
