<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Performance extends Model
{
  use HasFactory;
  protected $table = 'performances';

  protected $fillable = [
    'obra_id',
    'fechaObra',
    'horaObra',
    'stock',
    'linkVirtual',
    'estado_pago',
    'visible_admin',
    'cancelado'
  ];

  public function obra()
  {
    return $this->belongsTo(Obra::class);
  }

  public function cartItems()
  {
    return $this->hasMany(CartItems::class);
  }

  public function ticketdetalles()
  {
    return $this->hasMany(TicketDetalle::class);
  }

  public function cancel()
  {
    $this->update([
      'cancelado' => true
    ]);
  }
}
