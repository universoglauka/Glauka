<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use App\Models\Obra;
use App\Models\User;
use App\Models\Genre;
use App\Models\Adaptation;
use App\Models\Productor;
use App\Models\CartItems;
use App\Models\Performance;
use App\Models\Label;
use App\Mail\PlayDeletedMail;
use App\Mail\ProductorNotificationCancelledMail;
use App\Mail\UserNotificationCancelledMail;
use App\Models\Ticket;

class ObraController extends Controller
{
  /**
   * Display a listing of the resource.
   */
  public function index()
  {
    /** @var \App\Models\User $user */
    $obras = Auth::user()->productor
      ->obras
      ->where('eliminado', false);
    return view('productor.obras.index', compact('obras'));
  }

  public function obrasAll()
  {
    $obras = Obra::with(['productor.user', 'performance', 'membersProduction.label', 'ticketdetalles'])->paginate(10);
    $genres = Genre::withCount('obras')->get();
    return view('admin.obras', compact('obras', 'genres'));
  }

  /**
   * Show the form for creating a new resource.
   */
  public function create()
  {
    $genres = Genre::all();
    $adaptations = Adaptation::all();
    $productores = Productor::with('user')->get();
    $labels = Label::all();
    return view('productor.obras.create', compact('genres', 'adaptations', 'productores', 'labels'));
  }

  /**
   * Store a newly created resource in storage.
   */
  public function store(Request $request)
  {
    $camposValidados = $request->validate(Obra::rules(), Obra::messagesRules);

    // Generos de la obra
    $generosIds = $request->input('genres');
    unset($camposValidados['genres']);

    // Adaptaciones
    $adaptacionesIds = $request->input('adaptations');
    unset($camposValidados['adaptations']);

    // Imagen (si tiene)
    if ($request->hasFile('imagen')) {
      $path = $request->file('imagen')->store('/imagenes');
      $camposValidados['imagen'] = basename($path);
    }

    // Que se guarde a nombre de otro usuario
    if (Auth::user()->rol == 'admin') {
      $camposValidados['productor_id'] = $request->productor_id;
    } else {
      $camposValidados['productor_id'] = Auth::user()->productor->id;
    }

    // Que solo se vea por link
    $camposValidados['solo_compartido'] = $request->has('solo_compartido');

    //Link slug
    $slugBase = Str::slug($request->nombre_obra);
    $slug = $slugBase;
    $contador = 1;

    while (Obra::where('slug', $slug)->exists()) {
      $slug = $slugBase . '-' . $contador;
      $contador++;
    }
    $camposValidados['slug'] = $slug;


    $obra = Obra::create($camposValidados);


    if ($request->has('genres')) {
      $obra->genres()->attach($generosIds);
    }

    if ($request->has('adaptations')) {
      $obra->adaptations()->attach($adaptacionesIds);
    }

    $obra->membersProduction()->delete();
    foreach ($request->input('members', []) as $member) {
      if (empty($member['name']) || empty($member['label_id'])) {
        continue;
      }

      $obra->membersProduction()->create([
        'label_id' => $member['label_id'],
        'name' => $member['name'],
      ]);
    }


    $obra->performance()->create([
      'fechaObra' => $request->fechaObra1,
      'horaObra'  => $request->horaObra1,
      'stock'     => $request->stockEntradasObra1,
      'linkVirtual'     => $request->linkVirtual1,
    ]);


    if (Auth::user()->plan_id == 4) {
      for ($i = 2; $i <= 6; $i++) {
        if ($request->filled("fechaObra{$i}")) {
          $obra->performance()->create([
            'fechaObra' => $request->input("fechaObra{$i}"),
            'horaObra'  => $request->input("horaObra{$i}"),
            'stock'     => $request->input("stockEntradasObra{$i}"),
            'linkVirtual'     => $request->input("linkVirtual{$i}"),
          ]);
        }
      }
    } else {
      for ($i = 2; $i <= 3; $i++) {
        if ($request->filled("fechaObra{$i}")) {
          $obra->performance()->create([
            'fechaObra' => $request->input("fechaObra{$i}"),
            'horaObra'  => $request->input("horaObra{$i}"),
            'stock'     => $request->input("stockEntradasObra{$i}"),
            'linkVirtual'     => $request->input("linkVirtual{$i}"),
          ]);
        }
      }
    }

    if (Auth::user()->rol == 'admin') {
      return redirect()->route('admin.obras')->with('success', 'Obra cargada exitosamente.');
    } else {
      return redirect()->route('obras.index')->with('success', 'Obra cargada exitosamente.');
    }
  }

  /**
   * Display the specified resource.
   */
  public function show(Request $request, Obra $obra)
  {
    if (Auth::user()->rol !== 'admin' && Auth::user()->rol !== 'producer') {
      if ($obra->solo_compartido) {
        abort(404);
      }
    }

    if (
      Auth::user()->rol === 'producer' && Auth::user()->rol === 'user' &&
      $obra->eliminado
    ) {
      abort(404);
    }

    if (Auth::user()->rol == 'user') {
      $obra->load([
        'membersProduction.label',
        'performance' => function ($query) {
          $query->where('cancelado', false)
            ->orderBy('fechaObra')
            ->orderBy('horaObra');
        }
      ]);
    } else {
      $obra->load('membersProduction.label');
    }

    $labels = Label::all();

    /** @var \App\Models\User $user */
    $user = Auth::user();
    $user->load('favorites');

    $cartItem = null;

    if ($request->filled('cartItem')) {
      $cartItem = CartItems::where('id', $request->cartItem)
        ->whereHas('cart', fn($q) =>
        $q->where('user_id', Auth::id()))
        ->first();
    }
    return view('productor.obras.show', compact('obra', 'cartItem', 'labels'));
  }

  /**
   * Show the plays that can only be viewed via a link.
   */
  public function showPrivado(Request $request, string $slug)
  {
    $obra = Obra::where('slug', $slug)->firstOrFail();

    if (!$obra->solo_compartido) {
      return redirect()->route('obras.show', $obra);
    }

    $obra->load('membersProduction.label');
    $labels = Label::all();

    $cartItem = null;

    if ($request->filled('cartItem')) {
      $cartItem = CartItems::where('id', $request->cartItem)
        ->whereHas('cart', fn($q) =>
        $q->where('user_id', Auth::id()))
        ->first();
    }

    return view('productor.obras.show', compact('obra', 'cartItem', 'labels'));
  }

  /**
   * Show the form for editing the specified resource.
   */
  public function edit(Obra $obra)
  {
    $genres = Genre::all();
    $adaptations = Adaptation::all();
    $labels = Label::all();

    $obra->load('genres', 'adaptations', 'membersProduction.label');
    $productores = Productor::with('user')->get();

    return view('productor.obras.edit', compact('obra', 'genres', 'adaptations', 'productores', 'labels'));
  }

  /**
   * Update the specified resource in storage.
   */
  public function update(Request $request, Obra $obra)
  {
    $camposValidados = $request->validate(Obra::rules(), Obra::messagesRules);

    $camposValidados['adaptaciones'] = $request->has('adaptaciones')
      ? implode('|', $request->input('adaptaciones'))
      : null;

    if ($request->hasFile('imagen')) {
      if ($obra->imagen && Storage::exists('imagenes/' . $obra->imagen)) {
        Storage::delete('imagenes/' . $obra->imagen);
      }
      $path = $request->file('imagen')->store('/imagenes');
      $camposValidados['imagen'] = basename($path);
    } else {
      $camposValidados['imagen'] = $obra->imagen;
    }

    if (Auth::user()->rol == 'admin') {
      $camposValidados['productor_id'] = $request->productor_id;
    } else {
      $camposValidados['productor_id'] = Auth::user()->productor->id;
    }

    // Actualiza si se ve o no
    $camposValidados['solo_compartido'] = $request->has('solo_compartido');

    // Cambiar slug si cambia el nombre
    if ($obra->nombre_obra !== $request->nombre_obra) {
      $slugBase = Str::slug($request->nombre_obra);
      $slug = $slugBase;
      $contador = 1;

      while (Obra::where('slug', $slug)->where('id', '!=', $obra->id)->exists()) {
        $slug = $slugBase . '-' . $contador;
        $contador++;
      }
      $camposValidados['slug'] = $slug;
    }

    $obra->update($camposValidados);

    $obra->genres()->sync($request->input('genres', []));

    $obra->adaptations()->sync($request->input('adaptations', []));

    $obra->membersProduction()->delete();
    foreach ($request->input('members', []) as $member) {
      if (empty($member['name']) || empty($member['label_id'])) {
        continue;
      }

      $obra->membersProduction()->create([
        'label_id' => $member['label_id'],
        'name' => $member['name'],
      ]);
    }


    $max = Auth::user()->plan_id == 4 ? 6 : 3;

    for ($i = 1; $i <= $max; $i++) {
      if (!$request->filled("fechaObra{$i}")) {
        continue;
      }


      if ($request->filled("performance_id{$i}")) {
        $datos = [
          'stock' => $request->input("stockEntradasObra{$i}"),
          'linkVirtual' => $request->filled("linkVirtual{$i}")
            ? $request->input("linkVirtual{$i}")
            : null,
        ];
        if (Auth::user()->rol === 'admin') {
          $datos['fechaObra'] = $request->input("fechaObra{$i}");
          $datos['horaObra'] = $request->input("horaObra{$i}");
        }
      } else {
        $datos = [
          'fechaObra'   => $request->input("fechaObra{$i}"),
          'horaObra'    => $request->input("horaObra{$i}"),
          'stock'       => $request->input("stockEntradasObra{$i}"),
          'linkVirtual' => $request->filled("linkVirtual{$i}")
            ? $request->input("linkVirtual{$i}")
            : null,
        ];
      }


      if ($request->filled("performance_id{$i}")) {
        Performance::findOrFail($request->input("performance_id{$i}"))
          ->update($datos);
      } else {
        $obra->performance()->create($datos);
      }
    }

    if (Auth::user()->rol == 'admin') {
      return redirect()->route('admin.obras')->with('success', 'Obra actualizada exitosamente.');
    } else {
      return redirect()->route('obras.index')->with('success', 'Obra actualizada exitosamente.');
    }
  }


  /**
   * Remove the specified resource from storage.
   */
  public function destroy(Request $request, Obra $obra)
  {

    if (Auth::user()->rol === 'admin') {
      $request->validate(
        [
          'motivo' => 'required|in:pedido_productor,decision_admin',
        ],
        [
          'motivo.required' => 'Debes seleccionar un motivo para proceder con la acción.',
          'motivo.in' => 'El motivo seleccionado no es válido.',
        ]
      );

      $motivo = $request->input('motivo');

      DB::transaction(function () use ($obra, $motivo) {
        if ($obra->puedeEliminarseDefinitivamente()) {
          if ($obra->imagen) {
            $imagePath = storage_path('app/public/imagenes/' . $obra->imagen);

            if (file_exists($imagePath)) {
              unlink($imagePath);
            }
          }
          $obra->delete();
        } else {
          $obra->eliminarLogicamente();
          $this->notificarUsuariosCompradores($obra);
        }

        $this->notificarProductorEliminacion($obra, $motivo);
      });
    } else {
      if ($obra->puedeEliminarseDefinitivamente()) {
        if ($obra->imagen) {
          $imagePath = storage_path('app/public/imagenes/' . $obra->imagen);

          if (file_exists($imagePath)) {
            unlink($imagePath);
          }
        }
        $obra->delete();
      }
    }


    if (Auth::user()->rol == 'admin') {
      return redirect()->route('admin.obras')->with('success', 'Obra eliminada exitosamente.');
    } else {
      return redirect()->route('obras.index')->with('success', 'Obra eliminada exitosamente.');
    }
  }


  private function notificarProductorEliminacion(Obra $obra, string $motivo)
  {
    $productor = $obra->productor;

    if ($productor) {
      Mail::to($productor->user->email)->send(
        new PlayDeletedMail($obra, $motivo)
      );
    }
  }

  private function notificarUsuariosCompradores(Obra $obra)
  {
    $usuarios = User::whereHas('tickets.ticketdetalles', function ($query) use ($obra) {
      $query->where('obra_id', $obra->id);
    })->distinct()->get();

    foreach ($usuarios as $usuario) {
      Mail::to($usuario->email)->send(
        new UserNotificationCancelledMail($obra, $usuario)
      );
    }
  }



  /**
   * Cancel the play
   */
  public function cancel(Request $request, Obra $obra)
  {
    $request->validate([
      'motivo' => 'required|in:pedido_productor,decision_admin',
    ]);

    $motivo = $request->motivo;

    DB::transaction(function () use ($obra, $motivo) {
      $obra->cancelar();

      //---Hacer reembolso
      $tickets = Ticket::with('ticketdetalles')
        ->whereHas('ticketdetalles', function ($query) use ($obra) {
          $query->where('obra_id', $obra->id);
        })->get();

      $refundController = app(RefundController::class);

      foreach ($tickets as $ticket) {
        try {
          $refundController->processRefundObra($ticket, $obra->id);
        } catch (\Exception $e) {
          report($e);
        }
      }
      // 

      $this->notificarUsuariosCompradoresCancelacion($obra);

      $this->notificarProductorCancelacion($obra, $motivo);
    });

    return back()->with(
      'success',
      'La obra fue cancelada correctamente.'
    );
  }

  private function notificarProductorCancelacion(Obra $obra, string $motivo)
  {
    $productor = $obra->productor;

    if ($productor) {
      Mail::to($productor->user->email)->send(
        new ProductorNotificationCancelledMail($obra, $motivo)
      );
    }
  }
  private function notificarUsuariosCompradoresCancelacion(Obra $obra)
  {
    $usuarios = User::whereHas('tickets.ticketdetalles', function ($query) use ($obra) {
      $query->where('obra_id', $obra->id);
    })->distinct()->get();

    foreach ($usuarios as $usuario) {
      Mail::to($usuario->email)->send(
        new UserNotificationCancelledMail($obra, $usuario)
      );
    }
  }
}
