<?php

namespace App\Models;

use App\Models\Auth\CanAuthenticate;
use App\Transformers\PatientTransformer;
use SoapClient;
use Illuminate\Support\Facades\Config;

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
        //        'tags',
    ];

    protected $dates = [
        'created_at',
        'updated_at',
        'birthdate',
    ];

    public function setPhonesAttribute($value)
    {
        if (is_array($value)) {
            $value = implode(';', $value);
        }
        $this->attributes['phones'] = $value;
    }

    static public function boot()
    {
        parent::boot();

        if (Config::get('saluduy.modules_enabled.inus')) {
            Patient::created(function ($patient) {
                $client = new SoapClient(
                    "http://monodon-backend.test/agestionpacientes_services.xml",
                    ['soap_version' => SOAP_1_2, 'trace' => 1, 'classmap' => ['Person' => "Person", 'PersonList' => "PersonList"]]
                );
                //Registrar el paciente en el INUS
            });

            Patient::updated(function ($patient) {
                //Actualizar el paciente en el INUS
            });
        }
    }


    /*************
     * RELATIONS *
     *************/

    public function clinics()
    {
        return $this->belongsToMany(Clinic::class)->withTimestamps();
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
        return $this->hasManyThrough(NotificationSent::class, NotificationScheduled::class, 'patient_id',
            'notification_id');
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

    public function subscriptions()
    {
        return $this->hasMany(Subscription::class);
    }

    public function clinicInformations()
    {
        return $this->hasMany(ClinicPatientInformation::class);
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
