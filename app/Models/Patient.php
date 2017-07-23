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

    public function clinics()
    {
        return $this->belongsToMany(Clinic::class);
    }

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

    public function fcmTokens()
    {
        return $this->hasMany(FcmToken::class);
    }

    public function appointments()
    {
        return $this->hasMany(Appointment::class);
    }

    public function lastVisitInClinic(Clinic $clinic)
    {
        return $this->hasOne(Visit::class)->where('clinic_id', $clinic->id)->latest();
    }

    public function informations()
    {
        return $this->hasMany(PatientInformation::class);
    }

    public function notificationsScheduled()
    {
        return $this->hasMany(NotificationScheduled::class);
    }

    public function notificationsSent()
    {
        return $this->hasManyThrough(NotificationSent::class, NotificationScheduled::class, 'patient_id', 'notification_id');
    }

    public function messages()
    {
        return $this->belongsToMany(Message::class);
    }

    public function treatmentsAssigned()
    {
        return $this->hasMany(TreatmentAssigned::class);
    }

    public function activeTreatments()
    {
        return $this->treatmentsAssigned()->where('is_finished', false);
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

    public function isSeenAt(Clinic $clinic)
    {
        return $this->clinics()->get()->contains('id', $clinic->id);
    }

}
