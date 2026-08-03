<section class="pb-4">
  <div class="espacio">@if(session('success'))
    <div
      x-data="{ show: true }"
      x-show="show"
      x-transition
      x-init="setTimeout(() => show = false, 3000)"
      class="alert alert-success">
      {{ session('success') }}
    </div>
    @endif
    <div class="d-flex align-items-center mb-4 ml-2">
      <div class="d-flex justify-content-between align-items-center me-3" style="height: 4rem;">
        <div class="d-flex align-items-center">
          <div class="d-none d-sm-flex">
            @if(Str::contains(url()->previous(), 'ticket-entries') || Str::contains(url()->previous(), 'listado'))
            <a href="{{ route('obras.index') }}" class="volverBtn text-decoration-none">
              <i class="bi bi-arrow-left-circle-fill fs-2"></i>
            </a>
            @else
            <a href="{{ url()->previous() }}" class="volverBtn text-decoration-none">
              <i class="bi bi-arrow-left-circle-fill fs-2"></i>
            </a>
            @endif
          </div>
        </div>
      </div>
      <h1 class="mb-0 fs-1 text-break">{{$obra->nombre_obra}}</h1>
    </div>

    <div class="row">
      <div class="col-12 col-md-12 col-lg-6 mb-4">
        <div class="tarjeta p-4 pb-2 rounded-3 mb-4 h-100">
          <h2 class="fs-3 mb-4">Información General</h2>

          <div class="mb-4">
            @if($obra->imagen)
            <img src="{{asset('storage/imagenes/' . $obra->imagen) }}" alt="{{$obra->nombre_obra}}"
              class="imgPrincipalObra img-fluid rounded-1">
            @else
            <img src="{{ asset('storage/imagenes/default/obraDefaultImg.jpg') }}" class="imgPrincipalObra img-fluid rounded-1" alt="{{ $obra->nombre_obra }}">
            @endif
          </div>

          <div class="obra-info">
            @if($obra->solo_compartido)
            <div class="mt-3">
              <p><strong>Link privado:</strong></p>

              <input type="text" class="form-control mb-2"
                value="{{ route('obras.privadas.show', $obra->slug) }}"
                readonly>

              <a href="{{ route('obras.privadas.show', $obra->slug) }}" target="_blank">
                Ver obra como usuario
              </a>
            </div>
            @endif

            <div class="row mb-3">
              <div class="col-12 p-0 detalles-list">
                <div class="detalle-item mb-4 mt-1">
                  <h3 class="fw-bold fs-6 mb-2">Titulo</h3>
                  <p class="p-2 text-small shadow-sm bg-light rounded text-break">{{$obra->nombre_obra ?? 'No especificado'}}</p>
                </div>
              </div>

              <div class="col-12 p-0 detalles-list">
                <div class="detalle-item mb-4">
                  <h3 class="fw-bold fs-6 mb-2">Ubicación</h3>
                  <p class="p-2 text-small text-break bg-light rounded">{{$obra->ubicacion}}</p>
                </div>
              </div>

              <div class="col-12 col-md-12 col-lg-6 ps-0 detalles-list">
                <div class="detalle-item mb-4">
                  <h3 class="fw-bold fs-6 mb-2">Género/s
                  </h3>
                  @forelse($obra->genres as $genero)
                  <span class="badge rounded-pill text-bg-warning me-1 mb-1">
                    {{ $genero->name }}
                  </span>
                  @empty
                  <span class="mt-4 badge rounded-pill text-bg-secondary">No especificado</span>
                  @endforelse
                </div>
              </div>

              <div class="col-12 col-md-12 col-lg-6 ps-0 detalles-list">
                <div class="detalle-item mb-4">
                  <h3 class="fw-bold fs-6 mb-2">Adaptaciones
                  </h3>
                  @if($obra->adaptations->isNotEmpty())
                  @foreach($obra->adaptations as $adaptacion)
                  <span class="badge rounded-pill me-1
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
                    {{$adaptacion->name}}</span>
                  @endforeach
                  @else
                  <span class="badge rounded-pill text-bg-secondary">No especificado</span>
                  @endif
                </div>
              </div>

            </div>
          </div>
        </div>
      </div>

      <div class="col-12 col-md-12 col-lg-6 mb-4">
        <div class="tarjeta p-4 pb-2 rounded-3 mb-4 h-100">
          <h2 class="fs-3 mb-4">Funciones Programadas</h2>
          <div class="funciones-list">
            @forelse($obra->performance as $index => $funcion)
            <div class="funcion-item card mb-3 border-0 shadow-sm">
              <div class="card-body">
                <div class="d-flex justify-content-between align-items-start">
                  <div>
                    <div class="mb-1">
                      <h3 class="card-title fw-bold fs-5">Función {{ $loop->iteration }}</h3>
                      @if($funcion->cancelado)
                      <span class="badge bg-danger">
                        Función cancelada
                      </span>
                      @endif
                    </div>
                    <p class="mb-1 text-secondary"><strong>Fecha:</strong>
                      {{ \Carbon\Carbon::parse($funcion->fechaObra)->format('d/m/Y') }}
                    </p>
                    <p class="mb-1 text-secondary"><strong>Hora:</strong> {{ \Carbon\Carbon::parse($funcion->horaObra)->format('H:i') }} hs</p>

                    @if($funcion->linkVirtual)
                    <p class="mb-1 text-secondary">
                      <strong>Link virtual:</strong>
                      <a href="{{ $funcion->linkVirtual }}" target="_blank" class="text-decoration-underline text-break">{{ $funcion->linkVirtual }}</a>
                    </p>
                    @endif

                    <p class="mb-4 text-secondary">
                      <strong>Stock disponible:</strong>
                      <span class="ms-2 badge {{ $funcion->stock > 0 ? 'bg-success' : 'bg-danger' }}">
                        {{ $funcion->stock }} entradas
                      </span>
                    </p>

                  </div>
                  <div class="text-end">
                    <small class="text-muted">#{{ $loop->iteration }}</small>
                  </div>
                </div>
                <div class="d-grid gap-2 d-md-flex justify-content-md-between">
                  <div>
                    <button type="button" class="btn btn-outline-primary btn-sm mb-2" data-bs-toggle="modal" data-bs-target="#modalFuncion{{ $funcion->id }}">
                      Entradas vendidas
                    </button>

                    <!-- Modal -->
                    <div class="modal fade" id="modalFuncion{{ $funcion->id }}" tabindex="-1" aria-labelledby="modalFuncionLabel{{ $funcion->id }}" aria-hidden="true" role="dialog">
                      <div class="modal-dialog modal-dialog-scrollable modal-dialog-centered modal-lg">
                        <div class="alturaModal modal-content">
                          <div class="modal-header">
                            <h4 id="modalFuncionLabel{{ $funcion->id }}" class="fs-3 modal-title">Función del <span class=" fw-bold">{{ \Carbon\Carbon::parse($funcion->fechaObra)->format('d/m') }}</span> a las <span class=" fw-bold">{{ \Carbon\Carbon::parse($funcion->horaObra)->format('H:i') }}hs</span></h4>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                          </div>
                          <div class="modal-body">
                            <table class="table table-bordered">
                              <thead>
                                <tr>
                                  <th>Nombre</th>
                                  <th>Nickname</th>
                                  <th>Email del comprador</th>
                                  <th class="text-center">Entradas</th>
                                  <th class="text-end">Monto</th>
                                </tr>
                              </thead>
                              <tbody>
                                @php
                                $fechaHoraFuncion = \Carbon\Carbon::parse($funcion->fechaObra)->format('Y-m-d') . ' ' . $funcion->horaObra;
                                $asistentes = $obra->ticketdetalles->filter(function($detalle) use ($fechaHoraFuncion) {
                                return \Carbon\Carbon::parse($detalle->fecha_hora_obra)->format('Y-m-d H:i:s') == $fechaHoraFuncion;
                                });
                                @endphp

                                @forelse($asistentes as $detalle)
                                <tr>
                                  <td>
                                    {{ $detalle->ticket->datos_usuario['nombre'] ?? 'No disponible' }}
                                  </td>
                                  <td>
                                    {{ $detalle->ticket->datos_usuario['nickname'] ?? 'No disponible' }}
                                  </td>
                                  <td><small>{{ $detalle->ticket->datos_usuario['email'] ?? 'Sin email' }}</small></td>
                                  <td class="text-center">{{ $detalle->cantidad }}</td>
                                  <td class="text-end">${{ number_format($detalle->subtotal, 2) }}</td>
                                </tr>
                                @empty
                                <tr>
                                  <td colspan="5" class="text-center text-muted">Aún no se han comprado entradas para esta función.</td>
                                </tr>
                                @endforelse
                              </tbody>
                            </table>
                          </div>
                        </div>
                      </div>
                    </div>

                    <a href="{{ route('listado', $funcion->id) }}" class="btn btn-secondary btn-sm mb-2">
                      Listado
                    </a>
                  </div>
                  @if(auth()->user()->rol === 'admin')
                  @if($funcion->cancelado)
                  <button class="btn borrar btn-outline-danger btn-sm mb-2" disabled>
                    Cancelada
                  </button>
                  @else

                  @include('admin.partials.admin-cancel-performance')

                  @endif
                  @endif
                </div>
              </div>
            </div>
            @empty
            <div class="alert alert-warning text-center">
              <p class="mb-0">No hay funciones programadas</p>
            </div>
            @endforelse
          </div>
          <div class="d-flex gap-2">
            <a href="{{ route('obras.edit', $obra) }}" class="btn btn-primary flex-fill">
              Editar obra
            </a>

            @if(auth()->user()->rol === 'admin')

            @include('admin.partials.admin-delete-play')

            @elseif($obra->puedeEliminarseDefinitivamente())

            @include('productor.partials.delete-play')

            @else
            <button type="button" class="borrar btn btn-outline-danger rounded-pill" disabled title="No se puede ocultar porque hay stock disponible o funciones pendientes">
              Eliminar
            </button>
            @endif

          </div>
        </div>

      </div>

      <div class="col-12 mb-4">
        <div class="tarjeta p-4 rounded-3">
          <h2 class="fs-3 mb-4">Detalles de la Producción</h2>

          <div class="detalles-list">

            <div class="detalle-item mb-4">
              <h3 class="fw-bold fs-6 mb-2">Autor</h3>
              <p class="p-2 shadow-sm bg-light rounded">{{$obra->autor ?? 'Anónimo'}}</p>
            </div>

            <div class="detalle-item mb-4">
              <h3 class="fw-bold fs-6 mb-2">Sinopsis</h3>
              <p class="p-2 shadow-sm bg-light rounded text-break">{{$obra->sinopsis ?? 'No hay sinopsis disponible'}}</p>
            </div>

            <div class="row p-0">

              <div class="col-12 col-md-12 col-lg-6 ps-0 detalles-list">
                <div class="detalle-item mb-4">
                  <h3 class="fw-bold fs-6 mb-2">Precio</h3>
                  <p class="p-2 text-small shadow-sm bg-light rounded">${{number_format($obra->precio, 2)}}</p>
                </div>
              </div>


              <div class="col-12 col-md-12 col-lg-6 ps-0 detalles-list">
                <div class="detalle-item mb-4">
                  <h3 class="fw-bold fs-6 mb-2">Clasificación</h3>
                  <p class="p-2 text-small shadow-sm bg-light rounded">{{$obra->clasificacion ?? 'No especificado'}}</p>
                </div>
              </div>
            </div>
            <h2 class="fs-4 border-dark-subtle border-top mt-5 mb-4 pt-4">Participantes</h2>
            @php
            $miembrosPorLabel = $obra->membersProduction->groupBy('label_id');
            @endphp

            @foreach($labels as $label)
            <div class="detalle-item mb-4">
              <h3 class="fw-bold fs-6 mb-2">{{ $label->name }}</h3>
              @if($miembrosPorLabel->has($label->id))
              <p class="p-2 shadow-sm bg-light rounded text-break">
                {{ $miembrosPorLabel[$label->id]->pluck('name')->implode(', ') }}
              </p>
              @else
              <p class="p-2 shadow-sm bg-light rounded text-break text-muted">Sin definir</p>
              @endif
            </div>
            @endforeach


          </div>
        </div>
      </div>
    </div>
  </div>
</section>