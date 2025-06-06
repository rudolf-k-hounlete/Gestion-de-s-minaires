<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\MailMessage;

class RequestResumeNotification extends Notification
{
    use Queueable;

    protected $seminar;

    /**
     * @param  \App\Models\Seminar  $seminar
     */
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
                    ->subject('Rappel : Envoyez votre résumé pour votre séminaire du ' . $date)
                    ->greeting('Bonjour ' . $this->seminar->presenter->name . ',')
                    ->line("Votre séminaire intitulé « {$this->seminar->theme} » est programmé le **{$date}**.")
                    ->line("Il vous reste **10 jours** avant la date de présentation. Merci de bien vouloir soumettre le résumé de votre travail en vous rendant sur la plateforme.")
                    ->line("Si vous avez déjà envoyé votre résumé, merci d’ignorer ce message.")
                    ->salutation('Cordialement,')->salutation('Le service des séminaires IMSP');
    }
}
