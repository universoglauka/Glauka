<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\TicketEntry;
use App\Models\Obra;
use App\Models\Performance;
use Illuminate\Support\Facades\Auth;

class TicketEntryController extends Controller
{
  public function index(Request $request, Performance $performance)
  {
    $entries = TicketEntry::whereHas('ticketdetalles', function ($query) use ($performance) {
      $query->where('performance_id', $performance->id);
    });

    if ($search = $request->search) {
      $entries->where(function ($query) use ($search) {
        $query->where('codigo', 'like', "%{$search}%")
          ->orWhereHas('ticketdetalles.ticket.user', function ($q) use ($search) {
            $q->where('name', 'like', "%{$search}%");
          })
          ->orWhereHas('ticketdetalles.ticket', function ($q) use ($search) {
            $q->where('datos_usuario->nombre', 'like', "%{$search}%");
          });
      });
    }

    $entries = $entries
      ->with(['ticketdetalles.ticket.user'])
      ->orderBy('codigo')
      ->get();

    return view('productor.obras.ticket-entries', compact('performance', 'entries'));
  }

  public function checkIn(TicketEntry $entry)
  {
    if ($entry->checked_at) {
      return back()->with(
        'error',
        'La entrada ya fue utilizada.'
      );
    }

    $entry->update([
      'checked_at' => now(),
      'checked_by' => Auth::id(),
    ]);

    return back()->with(
      'success',
      'Entrada validada.'
    );
  }

  public function search(Request $request)
  {
    $request->validate([
      'codigo' => 'required'
    ]);

    $entry = TicketEntry::where(
      'codigo',
      $request->codigo
    )->first();

    if (!$entry) {
      return back()->with(
        'error',
        'Código no encontrado.'
      );
    }

    if ($entry->checked_at) {
      return back()->with(
        'error',
        'La entrada ya fue utilizada.'
      );
    }

    $entry->update([
      'checked_at' => now(),
      'checked_by' => Auth::id(),
    ]);

    return back()->with(
      'success',
      'Ingreso registrado correctamente.'
    );
  }

  public function undo(TicketEntry $entry)
  {
    $entry->update([
      'checked_at' => null,
      'checked_by' => null,
    ]);

    return back()->with('success', 'Asistencia revertida a pendiente.');
  }
}
