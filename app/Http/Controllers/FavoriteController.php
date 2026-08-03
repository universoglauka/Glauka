<?php

namespace App\Http\Controllers;

use App\Models\Obra;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class FavoriteController extends Controller
{
     public function toggle(Obra $obra)
    {
         /** @var \App\Models\User $user */
        $user = Auth::user();

        $user->favorites()->toggle($obra->id);
        return back()->with('success', 'Se agrego a favoritos');
    }
}
