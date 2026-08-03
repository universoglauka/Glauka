<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Announcement extends Model
{
  protected $table = 'announcements';

  protected $fillable = [
    'productor_id',
    'title',
    'content',
    'expires_at'
  ];

  protected $casts = [
    'expires_at' => 'datetime',
  ];
  public function productor()
  {
    return $this->belongsTo(Productor::class);
  }


  /**
   * Validación
   */
  public static function rules()
  {
    return [
      'title' => 'required|string|min:3|max:255',
      'content' => 'required|string|min:10|max:3000',
      'expires_at' => 'nullable|date|after:today',
    ];
  }

  /**
   * Traducción
   */
  public const messagesRules = [


    'title.required' => 'El título es obligatorio.',
    'title.string' => 'El título debe ser un texto válido.',
    'title.min' => 'El título debe tener más de 3 caracteres.',
    'title.max' => 'El título no puede superar los 255 caracteres',

    'content.required' => 'El contenido de la publicación es obligatoria.',
    'content.string' => 'El contenido debe ser un texto válido.',
    'content.min' => 'El contenido debe tener más de 10 caracteres.',
    'content.max' => 'El contenido no puede superar los 3000 caracteres',


    'expires_at.after' => 'La publicación no puede vencerse antes de la fecha de publicación.',

  ];
}
