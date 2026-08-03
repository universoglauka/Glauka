<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MemberProduction extends Model
{
  use HasFactory;
  protected $table = 'members_production';

  protected $fillable = [
    'obra_id',
    'label_id',
    'name',
  ];

  public function obra()
  {
    return $this->belongsTo(Obra::class, 'obra_id');
  }

  public function label()
  {
    return $this->belongsTo(Label::class, 'label_id');
  }
}
