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
  <a href="{{ route('obras.show', [$item->obra,'cartItem' => $item->id]) }}" class="btn btn-secondary btn-sm mt-2">Editar entradas</a>
</div>