<?php

namespace App\Notifications\Admin\Auth;

use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Support\HtmlString;
class ResetPassword extends Notification
{
    /**
     * The password reset token.
     *
     * @var string
     */
    public $token;

    /**
     * Create a notification instance.
     *
     * @param string $token
     * @return void
     */
    public function __construct($token)
    {
        $this->token = $token;
    }

    /**
     * Get the notification's channels.
     *
     * @param mixed $notifiable
     * @return array|string
     */
    public function via($notifiable)
    {
        return ['mail'];
    }

    /**
     * Build the mail representation of the notification.
     *
     * @param mixed $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        return (new MailMessage)
            ->from('semanaposgrado.bcs@gmail.com', 'SemanaDePosgradoBCS')
            ->subject(\Lang::getFromJson('Reset Password Notification'))
            ->greeting(\Lang::getFromJson('Hello!'))
            ->line(\Lang::getFromJson("You are receiving this email because we received a password reset request for your account."))
            ->action('Restablecer contraseña', url(config('app.url').route('admin.password.reset', $this->token, false)))
            ->line(\Lang::getFromJson("This password reset link will expire in :count minutes.",['count'=>'60']))
            ->line(\Lang::getFromJson('If you did not request a password reset, no further action is required.'));
    }
}
