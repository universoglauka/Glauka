@php
$tieneVirtual = $obra->performance->whereNotNull('linkVirtual')->isNotEmpty();
$tienePresencial = $obra->performance->whereNull('linkVirtual')->isNotEmpty();
@endphp

<section class="espacio">
  <div class="d-flex align-items-center mb-4 ml-2">
    <div class="d-flex justify-content-between align-items-center" style="height: 4rem;">
      <div class="d-flex align-items-center">
        <div class="d-none d-sm-flex">
          <a href="{{ url()->previous() }}" class="volverBtn text-decoration-none">
            <i class="bi bi-arrow-left-circle-fill fs-2"></i>
          </a>
        </div>
      </div>
    </div>
  </div>
  <div class="row">
    <div class="col-12 col-md-12 col-lg-6 mb-4">
      <div class="tarjeta p-4 rounded-3 mb-4">

        <div class="mb-2">
          @if($obra->imagen)
          <img src="{{asset('storage/imagenes/' . $obra->imagen) }}" alt="{{$obra->nombre_obra}}" class="imgPrincipalObra img-fluid rounded-1">
          @else
          <img src="{{ asset('storage/imagenes/default/obraDefaultImg.jpg') }}" class="imgPrincipalObra img-fluid rounded-1" alt="{{ $obra->nombre_obra }}">
          @endif
        </div>
        <div class="row p-0">
          <div class="col-10 p-0 text-break mt-2">
            <h1 class="fs-2">{{$obra->nombre_obra}}</h1>
          </div>

          <div class="like col-2 p-0">

            <form action="{{ route('favorite.toggle', $obra) }}" method="POST">
              @csrf
              <button class=" p-0 border-0" type="submit">
                @if(auth()->user()->favorites->contains($obra->id))
                <i id="heart-icon" class="mt-3 bi bi-suit-heart-fill"></i>
                @else
                <i id="heart-icon" class="mt-3 bi bi-suit-heart"></i>
                @endif
              </button>
            </form>
          </div>
        </div>

        <span class="produccionPor text-muted">Producción de {{$obra->productor->name_group}}</span>

        <div class="mt-4 mb-2">
          <h2 class="fs-4 d-none">Información de la obra</h2>
          <div class="row">
            <div class="col-12 col-md-12 col-lg-6 p-0">
              <div class="mb-4">
                <h3 class="fw-medium fs-6 mb-2">Clasificación:</h3>
                <p class="text-small badge rounded-pill text-bg-danger">{{$obra->clasificacion ?? 'No especificada'}}</p>
              </div>
            </div>

            <div class="col-12 col-md-12 col-lg-6 p-0">
              <div class="mb-4">
                <h3 class="fw-medium fs-6 mb-2">Adaptaciones:</h3>
                @if($obra->adaptations->isNotEmpty())
                @foreach($obra->adaptations as $adaptacion)
                <p class="text-small badge rounded-pill 
                @switch($adaptacion->id)
                @case(1)
                    adaptation-auditiva
                    @break

                @case(2)
                    adaptation-movil
                    @break

                @case(3)
                    adaptation-visual
                    @break

                @default
                    text-bg-secondary
                @endswitch">
                  {{$adaptacion->name}}
                </p>
                @endforeach
                @else
                <p class="text-small badge rounded-pill text-bg-secondary">No especificado</p>
                @endif
              </div>
            </div>
          </div>

          <div class="mb-4">
            <h3 class="fw-medium fs-6 mb-2">Género/s:</h3>
            @forelse($obra->genres as $genero)
            <p class="text-small badge rounded-pill text-bg-warning me-1 mb-1">
              {{ $genero->name }}
            </p>
            @empty
            <p class="text-small text-muted">No especificado</p>
            @endforelse
          </div>
          <div class="mb-1">
            <h2 class="fs-4 mt-4">Sinopsis</h2>
            <p class="py-3 text-break">{{$obra->sinopsis}}
            </p>
            @if($obra->autor)
            <h3 class="produccionPor fs-6 mb-4 text-muted">Autor: {{$obra->autor}}</h3>
            @else
            <h3 class="produccionPor fs-6 mb-4 text-muted">Autor: anónimo.</h3>
            @endif
            <button type="button" class="btn btn-primary w-auto" data-bs-toggle="modal"
              data-bs-target="#participantes">
              Ver participantes
            </button>

            <!-- Modal -->
            <div class="modal fade" id="participantes" role="dialog"
              aria-modal="true" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
              aria-labelledby="participantesLabel" aria-hidden="true">
              <div class="modal-dialog modal-dialog-scrollable">
                <div class="modal-content">
                  <div class="modal-header">
                    <h2 class="modal-title fs-4 pt-3" id="participantesLabel">Participantes</h2>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                  </div>
                  <div class="modal-body">
                    <div class="card">
                      <ul class="list-group list-group-flush">

                        @php
                        $miembrosPorLabel = $obra->membersProduction->groupBy('label_id');
                        @endphp

                        @foreach($labels as $label)
                        <li class="list-group-item p-3">
                          <h3 class="fw-medium fs-5 mb-2">{{ $label->name }}</h3>
                          @if($miembrosPorLabel->has($label->id))
                          <p class="text-break">
                            {{ $miembrosPorLabel[$label->id]->pluck('name')->implode(', ') }}
                          </p>
                          @else
                          <p class="text-secondary">
                            No especificado
                          </p>
                          @endif
                        </li>
                        @endforeach
                      </ul>
                    </div>
                  </div>
                  <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>

    <div class="col-12 col-md-12 col-lg-6 mb-4">
      <div class="tarjeta p-4 rounded-3 mb-4">
        <div class="mb-3">
          <h2 class="d-inline fs-4">Obra:</h2>
          @if($tieneVirtual && $tienePresencial)
          <span class="tipoObra fs-4 d-inline ms-2"><ins>Modalidad mixta</ins></span>
          @elseif($tieneVirtual)
          <span class="tipoObra fs-4 d-inline ms-2"><ins>Virtual</ins></span>
          @else
          <span class="tipoObra fs-4 d-inline ms-2"><ins>Presencial</ins></span>
          @endif
        </div>

        <div class="mb-3">
          <h2 class="d-inline fs-4">Ubicación:</h2>
          <span class="fs-4 d-inline text-break ms-2">{{$obra->ubicacion}}</span>
        </div>
        @if($obra->performance->where('stock', '>', 0)->isEmpty())
        <div class="w-100 d-flex justify-content-center align-items-center">
          <div class="text-center"> <i class="bi bi-ticket-perforated display-1 text-danger opacity-25"></i>
            <p class="fs-5 my-4 text-danger">No hay funciones disponibles</p>
          </div>
        </div>
        @else
        <form id="form-carrito" method="POST" action="{{ route('cart.agregar', $obra->id) }}">
          @csrf

          <input type="hidden" id="precio-unitario" value="{{ $obra->precio }}">
          <input type="hidden" id="cantidad-inicial" value="{{ $cartItem?->cantidad ?? 0 }}">
          <input type="hidden" id="emails-iniciales" value='@json($cartItem?->emails_virtuales ?? [])'>
          @if($cartItem)
          <input type="hidden" name="cart_item_id" value="{{ $cartItem->id }}">
          @endif

          <div class="mb-4">
            <label for="funcion-select" class="form-label fs-4">Fechas disponibles</label>
            <select class="form-control form-select" id="funcion-select" name="performance_id" required>
              <option value="" data-stock="0">Seleccionar función</option>
              @foreach ($obra->performance as $funcion)
              @if ($funcion->stock > 0)
              <option value="{{ $funcion->id }}" data-stock="{{ $funcion->stock }}" data-virtual="{{ $funcion->linkVirtual ? 1 : 0 }}" {{ $cartItem && $cartItem->performance_id == $funcion->id ? 'selected' : '' }}>
                {{ \Carbon\Carbon::parse($funcion->fechaObra)->format('d/m/Y') }} -
                {{ \Carbon\Carbon::parse($funcion->horaObra)->format('H:i') }}hs
                ({{ $funcion->linkVirtual ? 'Virtual' : 'Presencial' }})
              </option>
              @endif
              @endforeach
            </select>

            <small class="text-muted">Stock actual:
              <span id="stock-display">{{ $obra->performance->where('stock', '>', 0)->first()->stock ?? '0' }}</span>
            </small>
          </div>
          <div class="ticket-header">
            <h3 class="fs-4">Entradas</h3>
          </div>
          <div class="ticket-container rounded-3 mb-4">
            <div class="ticket-item pb-4">
              <div class="row w-100">
                <div class="col-12 col-md-6 mb-1 d-flex align-items-center">
                  <div class="d-inline me-2">
                    <p class="mb-0">Precio: <span>${{ $obra->precio }}</span></p>
                  </div>
                </div>
                <div class="col-12 col-md-6 d-flex justify-content-end">
                  <div class="quantity-controls">
                    <button type="button" class="btn btn-secondary btn-quantity" onclick="actualizarCantidadDeEntradas(-1)">-</button>
                    <span class="quantity" id="general-quantity">0</span>
                    <button type="button" class="btn btn-primary btn-quantity btnYellow p-0" onclick="actualizarCantidadDeEntradas(1)">+</button>
                  </div>
                </div>
              </div>
            </div>
            <div class="total-section rounded-3">
              <div class="d-flex justify-content-between">
                <h4 class="fw-bold">Total:</h4>
                <h4 id="total-price">$ 0</h4>
              </div>
            </div>
          </div>

          <div id="mensaje-virtual" class="mb-2 pt-2 d-none">
            <h3 class="fs-4">Añadir emails</h3>
            <p>Como esta función es virtual, ingresá un email por cada entrada.</p>
          </div>

          <div id="contenedor-emails"></div>

          <input type="hidden" name="cantidad_entradas" id="cantidad-input" value="0">

          <div class="botonesAccion mt-5 mb-4">
            <button type="submit" class="btn btn-primary btnYellow w-auto" id="btn-submit-carrito">Añadir al carrito</button>
          </div>
        </form>
        <div id="contenedor-notificaciones" class="position-fixed bottom-0 end-0 p-3" style="z-index: 1050;">

          <div id="notificacion-exito" class="alert alert-success alert-dismissible fade show" role="alert" style="display: none;">
            <i class="bi bi-check-circle-fill me-2"></i>
            <strong>¡Éxito!</strong> Se añadió al carrito
            <button type="button" class="btn-close" onclick="this.parentElement.style.display='none'"></button>
          </div>

          <div id="notificacion-error" class="alert alert-danger alert-dismissible fade show" role="alert" style="display: none;">
            <i class="bi bi-exclamation-triangle-fill me-2"></i>
            <strong id="texto-error">Por favor, seleccioná al menos una entrada.</strong>
            <button type="button" class="btn-close" onclick="this.parentElement.style.display='none'"></button>
          </div>
        </div>
        @endif
      </div>
    </div>
  </div>
</section>