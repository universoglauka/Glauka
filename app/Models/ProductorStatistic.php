<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProductorStatistic extends Model
{

  protected $table = 'productor_statistics';
  protected $fillable = [
    'user_id',
    'year',
    'month',
    'total_revenue',
    'total_tickets',
  ];

  public function productor()
  {
    return $this->belongsTo(Productor::class, 'user_id', 'user_id');
  }
}
