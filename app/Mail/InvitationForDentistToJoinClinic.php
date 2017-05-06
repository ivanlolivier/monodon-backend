<?php

namespace App\Mail;

use App\Models\Clinic;
use App\Models\Dentist;
use App\Models\Employee;
use App\Models\Invitation;

class InvitationForDentistToJoinClinic extends CommonBaseMail
{
    public $invitation;
    public $clinic;
    public $employee;
    public $dentist;

    public $email;
    public $token;

    public function __construct(Invitation $invitation, Clinic $clinic, Employee $employee, Dentist $dentist)
    {
        $this->invitation = $invitation;
        $this->clinic = $clinic;
        $this->employee = $employee;
        $this->dentist = $dentist;

        $this->subject = 'Invitación a Monodon';
    }

    public function build()
    {
        $this->title = 'Trabajas en la clinica "' . $this->clinic->name . '"?';

        $this->introLines = [
            $this->employee->name . ' te ha agregado como dentista de la clinica "' . $this->clinic->name . '"',
            'Si eres dentista en esa clinica haz click en el botón "Aceptar", sino en "Cancelar".'
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
            $this->buttons[0]['label'] . ': <a href="' . $this->buttons[0]['url'] . '">' . $this->buttons[0]['url'] . '</a>',
            $this->buttons[1]['label'] . ': <a href="' . $this->buttons[1]['url'] . '">' . $this->buttons[1]['url'] . '</a>',
        ];

        return $this->view('email.common');
    }
}
