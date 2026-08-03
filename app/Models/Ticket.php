<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ticket extends Model
{
  use HasFactory;
  protected $table = 'tickets';

  protected $fillable = [
    'user_id',
    'total',
    'datos_usuario',
    'payment_id',
    'preference_id',
    'estado_pago'
  ];
  protected $casts = [
    'datos_usuario' => 'array',
  ];

  public function user()
  {
    return $this->belongsTo(User::class, 'user_id');
  }

  public function ticketdetalles()
  {
    return $this->hasMany(TicketDetalle::class, 'ticket_id');
  }
  public function refunds()
  {
    return $this->hasMany(Refund::class);
  }
}
