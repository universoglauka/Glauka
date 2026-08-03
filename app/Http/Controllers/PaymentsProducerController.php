<?php

namespace App\Http\Controllers;

use App\Models\Performance;
use Illuminate\Http\Request;

class PaymentsProducerController extends Controller
{
    public function index()
    {

        $performances = Performance::with([
            'obra.productor.user',
            'ticketdetalles'
        ])->where('visible_admin', true)
            ->orderBy('fechaObra')
            ->paginate(10);

        return view('admin.producer-payment', compact('performances'));
    }


    public function changeStatus(Performance $performance)
    {
        if ($performance->estado_pago == 'pendiente') {
            $performance->estado_pago = 'realizado';
        } else {
            $performance->estado_pago = 'pendiente';
        }

        $performance->save();

        return back();
    }

    public function hide(Performance $performance)
    {
        $performance->visible_admin = false;
        $performance->save();
        return back();
    }
}
