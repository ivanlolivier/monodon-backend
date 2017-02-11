<?php

namespace App\Models;

use App\Transformers\AppointmentTransformer;

class Appointment extends _Model
{
    protected $fillable = [
        'title',
        'description',
        'datetime',
    ];

    protected $dates = [
        'datetime',
        'created_at',
        'updated_at',
    ];

    public function clinic()
    {
        return $this->belongsTo(Clinic::class);
    }

    public function dentist()
    {
        return $this->belongsTo(Dentist::class);
    }

    public function patient()
    {
        return $this->belongsTo(Patient::class);
    }

    public static function transformer()
    {
        return new AppointmentTransformer();
    }
}
