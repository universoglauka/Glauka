<?php

namespace App\Http\Controllers;

// use Illuminate\Foundation\Auth\User;

use App\Models\Label;
use App\Models\User;

use Illuminate\Http\Request;
use SebastianBergmann\CodeCoverage\Report\Html\Dashboard;

class UserController extends Controller
{
  public function index()
  {
    return view('perfil');
  }

  public function usuariosTodos()
  {
    $users = User::with(['tickets' => function ($query) {
      $query->orderBy('created_at', 'desc');
    }, 'tickets.ticketdetalles.obra'])->where('rol', 'user')->paginate(5);

    $labels = Label::withCount('users')->get();

    return view('admin.uss', compact('users', 'labels'));
  }
}
