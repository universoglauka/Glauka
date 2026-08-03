<?php

namespace App\Http\Controllers;

use App\Models\Obra;
use App\Models\Plan;
use App\Models\Productor;
use Illuminate\Http\Request;

class ProductorController extends Controller
{
  public function index()
  {
    return view('home');
  }

  public function show(Obra $obra)
  {
    $obra->load(['performance', 'ticketdetalles.ticket']);
    return view('productor.obras.show', compact('obra'));
  }

  public function productoresTodos()
  {
    $users = Productor::with(['user.plan', 'obras',])->whereRelation('user', 'rol', 'producer')->get();
    return view('admin.productor', compact('users'));
  }
}
