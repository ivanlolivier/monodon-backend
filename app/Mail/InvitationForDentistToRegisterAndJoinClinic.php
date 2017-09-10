<?php

namespace App\Mail;

use App\Models\Clinic;
use App\Models\Employee;
use App\Models\Invitation;

class InvitationForDentistToRegisterAndJoinClinic extends CommonBaseMail
{
    public $invitation;
    public $clinic;
    public $employee;

    public $email;
    public $token;

    public function __construct(Invitation $invitation, Clinic $clinic, Employee $employee)
    {
        $this->invitation = $invitation;
        $this->clinic = $clinic;
        $this->employee = $employee;

        $this->subject = 'Invitación a Monodon';
    }

    public function build()
    {
        $this->title = '¿Trabajas en la clinica "' . $this->clinic->name . '"?';

        $this->introLines = [
            $this->employee->name . ' te ha agregado como dentista de la clinica "' . $this->clinic->name . '"',
            'En "' . $this->clinic->name . '" utilizan Monodon para administrar la clinica y registrar las interacciones con los pacientes',
            'Si eres dentista en esa clinica haz click en el botón "Aceptar" para registrarte en Monodon y tener acceso a la clinica, sino en "Cancelar".'
        ];

        $this->buttons = [
            [
                'label' => 'Aceptar',
                'url'   => "http://www.monodon.uy/#/invitations/{$this->clinic->id}:{$this->invitation->token}/accept",
            ],
            [
                'label' => 'Cancelar',
                'url'   => "http://www.monodon.uy/#/invitations/{$this->clinic->id}:{$this->invitation->token}/reject",
            ]
        ];


        $this->outroLines = [
            'También puedes copiar y pegar o hacer click en estos links:',
            $this->buttons[0]['label'] . ': ' . $this->buttons[0]['url'],
            $this->buttons[1]['label'] . ': ' . $this->buttons[1]['url'],
        ];

        return $this->view('email.common');
    }
}
