<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Support\HtmlString;



class RevisionTrabajo extends Notification implements ShouldQueue
{
    use Queueable;
    private $mensaje,$id_trabajo;
    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($mensaje,$id_trabajo)
    {
        $this->mensaje = $mensaje;
        $this->id_trabajo = $id_trabajo;

    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        //dd($this->id_trabajo);
        return (new MailMessage)
                    ->line(new HtmlString('Tu director de tesis ha revisado tu Trabajo, tu trabajo fue: <strong> <label style="text-decoration: underline">'.$this->mensaje['revisado'].'</label></strong>'))
                    ->line(new HtmlString('<strong>Comentarios:</strong>'))
                    ->line(new HtmlString('<i>'.$this->mensaje['comentario'].'</i>'))
                    ->action('Modificar trabajo',route('trabajo.show',$this->id_trabajo));
    }

    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        return [
            //
        ];
    }
}
