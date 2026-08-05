<?php

namespace App\Http\Controllers;

use App\Models\Performance;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\DB;
use App\Mail\ProductorNotificationCancelledPerformanceMail;
use App\Mail\UserNotificationCancelledPerformanceMail;
use App\Models\Ticket;
use Carbon\Carbon;


class PerformanceController extends Controller
{
  /**
   * Display a listing of the resource.
   */
  public function index()
  {
    //
  }

  public function cancel(Request $request, Performance $performance)
  {
    $request->validate([
      'motivo' => 'required|in:pedido_productor,decision_admin',
    ]);

    $motivo = $request->motivo;

    DB::transaction(function () use ($motivo, $performance, $request) {

      $performance->cancel();

      $performance->obra->actualizarEstadoCancelacion();
    });


    // ---- Hacer reembolso
    $tickets = Ticket::with('ticketdetalles')
      ->whereHas('ticketdetalles', function ($query) use ($performance) {
        $query->where('performance_id', $performance->id);
      })->get();

    $refundController = app(RefundController::class);

    foreach ($tickets as $ticket) {
      try {
        $refundController->processRefund($ticket, $performance->id);
      } catch (\Exception $e) {
         $e->getMessage();
      }
    }
    // 

    $this->notificarCompradoresCancelacionDeFuncion($performance);

    $this->notificarProductorCancelacionDeFuncion($performance, $motivo);

    return back()->with(
      'success',
      'La función fue cancelada.'
    );
  }


  private function notificarProductorCancelacionDeFuncion(Performance $performance, string $motivo)
  {
    $productor = $performance->obra->productor;

    if ($productor) {
      Mail::to($productor->user->email)->send(
        new ProductorNotificationCancelledPerformanceMail($performance, $motivo)
      );
    }
  }

  private function notificarCompradoresCancelacionDeFuncion(Performance $performance)
  {
    $fechaHora = Carbon::parse(
      $performance->fechaObra . ' ' . $performance->horaObra
    )->format('Y-m-d H:i:s');

    $usuarios = User::whereHas('tickets.ticketdetalles', function ($query) use ($performance, $fechaHora) {
      $query->where('obra_id', $performance->obra_id)
        ->where('fecha_hora_obra', $fechaHora);
    })->distinct()->get();

    foreach ($usuarios as $usuario) {
      Mail::to($usuario->email)->send(
        new UserNotificationCancelledPerformanceMail($performance, $usuario)
      );
    }
  }
}
