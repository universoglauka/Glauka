<?php

namespace App\Http\Controllers;

use App\Models\Obra;
use Illuminate\Http\Request;

class HomeController extends Controller
{
  public function index()
  {
    $obrasBanner = Obra::with('productor.user.plan')
      ->activas()
      ->where('solo_compartido', false)
      ->get();

    $pool = [];

    foreach ($obrasBanner as $obra) {
      // productor normal
      $peso = 1;

      // productor premium
      if ($obra->productor->user->plan->nombre == "Premium producer") {
        $peso = 4;
      }
      for ($i = 0; $i < $peso; $i++) {
        $pool[] = $obra;
      }
    }

    shuffle($pool);

    $bannerObras = collect($pool)
      ->unique('id')
      ->take(5);

    $novedades = Obra::activas()->where('solo_compartido', false)->latest()->take(3)->get();

    $todoPublico = Obra::activas()->where('clasificacion', 'todo publico')
      ->latest()
      ->take(3)
      ->get();

    $infantiles = Obra::activas()->where('clasificacion', 'infantil')
      ->latest()
      ->take(3)
      ->get();

    $adultos = Obra::activas()->where('clasificacion', 'adultos')
      ->latest()
      ->take(3)
      ->get();

    return view('home', compact('bannerObras', 'novedades', 'todoPublico', 'infantiles', 'adultos'));
  }
}
