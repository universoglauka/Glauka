<?php

namespace App\Http\Controllers;

use App\Models\Announcement;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AnnouncementController extends Controller
{
  /**
   * Display a listing of the resource.
   */
  public function index()
  {
    $announcements = Announcement::with('productor.user')
      ->where(
        'expires_at',
        '>',
        now()
      )
      ->latest()
      ->paginate(10);

    return view(
      'announcements.index',
      compact('announcements')
    );
  }

  /**
   * Show the form for creating a new resource.
   */
  public function create()
  {
    return view('announcements.create');
  }

  /**
   * Store a newly created resource in storage.
   */
  public function store(Request $request)
  {
    $request->validate(Announcement::rules(), Announcement::messagesRules);

    Announcement::create([
      'productor_id' => Auth::user()->productor->id,
      'title' => $request->title,
      'content' => $request->content,

      'expires_at' => $request->expires_at
        ?? now()->addDays(30),
    ]);
    return redirect()
      ->route('announcements.index')
      ->with(
        'success',
        'Publicación creada correctamente.'
      );
  }

  /**
   * Display the specified resource.
   */
  public function show(Announcement $announcement)
  {
    return view(
      'announcements.show',
      compact('announcement')
    );
  }

  /**
   * Show the form for editing the specified resource.
   */
  public function edit(Announcement $announcement)
  {
    return view(
      'announcements.edit',
      compact('announcement')
    );
  }

  /**
   * Update the specified resource in storage.
   */
  public function update(Request $request, Announcement $announcement)
  {
    $camposValidados = $request->validate(Announcement::rules(), Announcement::messagesRules);

    $announcement->update($camposValidados);

    return redirect()->back()->with('success', 'Publicación actualizada exitosamente.');
  }

  /**
   * Remove the specified resource from storage.
   */
  public function destroy(Announcement $announcement)
  {
    $announcement->delete();

    return redirect()
      ->back()
      ->with(
        'success',
        'Anuncio eliminado correctamente.'
      );
  }
}
