<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProducerUpdateRequest;
use App\Http\Requests\ProfileUpdateRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;
use App\Models\User;
use App\Models\Ticket;
use App\Models\TicketDetalle;
use App\Models\Label;
use App\Models\Genre;
use Illuminate\Support\Facades\Storage;

class ProfileController extends Controller
{
  public function index()
  {
    $user = User::findOrFail(Auth::id());

    return view('profile.index', $this->getProfileData($user));
  }

  /**
   * Mostrar el formulario para editar el perfil
   */
  public function edit(Request $request): View
  {
    return view('profile.edit', [
      'user' => $request->user(),
      'labels' => Label::all(),
      'genres' => Genre::all(),
    ]);
  }
  /**
   * Ver editar perfil desde admin.
   */
  public function editByAdmin(User $user): View
  {
    return view('profile.edit', [
      'user' => $user,
      'labels' => Label::all(),
      'genres' => Genre::all(),
    ]);
  }

  /**
   * Actualizar perfil
   */
  public function update(ProfileUpdateRequest $request): RedirectResponse
  {
    $user = $request->user();

    $validatedFields = $request->validated();

    if ($request->hasFile('userIcon')) {

      if ($user->userIcon) {
        Storage::disk('public')->delete('imagenes/userIcon/' . $user->userIcon);
      }

      $path = $request->file('userIcon')->store('imagenes/userIcon', 'public');

      $validatedFields['userIcon'] = basename($path);
    }

    $user->fill($validatedFields);

    if ($user->isDirty('email')) {
      $user->email_verified_at = null;
    }

    $user->save();

    $user->labels()->sync(
      $request->input('labels', [])
    );

    return Redirect::route('profile')->with('status', 'profile-updated')->with('success', 'Actualización exitosa.');
  }


  /**
   * Actualizar perfil del productor.
   */
  public function updateProducer(ProducerUpdateRequest $request): RedirectResponse
  {
    $user = $request->user();

    if ($user->rol == 'producer') {
      $user->productor()->updateOrCreate(
        ['user_id' => $user->id],
        $request->validated()
      );
    }

    return Redirect::route('profile.edit')->with('status', 'profile-updated')->with('success', 'Actualización de datos de productor exitosa.');
  }

  /**
   * Actualizar perfil de usuario desde admin.
   */
  public function updateByAdmin(ProfileUpdateRequest $request, User $user): RedirectResponse
  {
    $validatedFields = $request->validated();

    if ($request->hasFile('userIcon')) {
      if ($user->userIcon) {
        Storage::disk('public')->delete('imagenes/userIcon/' . $user->userIcon);
      }
      $path = $request->file('userIcon')->store('imagenes/userIcon/', 'public');
      $validatedFields['userIcon'] = basename($path);
    }

    $user->fill($validatedFields);

    if ($user->isDirty('email')) {
      $user->email_verified_at = null;
    }

    $user->save();

    $user->labels()->sync(
      $request->input('labels', [])
    );

    return Redirect::route('admin.profile.edit', $user)->with('status', 'profile-updated')->with('success', 'Actualización exitosa.');
  }

  /**
   * Actualizar perfil de usuario parte de productor desde admin.
   */
  public function updateProducerByAdmin(ProducerUpdateRequest $request, User $user): RedirectResponse
  {
    $user->fill($request->validated());

    if ($user->rol == 'producer') {
      $user->productor()->updateOrCreate(
        ['user_id' => $user->id],
        $request->validated()
      );
    }

    return Redirect::route('admin.profile.edit', $user)->with('status', 'profile-updated')->with('success', 'Actualización de datos de productor exitosa.');
  }



  /**
   * Mostrar el perfil del usuario y sus datos
   */
  public function show(User $user)
  {
    return view('profile.index', $this->getProfileData($user));
  }

  /**
   * Obtener y preparar los datos del perfil según el rol del usuario.
   */
  private function getProfileData(User $user)
  {
    $user->load([
      'labels',
      'productor',
      'tickets' => function ($query) {
        $query->orderBy('created_at', 'desc');
      },
      'tickets.ticketdetalles.obra'
    ]);

    $entradasActivas = collect();
    $favoritos = collect();

    if ($user->rol === 'user') {
      $entradasActivas = Ticket::where('user_id', $user->id)
        ->whereHas('ticketdetalles.obra.performance', function ($query) {
          $query->where('fechaObra', '>=', now()->toDateString());
        })
        ->with('ticketdetalles.obra.performance')
        ->orderBy('created_at', 'desc')
        ->get();

      $favoritos = $user
        ->favorites()
        ->with(['performance', 'productor.user'])
        ->get();
    }



    $obrasActivas = collect();
    $obrasPasadas = collect();
    $announcements = collect();

    if ($user->rol === 'producer' && $user->productor) {
      $obrasActivas = $user->productor
        ->obras()
        ->whereHas('performance', function ($query) {
          $query->where('fechaObra', '>=', now()->toDateString());
        })
        ->with('performance')
        ->get();

      $obrasPasadas = $user->productor
        ->obras()
        ->whereDoesntHave('performance', function ($query) {
          $query->where('fechaObra', '>=', now()->toDateString());
        })
        ->with('performance')
        ->get();

      $announcements = $user->productor
        ->announcements()
        ->where('expires_at', '>', now())
        ->latest()
        ->get();
    }

    return [
      'user' => $user,
      'entradasActivas' => $entradasActivas,
      'favoritos' => $favoritos,
      'obrasActivas' => $obrasActivas,
      'obrasPasadas' => $obrasPasadas,
      'announcements' => $announcements,
      'isUserProfile' => $user->rol === 'user',
      'isProducerProfile' => $user->rol === 'producer' && $user->productor,
    ];
  }




  /**
   * Eliminar cuenta de usuario.
   */
  public function destroy(Request $request): RedirectResponse
  {
    $request->validateWithBag('userDeletion', [
      'password' => ['required', 'current_password'],
    ]);

    $user = $request->user();

    if ($user->userIcon) {
      Storage::disk('public')->delete('imagenes/userIcon/' . $user->userIcon);
    }
    Auth::logout();

    $user->delete();

    $request->session()->invalidate();
    $request->session()->regenerateToken();

    return Redirect::to('/');
  }


  /**
   * Eliminar cuenta de usuario desde admin
   */
  public function destroyByAdmin(User $user)
  {
    if (Auth::id() === $user->id) {
      return back()->with('error', 'No puedes eliminarte a ti mismo.');
    }

    if ($user->userIcon) {
      Storage::disk('public')->delete('imagenes/userIcon/' . $user->userIcon);
    }

    $user->delete();

    return redirect()->route('admin.usuarios')->with('success', 'Usuario eliminado con éxito.');
  }
}
