<?php

namespace App\Mail;

use App\Models\Barber;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class StatusChangeNotification extends Mailable
{
    use Queueable, SerializesModels;
    public $barber;
    public $statusField;
    public $newValue;

    /**
     * Create a new message instance.
     */
    public function __construct(Barber $barber, string $statusField, bool $newValue)
    {
        $this->barber = $barber;
        $this->statusField = $statusField;
        $this->newValue = $newValue;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Perubahan Status Barber',
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            markdown: 'emails.barber-status-change',
        );
    }

    /**
     * Get the attachments for the message.
     *
     * @return array<int, \Illuminate\Mail\Mailables\Attachment>
     */
    public function attachments(): array
    {
        return [];
    }
}
