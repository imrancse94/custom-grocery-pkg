<?php

namespace Imrancse94\Grocery\app\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;
use Imrancse94\Grocery\app\Models\PreOrder;

class PreOrderAdminNotification extends Mailable
{
    use Queueable, SerializesModels;

    public $preOrder;
    /**
     * Create a new message instance.
     */

    public function __construct($preOrder)
    {
        $this->preOrder = $preOrder;
    }
    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'New Pre-order Notification',
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'grocery::emails.admin_notification',
            with: ['preOrder' => $this->preOrder]
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
