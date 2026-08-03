<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Label extends Model
{
  use HasFactory;
  protected $table = 'labels';

  protected $fillable = [
    'name'
  ];

  public function users()
  {
    return $this->belongsToMany(User::class);
  }

  /**
   * Validacion de las etiquetas para usuarios
   */
  public static function rules()
  {
    return [
      'name' => 'required|string|max:255|unique:labels',
    ];
  }

  /**
   * Traducción
   */
  public const messagesRules = [
    'name.required' => 'El nombre de la etiqueta es obligatorio.',
    'name.string' => 'El nombre de la etiqueta debe ser un texto válido.',
    'name.max' => 'El nombre no debe superar los 255 caracteres.',
    'name.unique' => 'Esta etiqueta ya existe.'
  ];
}
