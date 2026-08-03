<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\View\View;

class RegisteredUserController extends Controller
{
  /**
   * Display the registration view.
   */
  public function create(): View
  {
    return view('auth.register');
  }

  /**
   * Handle an incoming registration request.
   *
   * @throws \Illuminate\Validation\ValidationException
   */
  public function store(Request $request): RedirectResponse
  {
    $request->validate(User::rules(), User::messagesRules);
    $userIconPath = null;
    if ($request->hasFile('userIcon')) {
      $path = $request->file('userIcon')->store('imagenes/userIcon', 'public');
      $userIconPath = basename($path);
    }

    $user = User::create([
      'name' => $request->name,
      'nicknameUser' => $request->nicknameUser,
      'email' => $request->email,
      'userIcon' => $userIconPath,
      'password' => Hash::make($request->password),
    ]);

    event(new Registered($user));

    if (Auth::check() && Auth::user()->rol == 'admin') {
      return redirect(route('admin.usuarios'))->with('success', 'Usuario creado correctamente.');
    }

    Auth::login($user);
    return redirect(route('home', absolute: false));
  }
}
