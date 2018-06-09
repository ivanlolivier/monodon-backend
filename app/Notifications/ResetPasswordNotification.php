<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

class ResetPasswordNotification extends Notification
{
    use Queueable;

    public $email;
    public $token;

    public function __construct($email, $token)
    {
        $this->email = $email;
        $this->token = $token;
    }

    public function via($notifiable)
    {
        return ['mail'];

    }

    public function toMail()
    {
        return (new MailMessage)
            ->line('You are receiving this email because we received a password reset request for your account.')
            ->action('Reset Password', env('FRONTEND_BASE_URL') . '/password/reset/' . $this->email . '/' . $this->token)
            ->line('If you did not request a password reset, no further action is required.');
    }
}
