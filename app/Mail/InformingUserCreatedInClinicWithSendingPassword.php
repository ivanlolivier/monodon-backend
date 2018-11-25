<?php

namespace App\Mail;

use App\Models\Clinic;
use App\Models\Patient;
use Illuminate\Support\Facades\Config;

class InformingUserCreatedInClinicWithSendingPassword extends CommonBaseMail
{
    public $patient;
    public $password;
    public $clinic;
    public $inviter;

    public function __construct(Patient $patient, $password, Clinic $clinic, $inviter)
    {
        $this->patient = $patient;
        $this->password = $password;
        $this->clinic = $clinic;
        $this->inviter = $inviter;

        $this->subject = 'Te agregaron en una clinica + Nueva cuenta de Monodon app';
    }

    public function build()
    {
        $this->title = 'Te agregaron como paciente de la clinica "' . $this->clinic->name . '"';

        $this->introLines = [
            $this->inviter->name . ' te ha agregado como paciente de la clinica "' . $this->clinic->name . '"',
            'También te hemos creado un usuario para que puedas usar nuestra app para celulares Android donde podrás ver la información de tus tratamientos, recibir recordatorios e indicaciones y más.',
            'Tu usuario es tu email y tu contraseña es: ' . $this->password,
            'Puedes descargar la app con el siguiente link.'
        ];

        $this->buttons = [
            [
                'html' => "<a href='" . Config::get('app.ANDROID.LINK') . "'><img alt='Disponible en Google Play' src='https://play.google.com/intl/en_us/badges/images/generic/es-419_badge_web_generic.png'/></a>",
            ],
        ];

        $this->outroLines = [
            'Si no te atiendes en esa clinica por favor escribenos a noclinica@monodon.uy y arreglaremos el problema.',
        ];

        return $this->view('email.common');
    }
}
