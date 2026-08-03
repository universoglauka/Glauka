<div class="card h-auto shadow-sm border-0">
  <div class="resumenCompra card-header  d-flex justify-content-center align-items-center">
    <img src="{{asset('storage/imagenes/logoGlaukaSinFondo.png')}}" alt="logo de Glauka" class="me-2">
    <h2 class="d-none">Mis tickets</h2>
  </div>

  <div class="carritoResumen card-body p-4">

    @forelse ($carrito->items as $item)
    <div class="card p-3 mb-3">
      <div class="row">
        <div class="col-12 col-md-12 col-lg-5 mb-2">
          @if($item->obra->imagen)
          <img src="{{ asset('storage/imagenes/' . $item->obra->imagen) }}"
            alt="{{ $item->obra->nombre_obra }}"
            class="card-img-top rounded-3">
          @else
          <img src="{{ asset('storage/imagenes/default/obraDefaultImg.jpg') }}"
            alt="{{ $item->obra->nombre_obra }}"
            class="card-img-top rounded-3">
          @endif
        </div>

        <div class="col-12 col-md-8 col-lg-7">
          <h3 class="fs-5 mb-2">{{ $item->obra->nombre_obra }}</h3>

          <div class="detalles-compra">
            <p class="mb-1">
              <strong>Fecha y hora:</strong>
              {{ \Carbon\Carbon::parse($item->performance->fechaObra)->format('d/m/Y') }} -
              {{ \Carbon\Carbon::parse($item->performance->horaObra)->format('H:i') }} hs
            </p>

            <p class="mb-1">
              <strong>Cantidad:</strong> {{ $item->cantidad }}
            </p>


            <p class="mb-1">
              <strong>Tipo:</strong>
              <span class="fs-6 d-inline ms-2">
                @if($item->performance->linkVirtual)
                <ins>Virtual</ins>
                @else
                <ins>Presencial</ins>
                @endif
              </span>
            </p>

            <p class="mb-1">
              <strong>Precio unitario:</strong> ${{ number_format($item->obra->precio, 2) }}
            </p>

            <p class="mb-0">
              <strong>Subtotal:</strong> ${{ number_format($item->obra->precio * $item->cantidad, 2) }}
            </p>

          </div>
        </div>
      </div>
    </div>
    @empty
    <div class="alert alert-info text-center">
      <p class="mb-0">No hay productos en el carrito</p>
    </div>
    @endforelse
  </div>
  <div class="card-footer resumenCompra">
  </div>
</div>