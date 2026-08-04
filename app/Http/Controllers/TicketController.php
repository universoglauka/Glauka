<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Carbon\Carbon;
use App\Models\Carts;
use App\Models\Performance;
use App\Models\Ticket;
use App\Models\TicketDetalle;
use App\Models\TicketEntry;
use App\Models\ProductorStatistic;
use App\Models\CartItems;
use App\Models\User;
use App\Mail\CartStockWarningMail;
use App\Mail\PurchaseConfirmationMail;

use Illuminate\Support\Facades\Mail;

class TicketController extends Controller
{
  /**
   * Procesa la compra, guarda el Ticket/Detalle y resta el stock específico.
   */

  public function procesarCompraDesdeWebhook(int $cartId, string $paymentId)
  {
    // Evitar duplicado
    if (Ticket::where('payment_id', $paymentId)->exists()) {
      return;
    }

    DB::beginTransaction();
    try {
      // $cartId = $payment->external_reference;

      $carrito = Carts::with([
        'items.obra',
        'items.performance',
        'user'
      ])->findOrFail($cartId);

      $user = $carrito->user;

      // paso a mercado pago
      $ticket = Ticket::create([
        'user_id' => $carrito->user_id,
        'payment_id' => $paymentId,
        'total' => $carrito->items->sum(fn($item) => $item->obra->precio * $item->cantidad),
        'estado_pago' => 'aprobado',

        'datos_usuario' => [
          'nombre'    => $user->name,
          'nickname'  => $user->nicknameUser,
          'email'     => $user->email,
        ]
      ]);

      foreach ($carrito->items as $item) {

        $performance = Performance::lockForUpdate()->findOrFail($item->performance_id);

        if ($performance->stock < $item->cantidad) {
          throw new \Exception("Stock insuficiente para {$item->obra->nombre_obra}");
        }

        $fechaHora = Carbon::parse($item->performance->fechaObra)->setTimeFromTimeString($item->performance->horaObra);

        $ticketDetalle =  TicketDetalle::create([
          'ticket_id'         => $ticket->id,
          'obra_id'           => $item->obra_id,
          'performance_id'    => $item->performance_id,
          'nombre_obra'       => $item->obra->nombre_obra,
          'es_virtual' => !empty($item->performance->linkVirtual),
          'nombre_productor'  => $item->obra->productor->user->name,
          'fecha_hora_obra'   => $fechaHora,
          'cantidad'          => $item->cantidad,
          'emails_virtuales'  => $item->emails_virtuales,
          'codigo'            => Str::upper(Str::random(10)),
          'precio_u'          => $item->obra->precio,
          'subtotal'          => $item->obra->precio * $item->cantidad,
        ]);

        for ($i = 1; $i <= $item->cantidad; $i++) {
          TicketEntry::create([
            'ticketdetalles_id' => $ticketDetalle->id,
            'codigo' => $ticketDetalle->codigo . '-' . $i,
          ]);
        }

        $performance->decrement('stock', $item->cantidad);
        $performance->refresh();

        $this->verificarStockCritico(
          $performance,
          $user->id
        );

        $this->actualizarEstadisticasProductor($item);
      }
      DB::commit();

      $this->enviarConfirmacionCompra(
        $ticket,
        $user
      );

      $carrito->items()->delete();
    } catch (\Exception $e) {
      DB::rollBack();
      throw $e;
    }
  }

  /**
   * Envía un mail con la confirmación de compra del usuario.
   */
  private function enviarConfirmacionCompra(
    Ticket $ticket,
    User $user
  ) {
    $ticket->load(
      'ticketdetalles.obra',
      'ticketdetalles.performance',
      'ticketdetalles.ticketEntries'
    );

    Mail::to($user->email)
      ->send(
        new PurchaseConfirmationMail(
          $ticket
        )
      );
  }

  /**
   * Verifica el stock actual y avisa a los usuarios con la entrada en el carrito que las
   * entradas se están acabando. 
   */
  private function verificarStockCritico(Performance $performance, int $compradorId)
  {
    $cartItems = CartItems::where(
      'performance_id',
      $performance->id
    )
      ->whereHas('cart', function ($query) use ($compradorId) {
        $query->where(
          'user_id',
          '!=',
          $compradorId
        );
      })
      ->get();

    foreach ($cartItems as $cartItem) {
      if (
        $performance->stock <= ($cartItem->cantidad + 1)
        && !$cartItem->stock_alert_sent
      ) {
        Mail::to(
          $cartItem->cart->user->email
        )->send(
          new CartStockWarningMail(
            $cartItem,
            $performance
          )
        );

        $cartItem->update([
          'stock_alert_sent' => true
        ]);
      }
    }
  }

  /**
   * Al realizar la compra, se actualiza automaticamente las estadísticas del productor dueño de la/s obra/s.
   */
  private function actualizarEstadisticasProductor($item)
  {
    $productorUserId =
      $item->obra->productor->user_id;

    $stat = ProductorStatistic::firstOrCreate(
      [
        'user_id' => $productorUserId,
        'year' => now()->year,
        'month' => now()->month,
      ],
      [
        'total_revenue' => 0,
        'total_tickets' => 0,
      ]
    );

    $stat->increment(
      'total_revenue',
      $item->obra->precio * $item->cantidad
    );

    $stat->increment(
      'total_tickets',
      $item->cantidad
    );
  }
}
