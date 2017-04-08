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
    }

    public function build()
    {
        $this->title = 'Trabajas en la clinica' . $this->clinic->name . '?';

        $this->introLines = [
            $this->employee->name . ' te ha agregado como dentista de la clinica ' . $this->clinic->name,
            'Si eres dentista en esa clinica haz click en el botón "Aceptar", sino en "Cancelar".'
        ];

        $this->buttons = [
            [
                'text' => 'Aceptar',
                'url'  => "http://www.monodon.uy/#/invitations/{$this->invitation->token}/accept",
            ],
            [
                'text' => 'Cancelar',
                'url'  => "http://www.monodon.uy/#/invitations/{$this->invitation->token}/reject",
            ]
        ];


        $this->outroLines = [
            'También puedes copiar y pegar o hacer click en estos links:',
            $this->buttons[0]['text'] . ': <a href="' . $this->buttons[0]['url'] . '">' . $this->buttons[0]['url'] . '</a>',
            $this->buttons[1]['text'] . ': <a href="' . $this->buttons[1]['url'] . '">' . $this->buttons[1]['url'] . '</a>',
        ];

        return $this->view('email.common');
    }
}
