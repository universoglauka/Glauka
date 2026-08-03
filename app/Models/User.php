<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;

use Illuminate\Contracts\Auth\CanResetPassword;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Validation\Rules;

class User extends Authenticatable
{
  /** @use HasFactory<\Database\Factories\UserFactory> */
  use HasFactory, Notifiable;

  /**
   * The attributes that are mass assignable.
   *
   * @var list<string>
   */
  protected $fillable = [
    'name',
    'nicknameUser',
    'email',
    'userIcon',
    'description',
    'password',
    'rol',
    'plan_id',
  ];

  /**
   * The attributes that should be hidden for serialization.
   *
   * @var list<string>
   */
  protected $hidden = [
    'password',
    'remember_token',
  ];

  /**
   * Get the attributes that should be cast.
   *
   * @return array<string, string>
   */
  protected function casts(): array
  {
    return [
      'email_verified_at' => 'datetime',
      'password' => 'hashed',
    ];
  }

  public function productor()
  {
    return $this->hasOne(Productor::class, 'user_id');
  }
  public function tickets()
  {
    return $this->hasMany(Ticket::class, 'user_id');
  }
  public function cart()
  {
    return $this->hasOne(CanResetPassword::class, 'user_id');
  }
  public function labels()
  {
    return $this->belongsToMany(
      Label::class,
      'label_user',
      'user_id',
      'label_id'
    );
  }
  public function plan()
  {
    return $this->belongsTo(Plan::class);  
  }

  public function subscriptions()
  {
    return $this->hasMany(Subscription::class);
  }

  public function favorites()
  {
    return $this->belongsToMany(Obra::class, 'favorites');
  }

  /**
   * Validacion de registro de usuarios
   */
  public static function rules()
  {
    return [
      'name' => ['required', 'string', 'max:255', 'min:3'],
      'nicknameUser' => ['required', 'string', 'max:255', 'min:3', 'unique:users,nicknameUser'],
      'email' => ['required', 'string', 'email', 'max:255', 'unique:' . User::class],
      'userIcon' => ['nullable', 'image', 'mimes:jpeg,jpg,png,webp', 'max:2048'],
      'password' => ['required', 'confirmed', 'min:8', Rules\Password::defaults()],
    ];
  }


  /**
   * Traducción
   */
  public const messagesRules = [
    'name.required' => 'El nombre es obligatorio.',
    'name.string' => 'El nombre debe ser un texto válido.',
    'name.max' => 'El nombre no debe superar los 255 caracteres.',
    'name.min' => 'El nombre debe tener al menos 3 caracteres.',

    'nicknameUser.required' => 'El nombre de usuario es obligatorio.',
    'nicknameUser.string' => 'El nombre de usuario debe ser un texto válido.',
    'nicknameUser.max' => 'El nombre de usuario no debe superar los 255 caracteres.',
    'nicknameUser.min' => 'El nombre de usuario debe tener al menos 3 caracteres.',
    'nicknameUser.unique' => 'El nombre de usuario ya está registrado.',

    'email.required' => 'El correo electrónico es obligatorio.',
    'email.string' => 'El correo electrónico debe ser un texto válido.',
    'email.email' => 'El correo electrónico debe tener un formato válido (ejemplo@dominio.com).',
    'email.max' => 'El correo electrónico no debe superar los 255 caracteres.',
    'email.unique' => 'El correo electrónico ya está registrado.',

    'userIcon.image' => 'El archivo subido debe ser una imagen.',
    'userIcon.mimes' => 'La imagen debe ser un archivo de tipo: jpeg, jpg, png, o webp.',
    'userIcon.max' => 'La imagen no debe superar los 2MB de tamaño.',

    'password.required' => 'La contraseña es obligatoria.',
    'password.confirmed' => 'La confirmación de la contraseña no coincide.',
    'password.min' => 'La contraseña debe tener al menos 8 caracteres.',
  ];


  /**
   * Validacion para editar usuarios
   */
  public static function profileRulesEdit($userId, $rol)
  {
    $rules = [
      'name' => ['required', 'string', 'max:255', 'min:3'],
      'email' => ['required', 'string', 'email', 'max:255', 'unique:users,email,' . $userId],
      'userIcon' => ['nullable', 'image', 'mimes:jpeg,jpg,png,webp', 'max:2048'],
      'description' => ['nullable', 'string', 'max:100'],
    ];

    if ($rol === 'user') {
      $rules['nicknameUser'] = ['required', 'string', 'max:255', 'min:3', 'unique:users,nicknameUser,' . $userId];
      $rules['labels'] = ['nullable', 'array', 'max:3'];
      $rules['labels.*'] = ['exists:labels,id'];
    }

    return $rules;
  }


  /**
   * Traducción
   */
  public const messagesProfileRulesEdit = [
    'name.required' => 'El nombre es obligatorio.',
    'name.string' => 'El nombre debe ser un texto válido.',
    'name.max' => 'El nombre no debe superar los 255 caracteres.',
    'name.min' => 'El nombre debe tener al menos 3 caracteres.',

    'nicknameUser.required' => 'El nombre de usuario es obligatorio.',
    'nicknameUser.string' => 'El nombre de usuario debe ser un texto válido.',
    'nicknameUser.max' => 'El nombre de usuario no debe superar los 255 caracteres.',
    'nicknameUser.min' => 'El nombre de usuario debe tener al menos 3 caracteres.',
    'nicknameUser.unique' => 'El nombre de usuario ya está registrado.',

    'email.required' => 'El correo electrónico es obligatorio.',
    'email.string' => 'El correo electrónico debe ser un texto válido.',
    'email.email' => 'El correo electrónico debe tener un formato válido (ejemplo@dominio.com).',
    'email.max' => 'El correo electrónico no debe superar los 255 caracteres.',
    'email.unique' => 'El correo electrónico ya está registrado.',

    'userIcon.image' => 'El archivo subido debe ser una imagen.',
    'userIcon.mimes' => 'La imagen debe ser un archivo de tipo: jpeg, jpg, png, o webp.',
    'userIcon.max' => 'La imagen no debe superar los 2MB de tamaño.',

    'description.nullable' => 'La descripción debe ser un texto válido.',
    'description.string' => 'La descripción debe ser un texto válido.',
    'description.max' => 'La descripción no debe superar los 100 caracteres.',

    'labels.array' => 'Las etiquetas deben ser un arreglo.',
    'labels.max' => 'No puedes seleccionar más de 3 etiquetas.',
    'labels.*.exists' => 'Una o más etiquetas seleccionadas no son válidas.',
  ];
}
