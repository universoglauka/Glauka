<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TicketEntry extends Model
{
  protected $fillable = [
    'ticketdetalles_id',
    'codigo',
    'checked_at',
    'checked_by',
  ];

  public function ticketdetalles()
  {
    return $this->belongsTo(TicketDetalle::class);
  }

  public function validator()
  {
    return $this->belongsTo(
      User::class,
      'checked_by'
    );
  }
}
