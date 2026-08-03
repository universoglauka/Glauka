<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Obra;
use App\Models\Genre;
use App\Models\Adaptation;

class CatalogController extends Controller
{
  public function catalog(Request $request)
  {
    $query = Obra::activas()
      ->where('solo_compartido', false);

    $clasificaciones = Obra::select('clasificacion')
      ->distinct()
      ->pluck('clasificacion');

    if ($request->filled('clasificacion')) {
      $query->where(
        'clasificacion',
        $request->clasificacion
      );
    }


    if ($request->filled('genres')) {
      $selectedGenres  = $request->input('genres');
      $query->whereHas('genres', function ($q) use ($selectedGenres) {
        $q->whereIn('genres.id', $selectedGenres);
      });
    }



    if ($request->filled('adaptations')) {
      $selectedAdaptations  = $request->input('adaptations');
      $query->whereHas('adaptations', function ($q) use ($selectedAdaptations) {
        $q->whereIn('adaptations.id', $selectedAdaptations);
      });
    }

    $obras = $query->paginate(12)->withQueryString();

    $genres = Genre::all();
    $adaptations = Adaptation::all();

    return view('catalog', compact('obras', 'genres', 'adaptations', 'clasificaciones'));
  }
}
