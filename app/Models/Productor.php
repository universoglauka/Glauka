<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Productor extends Model
{

  protected $table = 'productores';

  protected $fillable = [
    'user_id',
    'name_group',
    'alias',
    'account_holder',
    'description',
    'genre_id',
  ];

  public function user()
  {
    return $this->belongsTo(User::class, 'user_id');
  }

  public function obras()
  {
    return $this->hasMany(Obra::class, 'productor_id');
  }

  public function genre()
  {
    return $this->belongsTo(Genre::class);
  }

  public function adaptation()
  {
    return $this->belongsTo(Adaptation::class);
  }

  public function announcements()
  {
    return $this->hasMany(Announcement::class);
  }

  public function statistics()
  {
    return $this->hasMany(
      ProductorStatistic::class,
      'user_id',
      'user_id'
    );
  }

  // Validación
  public static function profileProducerRulesEdit()
  {
    return [
      'name_group' => ['required', 'string', 'max:222', 'min:3'],
      'alias' => ['nullable', 'string', 'max:100'],
      'account_holder' => ['nullable', 'string', 'max:300'],
      'description' => ['nullable', 'string', 'max:100'],
      'genre_id' => ['exists:genres,id'],
    ];
  }

  // Traducción
  public const messagesProfileProducerRulesEdit = [
    'name_group.string' => 'El nombre del grupo debe ser un texto válido.',
    'name_group.max' => 'El nombre del grupo no debe superar los 255 caracteres.',
    'name_group.min' => 'El nombre del grupo debe tener al menos 3 caracteres.',

    'alias.string' => 'El alias debe ser un texto válido.',
    'alias.max' => 'El alias no debe superar los 100 caracteres.',

    'account_holder.string' => 'El titular debe ser un texto válido.',
    'account_holder.max' => 'El titular no debe superar los 300 caracteres.',

    'description.string' => 'La descripción debe ser un texto válido.',
    'description.max' => 'La descripción no debe superar los 100 caracteres.',
    'description.nullable' => 'La descripción debe ser un texto válido.',

    'genre_id.exists' => 'La categoría seleccionada no es válida.',
  ];
}
