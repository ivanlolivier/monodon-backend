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
            $this->buttons[0]['text'] . ': ' . $this->buttons[0]['url'],
            $this->buttons[1]['text'] . ': ' . $this->buttons[1]['url'],
        ];

        return $this->view('email.common');
    }
}
