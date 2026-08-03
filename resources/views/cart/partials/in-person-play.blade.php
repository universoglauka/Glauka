<div>
  <div class="d-flex align-items-center">
    <p class="fs-4 fw-bold text-start text-truncate">{{$item->obra->nombre_obra}}</p>

    <a href="{{ route('cart.eliminar', $item->id) }}" class="text-secondary rounded-pill ms-4" title="Eliminar entrada">
      <i class="bi bi-trash"></i>
    </a>
  </div>
  <div class="w-auto">
    <p class="text-muted">{{ \Carbon\Carbon::parse($item->performance->fechaObra)->format('d/m/Y') }} -
      {{ \Carbon\Carbon::parse($item->performance->horaObra)->format('H:i') }} hs
    </p>
    <div class="cantidad-precio mt-3">
      <div class="d-flex">
        <a href="{{ route('cart.restar', $item->id) }}" class="btn btn-secondary btn-quantity">-</a>

        <p class="card-text m-2">
          <span class="fw-semibold d-flex align-items-center">Cantidad: {{ $item->cantidad }} </span>
        </p>

        <a href="{{ route('cart.sumar', $item->id) }}" class="btn btn-primary btn-quantity btnYellow p-0">+</a>

      </div>
    </div>
  </div>
  <p class="fw-light mt-3">Subtotal: ${{ number_format($item->obra->precio * $item->cantidad, 2) }}</p>
  <p><small class="text-body-secondary pe-2">Precio unitario: ${{ number_format($item->obra->precio, 2) }}</small></p>

</div>