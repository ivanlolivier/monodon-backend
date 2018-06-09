<?php

namespace App\Mail;

use App\Models\Clinic;
use App\Models\Patient;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Config;

class InformingUserCreatedInClinic extends Mailable
{
    use Queueable, SerializesModels;

    public $patient;
    public $clinic;
    public $inviter;

    public function __construct(Patient $patient, Clinic $clinic, $inviter)
    {
        $this->patient = $patient;
        $this->clinic = $clinic;
        $this->inviter = $inviter;

        $this->subject = 'Te agregaron en una clinica';
    }

    public function build()
    {
        $this->title = 'Te agregaron como paciente de la clinica "' . $this->clinic->name . '"';

        $this->introLines = [
            $this->inviter->name . ' te ha agregado como paciente de la clinica "' . $this->clinic->name . '"',
            'Recuerda que contamos con una app movile para ti donde podrás ver la información de tus tratamientos, recibir recordatorios e indicaciones y más. Puedes descargar la app con el siguiente link (actualmente solo disponible para celulares Android).'
        ];

        $this->buttons = [
            [
                'label' => 'Descargar',
                'url'   => Config::get('app.ANDROID.LINK'),
            ],
        ];

        $this->outroLines = [
            'Si no te atiendes en esa clinica por favor escribenos a noclinica@monodon.uy y arreglaremos el problema.',
            'Si no recuerdas tu contraseña para usar la app mobile 
            puedes researla desde la app.',
        ];

        return $this->view('email.common');
    }
}
