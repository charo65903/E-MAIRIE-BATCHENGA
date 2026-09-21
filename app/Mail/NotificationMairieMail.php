<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class NotificationMairieMail extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(
        public string $titre,
        public string $corps,
    ) {}

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: $this->titre.' — E-Mairie Batchenga',
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.notification',
            with: [
                'titre' => $this->titre,
                'corps' => $this->corps,
            ],
        );
    }
}
