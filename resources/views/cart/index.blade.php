@extends('layouts.app')
@section('title', 'Carrito')
@section('content')

@if (session('success'))
<script>
  document.addEventListener('DOMContentLoaded', function() {
    Swal.fire({
      title: "Éxito",
      text: "{{session('success')}}",
      icon: "success",
      draggable: true
    });
  })
</script>
@elseif(session('failure'))
<script>
  document.addEventListener('DOMContentLoaded', function() {
    Swal.fire({
      title: "Oops.. ",
      text: "{{session('success')}}",
      icon: "error",
      draggable: true
    });
  })
</script>
@elseif(session('pending'))
<script>
  document.addEventListener('DOMContentLoaded', function() {
    Swal.fire({
      title: "Pendiente",
      text: "{{session('pending')}}",
      draggable: true
    });
  })
</script>
@endif


<div class="espacio">
  <h1 class="d-none">Mi carrito</h1>
  <div class="row">
    <div class="col-12 col-sm-12 col-md-7">
      @if($carrito->items->isEmpty())
      <div class="alert alert-warning text-center py-5 rounded-4" role="alert">
        <i class="bi bi-cart-x display-1 mb-3 d-block"></i>
        <p class="fs-3 alert-heading">¡Tu carrito está vacío!</p>
        <p>Parece que aún no has agregado productos.</p>
        <a href="{{ route('catalog') }}" class="btn btn-primary mt-4">Ir al catálogo</a>
      </div>
      @endif

      @foreach ($carrito->items as $item)

      @if($item->performance->cancelado)
      @include('cart.partials.cancelled-play')


      @else
      <div class="producto-carrito card rounded mb-3 d-flex">
        <div class="row">
          <div class="col-12 col-md-12 col-lg-6 p-2">
            @if($item->obra->imagen)
            <img src="{{ asset('storage/imagenes/' . $item->obra->imagen) }}" class="card-img-top rounded-1"
              alt="{{$item->obra->nombre_obra}}">
            @else
            <img src="{{ asset('storage/imagenes/default/obraDefaultImg.jpg') }}" class="card-img-top rounded-1"
              alt="{{$item->obra->nombre_obra}}">
            @endif
          </div>
          <div class="col-12 col-md-12 col-lg-6 py-3">
            @if($item->performance && $item->performance->linkVirtual)
            @include('cart.partials.virtual-play')

            @else
            @include('cart.partials.in-person-play')

            @endif
          </div>
        </div>
      </div>
      @endif
      @endforeach
    </div>

    <div class="col-12 col-sm-12 col-md-5">
      <div class="card h-auto shadow-sm border-0">
        <div class="resumenCompra card-header">
          <h2 class="fs-6 mb-0 text-center">
            <i class="bi bi-cart-check me-2"></i>Resumen de compra
          </h2>
        </div>

        <div class="card-body p-4">
          <div class="row text-center mb-4">
            <div class="col-6">
              <div class="border-end">
                <p class="cuentaCarrito mb-1">{{ $carrito->items->count() }}</p>
                <small class="text-muted">Obras</small>
              </div>
            </div>
            <div class="col-6">
              <div>
                <p class="cuentaCarrito mb-1">{{ $carrito->items->sum('cantidad') }}</p>
                <small class="text-muted">Total entradas</small>
              </div>
            </div>
          </div>

          <div class="mb-4">
            <div class="d-flex justify-content-between mb-2">
              <span class="text-muted">Subtotal:</span>
              <span>${{ number_format($carrito->items->sum(fn($i) => $i->obra->precio * $i->cantidad), 2) }}</span>
            </div>


            <hr class="my-3">

            <div class="d-flex justify-content-between fs-5 fw-bold">
              <span>Total:</span>
              <span class="text-success">${{ number_format($carrito->items->sum(fn($i) => $i->obra->precio * $i->cantidad), 2) }}</span>
            </div>
          </div>

          <div class="botones-accion">
            @if($carrito->items->contains(fn($item) => $item->performance && $item->performance->cancelado))
            <div class="alert alert-warning border-0">
              <div class="d-flex">
                <i class="bi bi-info-circle me-2 mt-1"></i>
                <div>
                  <small class="d-block">
                    <strong>Tienes tickets de funciones canceladas</strong>
                  </small>
                  <small class="d-block mt-1">
                    Eliminalas del carrito para poder continuar
                  </small>
                </div>
              </div>
            </div>
            <button class="btn btn-primary btn-lg w-100 py-3 fw-bold mb-3"
              disabled>
              Continuar
            </button>

            <div class="d-flex gap-2">
              <a href="{{ route('home') }}" class="btn btn-outline-primary flex-fill">
                Seguir comprando
              </a>
              <a href="{{ route('cart.vaciar') }}" class="btn btn-outline-danger"
                onclick="return confirm('¿Estás seguro de que quieres vaciar el carrito?')">
                <i class="bi bi-trash me-2"></i>Vaciar
              </a>
            </div>



            @else
            <form action="{{ route('checkout') }}" method="GET" class="mb-3">
              @csrf
              <button type="submit" id="comprar" class="btn btn-primary btn-lg w-100 py-3 fw-bold"
                @if($carrito->items->isEmpty()) disabled @endif>
                Continuar
              </button>
            </form>

            @if($carrito->items->isNotEmpty())
            <div class="d-flex gap-2">
              <a href="{{ route('home') }}" class="btn btn-outline-primary flex-fill">
                Seguir comprando
              </a>

              <a href="{{ route('cart.vaciar') }}" class="btn btn-outline-danger"
                onclick="return confirm('¿Estás seguro de que quieres vaciar el carrito?')">
                <i class="bi bi-trash me-2"></i>Vaciar
              </a>
            </div>
            @endif

            @endif
          </div>
        </div>

        <div class="resumenCompra card-footer">
          <div class="d-flex justify-center text-center">
            <i class="bi bi-shield-check text-success d-block me-1"></i>
            <small class="text-muted d-flex align-items-center">Pago seguro</small>

          </div>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection