<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Adaptation extends Model
{
  use HasFactory;
  protected $table = 'adaptations';

  protected $fillable = ['name'];

  public function obras()
  {
    return $this->belongsToMany(Obra::class, 'adaptation_obra');
  }

  public function productors()
  {
    return $this->hasMany(Productor::class);
  }
}
