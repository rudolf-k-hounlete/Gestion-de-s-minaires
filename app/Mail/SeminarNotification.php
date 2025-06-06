<?php

namespace App\Mail;

use App\Models\Seminar;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class SeminarNotification extends Mailable
{
    use Queueable, SerializesModels;

    public $seminar;

    /**
     * Create a new message instance.
     */
    public function __construct(Seminar $seminar)
    {
        $this->seminar = $seminar;
    }

    /**
     * Build the message.
     */
    public function build()
    {
        return $this->subject('Votre demande de séminaire est acceptée')
                    ->markdown('emails.seminar.notification');
    }
}
