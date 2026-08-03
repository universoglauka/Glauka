<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;
use App\Models\Performance;
use Carbon\Carbon;

class ProductorNotificationCancelledPerformanceMail extends Mailable
{
  use Queueable, SerializesModels;

  /**
   * Create a new message instance.
   */
  public function __construct(
    public Performance $performance,
    public string $motivo
  ) {}

  /**
   * Get the message envelope.
   */
  public function envelope(): Envelope
  {
    $fecha = Carbon::parse($this->performance->fechaObra)->format('d/m/Y');

    $asunto = $this->motivo === 'decision_admin'
      ? 'Se canceló la función del ' . $fecha . ' de "' . $this->performance->obra->nombre_obra . '".'
      : 'Se procesó la solicitud de cancelación de la función del ' . $fecha . ' de "' . $this->performance->obra->nombre_obra . '".';
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
      view: 'emails.producer-performance-cancelled',
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
