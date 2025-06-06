<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\MailMessage;

class NotifySecretaryToPublishNotification extends Notification
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
        $date = $this->seminar->scheduled_date->translatedFormat('d/m/Y');

        return (new MailMessage)
                    ->subject('Le séminaire du ' . $date . ' est prêt à être publié')
                    ->greeting('Bonjour,')
                    ->line("Le résumé du séminaire « {$this->seminar->theme} » (prévu le {$date}) a été soumis avec succès.")
                    ->line("Vous pouvez désormais **publier** la date, le thème et le résumé pour diffusion aux étudiants.")
                    ->salutation('Cordialement,')->salutation('Le service des séminaires IMSP');
    }
}
