<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;

class Obra extends Model
{
  use HasFactory;
  protected $table = 'obras';

  protected $fillable = [
    'productor_id',
    'nombre_obra',
    'autor',
    'clasificacion',
    'precio',
    'ubicacion',
    'imagen',
    'sinopsis',
    'slug',
    'solo_compartido',
    'cancelado',
    'eliminado'
  ];


  public function productor()
  {
    return $this->belongsTo(Productor::class, 'productor_id');
  }

  public function membersProduction()
  {
    return $this->hasMany(MemberProduction::class, 'obra_id');
  }

  public function ticketdetalles()
  {
    return $this->hasMany(TicketDetalle::class, 'obra_id');
  }

  public function performance()
  {
    return $this->hasMany(Performance::class);
  }

  public function cancelar()
  {
    $this->update([
      'cancelado' => true,
    ]);

    $this->performance()->update([
      'cancelado' => true,
    ]);
  }

  public function eliminarLogicamente()
  {
    $this->update([
      'cancelado' => true,
      'eliminado' => true,
    ]);

    $this->performance()->update([
      'cancelado' => true,
    ]);
  }

  public function puedeEliminarseDefinitivamente()
  {
    return !$this->ticketdetalles()->exists();
  }

  public function actualizarEstadoCancelacion()
  {
    if (
      $this->performance()
      ->where('cancelado', false)
      ->doesntExist()
    ) {

      $this->update([
        'cancelado' => true
      ]);
    }
  }

  public function genres()
  {
    return $this->belongsToMany(Genre::class, 'genre_obra');
  }

  public function adaptations()
  {
    return $this->belongsToMany(Adaptation::class, 'adaptation_obra');
  }

  public function cartItems()
  {
    return $this->hasMany(CartItems::class);
  }

  public function usersFavorites()
  {
    return $this->belongsToMany(User::class, 'favorites');
  }

  /**
   * Validación
   */
  public static function rules()
  {
    return [
      'fechaObra1' => ['required', 'date', 'after_or_equal:today', 'before_or_equal:' . now()->addDays(7)->toDateString()],
      'horaObra1' => 'required',
      'stockEntradasObra1' => 'required|integer|min:5',

      'fechaObra2' => ['nullable', 'date', 'after_or_equal:today', 'before_or_equal:' . now()->addDays(7)->toDateString()],
      'horaObra2' => 'nullable|required_with:fechaObra2',
      'stockEntradasObra2' => 'nullable|integer|min:5|required_with:fechaObra2',

      'fechaObra3' => ['nullable', 'date', 'after_or_equal:today', 'before_or_equal:' . now()->addDays(7)->toDateString()],
      'horaObra3' => 'nullable|required_with:fechaObra3',
      'stockEntradasObra3' => 'nullable|integer|min:5|required_with:fechaObra3',

      'fechaObra4' => ['nullable', 'date', 'after_or_equal:today', 'before_or_equal:' . now()->addDays(7)->toDateString()],
      'horaObra4' => 'nullable|required_with:fechaObra4',
      'stockEntradasObra4' => 'nullable|integer|min:5|required_with:fechaObra4',

      'fechaObra5' => ['nullable', 'date', 'after_or_equal:today', 'before_or_equal:' . now()->addDays(7)->toDateString()],
      'horaObra5' => 'nullable|required_with:fechaObra5',
      'stockEntradasObra5' => 'nullable|integer|min:5|required_with:fechaObra5',

      'fechaObra6' => ['nullable', 'date', 'after_or_equal:today', 'before_or_equal:' . now()->addDays(7)->toDateString()],
      'horaObra6' => 'nullable|required_with:fechaObra6',
      'stockEntradasObra6' => 'nullable|integer|min:5|required_with:fechaObra6',

      'linkVirtual1' => 'nullable|max:5000|url',
      'linkVirtual2' => 'nullable|max:5000|url',
      'linkVirtual3' => 'nullable|max:5000|url',
      'linkVirtual4' => 'nullable|max:5000|url',
      'linkVirtual5' => 'nullable|max:5000|url',
      'linkVirtual6' => 'nullable|max:5000|url',

      'nombre_obra'   => 'required|string|max:255',
      'autor'   => 'nullable|string|max:255',
      'clasificacion'   => 'nullable|string',
      'precio'   => 'required|numeric|min:0|max:999999.99',
      'ubicacion'  => 'required|string|max:5000',
      'imagen'   => 'image|mimes:jpeg,png,webp|max:2048',
      'sinopsis'  => 'required|string|max:5000',
      'genres'        => 'required|array',
      'genres.*'      => 'exists:genres,id',
      'adaptaciones' => 'nullable|array',
    ];
  }

  /**
   * Traducción
   */
  public const messagesRules = [
    'fechaObra1.required' => 'La primer fecha es obligatoria.',
    'fechaObra1.before_or_equal' => 'La fecha de la obra no puede ser más de 7 días desde hoy.',
    'fechaObra1.after_or_equal' => 'La fecha de la obra no puede ser anterior a hoy.',
    'horaObra1.required' => 'El primer horario es obligatorio.',
    'stockEntradasObra1.required' => 'Se necesita un primer stock de entradas.',
    'stockEntradasObra1.min' => 'El stock debe ser igual o mayor a 5.',


    'fechaObra2.before_or_equal' => 'La fecha de la obra no puede ser más de 7 días desde hoy.',
    'fechaObra2.after_or_equal' => 'La fecha de la obra no puede ser anterior a hoy.',
    'horaObra2.required_with' => 'El segundo horario es obligatorio mientras haya segunda función.',
    'stockEntradasObra2.required_with' => 'El segundo stock de entradas es obligatorio mientras haya segunda función.',
    'stockEntradasObra2.min' => 'El stock debe ser igual o mayor a 5.',

    'fechaObra3.before_or_equal' => 'La fecha de la obra no puede ser más de 7 días desde hoy.',
    'fechaObra3.after_or_equal' => 'La fecha de la obra no puede ser anterior a hoy.',
    'horaObra3.required_with' => 'El tercer horario es obligatorio mientras haya tercera función.',
    'stockEntradasObra3.required_with' => 'El tercer stock de entradas es obligatorio mientras haya tercera función.',
    'stockEntradasObra3.min' => 'El stock debe ser igual o mayor a 5.',

    'fechaObra4.before_or_equal' => 'La fecha de la obra no puede ser más de 7 días desde hoy.',
    'fechaObra4.after_or_equal' => 'La fecha de la obra no puede ser anterior a hoy.',
    'horaObra4.required_with' => 'El cuarto horario es obligatorio mientras haya cuarta función.',
    'stockEntradasObra4.required_with' => 'El cuarto stock de entradas es obligatorio mientras haya cuarta función.',
    'stockEntradasObra4.min' => 'El stock debe ser igual o mayor a 5.',

    'fechaObra5.before_or_equal' => 'La fecha de la obra no puede ser más de 7 días desde hoy.',
    'fechaObra5.after_or_equal' => 'La fecha de la obra no puede ser anterior a hoy.',
    'horaObra5.required_with' => 'El quinto horario es obligatorio mientras haya quinta función.',
    'stockEntradasObra5.required_with' => 'El quinto stock de entradas es obligatorio mientras haya quinta función.',
    'stockEntradasObra5.min' => 'El stock debe ser igual o mayor a 5.',

    'fechaObra6.before_or_equal' => 'La fecha de la obra no puede ser más de 7 días desde hoy.',
    'fechaObra6.after_or_equal' => 'La fecha de la obra no puede ser anterior a hoy.',
    'horaObra6.required_with' => 'El sexto horario es obligatorio mientras haya sexta función.',
    'stockEntradasObra6.required_with' => 'El sexto stock de entradas es obligatorio mientras haya sexta función.',
    'stockEntradasObra6.min' => 'El stock debe ser igual o mayor a 5.',

    'linkVirtual1.url' => 'Debes ingresar un enlace válido.',
    'linkVirtual1.max' => 'El enlace no puede superar los 5000 caracteres.',

    'linkVirtual2.url' => 'Debes ingresar un enlace válido.',
    'linkVirtual2.max' => 'El enlace no puede superar los 5000 caracteres.',

    'linkVirtual3.url' => 'Debes ingresar un enlace válido.',
    'linkVirtual3.max' => 'El enlace no puede superar los 5000 caracteres.',

    'linkVirtual4.url' => 'Debes ingresar un enlace válido.',
    'linkVirtual4.max' => 'El enlace no puede superar los 5000 caracteres.',

    'linkVirtual5.url' => 'Debes ingresar un enlace válido.',
    'linkVirtual5.max' => 'El enlace no puede superar los 5000 caracteres.',

    'linkVirtual6.url' => 'Debes ingresar un enlace válido.',
    'linkVirtual6.max' => 'El enlace no puede superar los 5000 caracteres.',

    'nombre_obra.required' => 'Es necesario el nombre de la obra.',
    'nombre_obra.max' => 'El nombre no puede tener más de 255 caracteres',
    'autor.string' => 'El nombre debe ser un texto válido.',
    'autor.max' => 'El autor no puede tener más de 255 caracteres',
    'precio.required' => 'El precio es obligatorio.',
    'ubicacion.required' => 'La ubicación es obligatoria.',
    'ubicacion.string' => 'La ubicación debe ser un texto válido',
    'imagen.image' => 'El archivo debe ser una imagen',
    'imagen.mimes' => 'La imagen debe ser un archivo tipo: jpeg,jpg,webp',
    'imagen.max' => 'La imagen no puede exceder los 2MB.',
    'sinopsis.string' => 'La sinópsis debe tener un texto válido.',
    'sinopsis.required' => 'La sinópsis es obligatoria.',
    'sinopsis.max' => 'La sinópsis no puede tener más de 5000 caracteres.',

    'genres.required' => 'Debe seleccionar al menos un género.',
    'genres.*.exists' => 'El género seleccionado no es válido.',
  ];

  // Scope para ver obras aún activas
  public function scopeActivas(Builder $query)
  {
    return $query
      ->where('cancelado', false)
      ->where('eliminado', false)
      ->where('solo_compartido', false)
      ->whereHas(
        'performance',
        function (Builder $q) {
          $q->where('cancelado', false)
            ->where('fechaObra', '>=', now()->toDateString());
        }
      );
  }

  //Mostrar solo la función activa
  public function primeraFuncionDisponible()
  {
    return $this->performance
      ->where('cancelado', false)
      ->sortBy(fn($p) => $p->fechaObra . ' ' . $p->horaObra)
      ->first();
  }
}
