<?php

namespace App\Models;

class Invitation extends _Model
{

    const TOKEN_LENGTH = 32;

    protected $fillable = [
        'email'
    ];

    protected $dates = [
        'sent_at',
        'used_at',
        'expired_at',
        'created_at',
        'updated_at',
    ];


    protected $casts = [
        'accepted' => 'boolean'
    ];

    /*************
     * RELATIONS *
     *************/

    public function clinic()
    {
        return $this->belongsTo(Clinic::class);
    }

    public function employee()
    {
        return $this->belongsTo(Employee::class);
    }

    public function dentist()
    {
        return $this->belongsTo(Dentist::class);
    }

    /***************
     * TRANSFORMER *
     ***************/

    public static function transformer()
    {
        //No needed
    }

    public function generateToken()
    {
        $this->token = str_random(self::TOKEN_LENGTH);
    }

}
