<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Genre;
use App\Models\Productor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;

class ProductorRegisterController extends Controller
{
  /**
   * Display the registration view.
   */
  public function create()
  {
    $genres = Genre::all();
    return view('auth.productor-register', compact('genres'));
  }

  /**
   * Handle an incoming registration request.
   *
   * @throws \Illuminate\Validation\ValidationException
   */
  public function store(Request $request)
  {
    $validated = $request->validate([
      'name' => ['required', 'string', 'min:2', 'max:255'],
      'name_group' => ['nullable', 'string', 'min:2', 'max:255'],
      'genre_id' => ['nullable', 'exists:genres,id'],
      'description' => ['nullable', 'string', 'min:3'],
      'email' => ['required', 'string', 'email', 'max:255', 'unique:' . User::class],
      'userIcon' => ['nullable', 'image', 'mimes:jpeg,jpg,png,webp', 'max:2048'],
      'password' => ['required', 'confirmed',  'min:8', Rules\Password::defaults()],
    ], [
      'name.required' => 'El nombre es obligatorio.',
      'name.string' => 'El nombre debe ser un texto válido.',
      'name.max' => 'El nombre no debe superar los 255 caracteres.',
      'name.min' => 'El nombre debe tener al menos 2 caracteres.',

      'name_group.nullable' => 'El nombre del grupo debe ser un texto válido.',
      'name_group.string' => 'El nombre del grupo debe ser un texto válido.',
      'name_group.max' => 'El nombre del grupo no debe superar los 255 caracteres.',
      'name_group.min' => 'El nombre del grupo debe tener al menos 2 caracteres.',

      'genre_id.string' => 'La categoría debe ser un texto válido.',
      'genre_id.exists' => 'La categoría seleccionada no es válida.',

      'description.nullable' => 'La descripción debe ser un texto válido.',
      'description.string' => 'La descripción debe ser un texto válido.',
      'description.min' => 'La descripción es demaciado corta.',

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
    ]);
    $userIconPath = null;
    if ($request->hasFile('userIcon')) {
      $path = $request->file('userIcon')->store('imagenes/userIcon', 'public');
      $userIconPath = basename($path);
    }

    $user = User::create([
      'name' => $request->name,
      'email' => $request->email,
      'password' => Hash::make($request->password),
      'rol' => 'producer',
      'userIcon' => $userIconPath,
    ]);

    Productor::create([
      'user_id' => $user->id,
      'name_group' => $validated['name_group'],
      'description' => $validated['description'],
      'genre_id' => $validated['genre_id'],
    ]);

    if (Auth::check() && Auth::user()->rol == 'admin') {
      return redirect(route('admin.productores'))->with('success', 'Productor creado correctamente.');
    }
    Auth::login($user);
    return redirect()->route('home');
  }
}
