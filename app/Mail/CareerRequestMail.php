<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class CareerRequestMail extends Mailable
{
    use Queueable, SerializesModels;

    public $info;

    public function __construct($info)
    {
        $this->info = $info;
    }

    public function build()
    {
        return $this->subject('Richiesta di lavoro ricevuta')
                    ->view('mail.career-request-mail');
    }

    public function envelope()
    {
        return new Envelope();
    }

    public function content()
    {
        return new Content(view: 'mail.career-request-mail');
    }

    public function attachments()
    {
        return [];
    }
}
