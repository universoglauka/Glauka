<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Genre;

class GenreController extends Controller
{

  public function store(Request $request)
  {
    $validated = $request->validate(Genre::rules(), Genre::messagesRules);
    Genre::create($validated);

    return redirect()->route('admin.obras')->with('success', 'Género creado exitosamente.');
  }


  public function update(Request $request, Genre $genre)
  {
    $validated = $request->validate(Genre::rules($genre->id), Genre::messagesRules);
    $genre->update($validated);

    return redirect()->route('admin.obras')->with('success', 'Género actualizado exitosamente.');
  }


  public function destroy(Genre $genre)
  {
    $genre->delete();
    return redirect()->route('admin.obras')->with('success', 'Género eliminado exitosamente.');
  }
}
