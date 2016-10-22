<?php

namespace App\Models;

class FcmToken extends _Model
{
    protected $table = 'patient_fcm_tokens';

    /*************
     * RELATIONS *
     *************/

    public function patient()
    {
        return $this->belongsTo(Patient::class);
    }

    /***************
     * TRANSFORMER *
     ***************/

    public static function transformer()
    {
        throw new \Exception('FcmToken model does not have a transformer');
    }

    /********************
     * PUBLIC FUNCTIONS *
     ********************/
}
