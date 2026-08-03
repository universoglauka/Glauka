<div class="producto-carrito card bg-cancelado rounded mb-3 d-flex">
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

    @if($item->performance && $item->performance->linkVirtual)
    <div class="col-12 col-md-12 col-lg-6 py-3">
      <div>
        <div class="d-flex align-items-center">
          <p class="fs-4 fw-bold text-start text-truncate">{{$item->obra->nombre_obra}}</p>

          <a href="{{ route('cart.eliminar', $item->id) }}" class="text-secondary rounded-pill ms-4" title="Eliminar entrada">
            <i class="bi bi-trash"></i>
          </a>
        </div>
        <div class="w-auto">
          @if($item->performance->cancelado)
          <p class="text-danger text-decoration-line-through">
            {{ \Carbon\Carbon::parse($item->performance->fechaObra)->format('d/m/Y') }} -
            {{ \Carbon\Carbon::parse($item->performance->horaObra)->format('H:i') }} hs
          </p>
          @else
          <p class="text-muted">{{ \Carbon\Carbon::parse($item->performance->fechaObra)->format('d/m/Y') }} -
            {{ \Carbon\Carbon::parse($item->performance->horaObra)->format('H:i') }} hs
          </p>
          @endif

          <div class="cantidad-precio mt-2">
            <div class="d-flex justify-content-between align-items-center">

              <p class="card-text">
                <span class="fw-semibold d-flex align-items-center">Cantidad: {{ $item->cantidad }} </span>
              </p>

              <div class="dropdown">
                <button class="dropdown-toggle text-body-secondary" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                  Ver emails
                </button>
                <ul class="dropdown-menu">
                  @foreach ($item->emails_virtuales as $email)
                  <li class="p-2">{{ $email }}</li>
                  @endforeach
                </ul>
              </div>
            </div>
          </div>
        </div>

        <p class="fw-light mt-1">Subtotal: ${{ number_format($item->obra->precio * $item->cantidad, 2) }}</p>
        <p><small class="text-body-secondary pe-2">Precio unitario: ${{ number_format($item->obra->precio, 2) }}</small></p>
      </div>
    </div>
    @else
    <div class="col-12 col-md-12 col-lg-6 py-3">
      <div>
        <div class="d-flex align-items-center">
          <p class="fs-4 fw-bold text-start text-truncate">{{$item->obra->nombre_obra}}</p>

          <a href="{{ route('cart.eliminar', $item->id) }}" class="text-secondary rounded-pill ms-4" title="Eliminar entrada">
            <i class="bi bi-trash"></i>
          </a>
        </div>
        <div class="w-auto">
          @if($item->performance->cancelado)
          <p class="text-danger text-decoration-line-through">
            {{ \Carbon\Carbon::parse($item->performance->fechaObra)->format('d/m/Y') }} -
            {{ \Carbon\Carbon::parse($item->performance->horaObra)->format('H:i') }} hs
          </p>
          @else
          <p class="text-muted">{{ \Carbon\Carbon::parse($item->performance->fechaObra)->format('d/m/Y') }} -
            {{ \Carbon\Carbon::parse($item->performance->horaObra)->format('H:i') }} hs
          </p>
          @endif
          <div class="cantidad-precio mt-3">
            <div class="d-flex">
              <button class="btn btn-secondary btn-quantity" disabled>-</button>

              <p class="card-text m-2">
                <span class="fw-semibold d-flex align-items-center">Cantidad: {{ $item->cantidad }} </span>
              </p>

              <button class="btn btn-primary btn-quantity btnYellow p-0" disabled>+</button>

            </div>
          </div>
        </div>
        <p class="fw-light mt-3">Subtotal: ${{ number_format($item->obra->precio * $item->cantidad, 2) }}</p>
        <p><small class="text-body-secondary pe-2">Precio unitario: ${{ number_format($item->obra->precio, 2) }}</small></p>

      </div>
    </div>
    @endif
  </div>
</div>