<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CartItems extends Model

{
  protected $table = 'cart_items';

  protected $fillable = [
    'cart_id',
    'obra_id',
    'performance_id',
    'cantidad',
    'emails_virtuales',
    'stock_alert_sent',
  ];

  protected $casts = [
    'emails_virtuales' => 'array',
  ];

  public function cart()
  {
    return $this->belongsTo(Carts::class, 'cart_id');
  }

  public function obra()
  {
    return $this->belongsTo(Obra::class);
  }

  public function performance()
  {
    return $this->belongsTo(Performance::class);
  }
}
