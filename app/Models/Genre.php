<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Genre extends Model
{
  use HasFactory;
  protected $table = 'genres';

  protected $fillable = ['name'];

  public function obras()
  {
    return $this->belongsToMany(Obra::class, 'genre_obra');
  }

  public function productors()
  {
    return $this->hasMany(Productor::class);
  }

  // Validación
  public static function rules($id = null)
  {
    return [
      'name' => 'required|string|max:255|unique:genres,name,' . $id,
    ];
  }

  // Traducción
  public const messagesRules = [
    'name.required' => 'El nombre del género es obligatorio.',
    'name.string'   => 'El nombre del género debe ser un texto válido.',
    'name.max'      => 'El nombre no debe superar los 255 caracteres.',
    'name.unique'   => 'Este nombre ya está siendo utilizado.',
  ];
}
