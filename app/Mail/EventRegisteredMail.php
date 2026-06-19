<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class EventRegisteredMail extends Mailable
{
    use Queueable, SerializesModels;

    public $userName;
    public $eventTitle;
    public $eventDate;

    /**
     * Create a new message instance.
     */
    public function __construct($userName, $eventTitle, $eventDate)
    {
        $this->userName = $userName;
        $this->eventTitle = $eventTitle;
        $this->eventDate = $eventDate;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Konfirmasi Pendaftaran Acara: ' . $this->eventTitle . ' 🌟',
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'emails.event_registered',
        );
    }
}
