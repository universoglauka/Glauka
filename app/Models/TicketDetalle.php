<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TicketDetalle extends Model
{
  use HasFactory;
  protected $table = 'ticketdetalles';

  protected $fillable = [
    'ticket_id',
    'obra_id',
    'performance_id',
    'nombre_obra',
    'es_virtual',
    'nombre_productor',
    'fecha_hora_obra',
    'codigo',
    'cantidad',
    'emails_virtuales',
    'precio_u',
    'subtotal'
  ];

  protected $casts = [
    'emails_virtuales' => 'array',
  ];

  public function ticket()
  {
    return $this->belongsTo(Ticket::class, 'ticket_id');
  }

  public function obra()
  {
    return $this->belongsTo(Obra::class, 'obra_id');
  }

  public function performance()
  {
    return $this->belongsTo(Performance::class, 'performance_id');
  }

  public function ticketEntries()
  {
    return $this->hasMany(
      TicketEntry::class,
      'ticketdetalles_id'
    );
  }
}
