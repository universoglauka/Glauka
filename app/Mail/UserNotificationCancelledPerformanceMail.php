<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;
use App\Models\Performance;
use App\Models\User;
use Carbon\Carbon;

class UserNotificationCancelledPerformanceMail extends Mailable
{
  use Queueable, SerializesModels;

  /**
   * Create a new message instance.
   */
  public function __construct(
    public Performance $performance,
    public User $usuario
  ) {}

  /**
   * Get the message envelope.
   */
  public function envelope(): Envelope
  {
    $fecha = Carbon::parse($this->performance->fechaObra)->format('d/m/Y');

    return new Envelope(
      subject: 'La función del ' . $fecha . ' de la obra "' . $this->performance->obra->nombre_obra . '" fue cancelada.',
    );
  }

  /**
   * Get the message content definition.
   */
  public function content(): Content
  {
    return new Content(
      view: 'emails.user-performance-cancelled',
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
