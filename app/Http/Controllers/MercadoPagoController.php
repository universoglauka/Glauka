<?php

namespace App\Http\Controllers;

use App\Models\Carts;
use App\Models\Plan;
use App\Models\Ticket;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use MercadoPago\Client\Payment\PaymentClient;
use MercadoPago\Client\Preference\PreferenceClient;
use MercadoPago\MercadoPagoConfig;

class MercadoPagoController extends Controller
{
  private function crearPreferencia(array $items, string $externalReference)
  {
    MercadoPagoConfig::setAccessToken(env('MERCADO_PAGO_ACCESS_TOKEN'));

    $client = new PreferenceClient();

    return $client->create([
      "items" => $items,
      "back_urls" => [
        "success" => route('pagos.success'),
        "failure" => route('pagos.failure'),
        "pending" => route('pagos.pending'),
      ],
      "auto_return" => "approved",
      "external_reference" => $externalReference,
      "notification_url" => route('webhook.mp'),
    ]);
  }

  public function checkout()
  {
    $user = Auth::user();

    $carrito = Carts::firstOrCreate(['user_id' => $user->id]);

    $carrito->load('items.obra', 'items.performance');

    if ($carrito->items->isEmpty()) {
      return redirect()->route('cart.index')->with('error', 'No se puede proseguir con el carrito vacío.');
    }

    $items = [];

    foreach ($carrito->items as $item) {
      $items[] = [
        'title' => $item->obra->nombre_obra,
        'quantity' => (int)$item->cantidad,
        'unit_price' => (float)$item->obra->precio,
        'currency_id' => "ARS"
      ];
    }

    try {
      $preference = $this->crearPreferencia(
        $items,
        "cart_" . $carrito->id
      );
    } catch (\Throwable $e) {
      dd([
        'message' => $e->getMessage(),
        'file' => $e->getFile(),
        'line' => $e->getLine(),
      ]);
    }

    return view(
      'checkout.preference',
      [
        'carrito' => $carrito,
        'preference' => $preference,
        'tipo'      => 'ticket'
      ]
    );
  }

  public function checkoutPremium()
  {
    $user = Auth::user();

    if ($user->rol == "producer") {
      $plan = Plan::where(
        'nombre',
        'Premium producer'
      )->firstOrfail();

      $items = [[
        'title' => 'Plan premium productor',
        'quantity' => 1,
        'unit_price' => (float) $plan->precio,
        'currency_id' => "ARS"
      ]];
    } else {
      $plan = Plan::where(
        'nombre',
        'Premium user'
      )->firstOrfail();

      $items = [[
        'title' => 'Plan premium usuario',
        'quantity' => 1,
        'unit_price' => (float) $plan->precio,
        'currency_id' => "ARS"
      ]];
    }

    try {
      $preference = $this->crearPreferencia(
        $items,
        "premium_" . $user->id
      );
    } catch (\MercadoPago\Exceptions\MPApiException $e) {
      dd([
        'message' => $e->getMessage(),
        'status'  => $e->getApiResponse()->getStatusCode(),
        'content' => $e->getApiResponse()->getContent(),
      ]);
    }

    return view(
      'checkout.preference',
      [
        'plan'       => $plan,
        'preference' => $preference,
        'tipo'      => 'premium'
      ]
    );
  }

  public function success(Request $request)
  {
    // dd($request->all());
    $paymentId = $request->payment_id;

    return  redirect()->route('home')->with('success', 'Gracias por su compra. Enviaremos el detalle por email.');

  }

  public function pending()
  {
    return view('profile.index')->with('pending', 'Su pago esta pendiente.');
  }

  public function failure()
  {
    return view('profile.index')->with('failure', 'Lo sentimos, parece que algo salio mal. Vuelva a intentar en un momento.');
  }

  public function webhook(Request $request)
  {
    dd($request->all());
      $paymentId = $request->input('data.id');

    if (!$paymentId) {
      return response()->json([
        'ok' => false
      ]);
    }

    MercadoPagoConfig::setAccessToken(env('MERCADO_PAGO_ACCESS_TOKEN'));

    $paymentClient = new PaymentClient();
    $payment = $paymentClient->get($paymentId);

    if ($payment->status !== 'approved') {
      return response()->json([
        'ignored' => true
      ]);
    }

    $externalReference = $payment->external_reference;

    if (str_starts_with($externalReference, 'cart_')) {

      $cartId = str_replace(
        'cart_',
        '',
        $externalReference
      );

      app(TicketController::class)->procesarCompraDesdeWebhook($cartId, $payment->id);
    }

    if (str_starts_with($externalReference, 'premium_')) {
      $userId = str_replace('premium_', '', $externalReference);

      app(SubscriptionController::class)->activarPremium($userId, $payment->id);
    }

    return response()->json([
      'success' => true
    ]);
  }
}
