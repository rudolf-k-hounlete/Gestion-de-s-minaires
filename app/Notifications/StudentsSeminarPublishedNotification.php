<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\MailMessage;

class StudentsSeminarPublishedNotification extends Notification
{
    use Queueable;

    protected $seminar;

    public function __construct($seminar)
    {
        $this->seminar = $seminar;
    }

    public function via($notifiable)
    {
        return ['mail'];
    }

    public function toMail($notifiable)
    {
        $date  = $this->seminar->scheduled_date->translatedFormat('d/m/Y');
        $theme = $this->seminar->theme;

        return (new MailMessage)
                    ->subject('Nouveau séminaire publié : ' . $theme)
                    ->greeting('Bonjour ' . $notifiable->name . ',')
                    ->line("Un nouveau séminaire a été publié pour le **{$date}**.")
                    ->line("**Thème :** {$theme}")
                    ->line("**Résumé :**")
                    ->line($this->seminar->resume)
                    ->salutation('Cordialement,')->salutation('Le service des séminaires IMSP');
    }
}
