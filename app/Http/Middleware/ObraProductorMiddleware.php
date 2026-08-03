<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class ObraProductorMiddleware
{
  /**
   * Handle an incoming request.
   *
   * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
   */
  public function handle(Request $request, Closure $next): Response
  {
    $user = Auth::user();
    // Permitir que el admin pase
    if($user->rol === 'admin'){
      return $next($request);
    }
    // Para, en general, verificar que el usuario es productor, sin importar la acción específica.
    if (!$user || $user->rol !== 'producer') {
      abort(403, 'No tienes permisos de productor.');
    }
    if (!$user || $user->rol == 'user') {
      abort(403, 'No tienes permisos de productor.');
    }


    if ($request->route()->getActionMethod() === 'show') {
      return $next($request);
    }

    //Obetener la obra 
    $obra = $request->route('obra');

    //Debe estar registrado, ser productor y que sea su obra
    if (!$user) {
      abort(403, 'Debes iniciar sesión.');
    }

    if ($obra) {
      if ($user->rol !== 'producer') {
        abort(403, 'No tienes permiso para esta acción.');
      }
      if ($user->productor->id !== $obra->productor_id) {
        abort(403, 'No tienes permiso para esta acción.');
      } 
    }

    return $next($request);
  }
}
