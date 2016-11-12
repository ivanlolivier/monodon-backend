<?php

namespace App\Models;

use App\Models\Auth\CanAuthenticate;
use App\Transformers\PatientTransformer;

class Patient extends _Model
{
    use CanAuthenticate;

    protected $fillable = [
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


    /*************
     * RELATIONS *
     *************/

    public function visits()
    {
//        return $this->hasMany(Visit::class);
    }

    public function files()
    {
        return $this->hasMany(File::class);
    }

    public function interrogation()
    {
        return $this->hasMany(PatientInterrogatory::class);
    }

    public function fcmTokens()
    {
        return $this->hasMany(FcmToken::class);
    }


    /***************
     * TRANSFORMER *
     ***************/

    public static function transformer()
    {
        return new PatientTransformer();
    }


    /********************
     * PUBLIC FUNCTIONS *
     ********************/

}
