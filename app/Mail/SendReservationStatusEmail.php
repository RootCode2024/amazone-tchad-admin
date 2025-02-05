<?php

namespace App\Mail;

use App\Models\Hotel;
use App\Models\Flight;
use App\Models\CarLocation;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Queue\SerializesModels;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Contracts\Queue\ShouldQueue;

class SendReservationStatusEmail extends Mailable
{
    use Queueable, SerializesModels;

    public $reservation;

    /**
     * Create a new message instance.
     */
    public function __construct($reservation)
    {
        if (!$reservation instanceof Flight && !$reservation instanceof Hotel && !$reservation instanceof CarLocation) {
            throw new \InvalidArgumentException("Invalid reservation type.");
        }

        $this->reservation = $reservation;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: __('Mise à jour du statut de votre réservation')
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'emails.reservation_status',
            with: [
                'clientName' => optional($this->reservation->client)->firstname ?? 'Client',
                'status' => $this->reservation->status
            ]
        );
    }

    /**
     * Get the attachments for the message.
     */
    public function attachments(): array
    {
        return [];
    }
}
