<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;
use App\Models\Obra;

class ProductorNotificationCancelledMail extends Mailable
{
  use Queueable, SerializesModels;

  /**
   * Create a new message instance.
   */
  public function __construct(
    public Obra $obra,
    public string $motivo
  ) {}

  /**
   * Get the message envelope.
   */
  public function envelope(): Envelope
  {
    $asunto = $this->motivo === 'decision_admin'
      ? 'Tu obra "' . $this->obra->nombre_obra . '" fue cancelada.'
      : 'Se procesó la solicitud de cancelación de "' . $this->obra->nombre_obra . '"';

    return new Envelope(
      subject: $asunto,
    );
  }

  /**
   * Get the message content definition.
   */
  public function content(): Content
  {
    return new Content(
      view: 'emails.producer-play-cancelled',
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
