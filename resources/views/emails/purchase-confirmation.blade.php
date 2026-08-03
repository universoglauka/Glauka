<h1 class="bg-warning">¡Gracias por tu compra!</h1>

<p>
  Se registró correctamente la compra de tus entradas.
</p>

<hr>

@foreach($ticket->ticketdetalles as $detalle)

<h2 class="fs-3">
  {{ $detalle->obra->nombre_obra }}
</h2>

<ul>
  <li>
    Función:
    {{ \Carbon\Carbon::parse(
                $detalle->performance->fechaObra
            )->format('d/m/Y') }}
    -
    {{ \Carbon\Carbon::parse(
                $detalle->performance->horaObra
            )->format('H:i') }} hs
  </li>

  <li>
    Cantidad:
    {{ $detalle->cantidad }}
  </li>

  @foreach($detalle->ticketEntries as $entry)
  <li>
    <strong>Entrada {{ $loop->iteration }}</strong>

    <ul>
      <li>
        Código:
        {{ $entry->codigo }}
      </li>

      @if($detalle->performance?->linkVirtual)
      <li>
        Email asignado:
        {{ $detalle->emails_virtuales[$loop->index] ?? 'No asignado' }}
      </li>
      @endif
    </ul>
  </li>
  @endforeach

  <li>
    Precio unitario:
    ${{ number_format(
                $detalle->precio_u, 2, ',', '.'
            ) }}
  </li>

  <li>
    Subtotal:
    ${{ number_format(
                $detalle->subtotal, 2, ',', '.'
            ) }}
  </li>
</ul>

<hr>

@endforeach

<h2>
  Total abonado:
  ${{ number_format(
    $ticket->total, 2, ',', '.'
) }}
</h2>