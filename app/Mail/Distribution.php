<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;
use Illuminate\Mail\Mailables\Headers;

class Distribution extends Mailable
{
    use Queueable, SerializesModels;

//    private $previous;
//    private $current;
    /**
     * Create a new message instance.
     *
     * @return void
     */
//    public function __construct()
//    {
////        $this->previous = $previous;
////        $this->current = $current;
//    }

    /**
     * Get the message envelope.
     *
     * @return \Illuminate\Mail\Mailables\Envelope
     */
    public function envelope()
    {
        return new Envelope(
            subject: 'Distribution',
        );
    }

    /**
     * Get the message content definition.
     *
     * @return \Illuminate\Mail\Mailables\Content
     */
    public function content()
    {
        return new Content(
            view: 'mail.distribution',
        );
    }

    /**
     * Get the attachments for the message.
     *
     * @return array
     */
    public function attachments()
    {
        return [];
    }

    /**
     * Get the message headers.
     *
     * @return \Illuminate\Mail\Mailables\Headers
     */
    public function headers()
    {
        return new Headers(
            text: [
                'Precedence' => 'Bulk',
                'List-Unsubscribe' => 'https://myDistr.xyz/unsub'
            ],
        );
    }
}
