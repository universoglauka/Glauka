<?php

namespace App\Http\Controllers;

use App\Models\Label;
use Illuminate\Http\Request;

class LabelController extends Controller
{

  public function store(Request $request)
  {
    $validated = $request->validate(Label::rules(), Label::messagesRules);
    Label::create($validated);

    return redirect()->route('admin.usuarios')->with('success', 'Etiqueta creada exitosamente.');
  }


  public function update(Request $request, Label $label)
  {
    $validated = $request->validate(Label::rules(), Label::messagesRules);
    $label->update($validated);

    return redirect()->route('admin.usuarios')->with('success', 'Etiqueta actualizada exitosamente.');
  }


  public function destroy(Label $label)
  {
    $label->delete();
    return redirect()->route('admin.usuarios')->with('success', 'Etiqueta eliminada exitosamente.');
  }
}
