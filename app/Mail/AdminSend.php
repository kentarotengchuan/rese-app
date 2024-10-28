<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class AdminSend extends Mailable
{
    use Queueable, SerializesModels;

    public $title;
    public $content;

    /**
     * Create a new message instance.
     */
    public function __construct($title,$content)
    {
        $this->title = $title;
        $this->content = $content;
    }

    /**
     * Get the message envelope.
     */
    /*public function envelope(): Envelope
    {
        //
    }

    /**
     * Get the message content definition.
     */
    /*public function content(): Content
    {
        //
    }

    /**
     * Get the attachments for the message.
     *
     * @return array<int, \Illuminate\Mail\Mailables\Attachment>
     */
    /*public function attachments(): array
    {
        return [];
    }*/

    public function build()
    {
        return $this->subject($this->title)
                    ->view('mail.admin-send');
    }
}
