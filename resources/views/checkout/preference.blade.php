@extends('layouts.app')
@section('title', 'Preferencia')
@section('content')
<script src="https://sdk.mercadopago.com/js/v2"></script>
<div class="espacio">

  <h1 class="fs-1 mb-2 text-center mt-2"> Resumen de compra </h1>

  <div class="preference">

    <div class="m-5">

      @if($tipo == 'ticket')

      @include('checkout.partials.ticket-obra')

      @elseif($tipo == 'premium')

      @include('checkout.partials.subscripcion')

      @endif

    </div>

    <div class="d-flex justify-content-center fs-5 fw-bold bg-amarillo p-2">
      @if($tipo == 'ticket')
      <span>Total:</span>
      <p class="text-success ps-2">${{ number_format($carrito->items->sum(fn($i) => $i->obra->precio * $i->cantidad), 2) }}</p>
      @else
      <span>Total:</span>
      <p class="text-success ps-2"> ${{ number_format($plan->precio, 2) }} </p>
      @endif
    </div>



    <div class=" d-flex flex-wrap flex-md-row row-gap-4 justify-content-evenly  mt-5 mb-5">
      <div id="wallet_container" class=""></div>
      <button disabled="disabled" class="btn btn-primary fw-bold">Tarjeta</button>
    </div>


  </div>
</div>
<script>
  console.log("Preference ID:", "{{$preference->id}}");

  document.addEventListener('DOMContentLoaded', function() {
    const mp = new MercadoPago("{{ env('MERCADO_PAGO_PUBLIC_KEY') }}", {
      locale: "es-AR"
    });


    mp.checkout({
      preference: {
        id: "{{$preference->id}}"
      },
      render: {
        container: "#wallet_container",
        label: "Pagar con Mercado Pago"
      }
    });
  });
</script>
@endsection