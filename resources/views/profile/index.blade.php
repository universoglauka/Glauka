@extends('layouts.app')

@section('content')


<div class="container py-5">
  @if(session('success'))
  <div
    x-data="{ show: true }"
    x-show="show"
    x-transition
    x-init="setTimeout(() => show = false, 3000)"
    class="alert alert-success">
    {{ session('success') }}
  </div>
  @endif
  <div class="row">
    <div class="col-12 col-md-12 col-lg-4 mb-4 mb-lg-0">
      <div class="card h-100 border-0 shadow-sm rounded-4 text-center overflow-hidden perfil-card">
        <div class="perfil-header position-relative text-center">
          <div class="perfil-banner"></div>
          <div class="perfil-avatar">
            @if ($user->userIcon)
            <img src="{{ asset('storage/imagenes/userIcon/'.$user->userIcon) }}"
              class="img-fluid rounded-circle"
              alt="Avatar de {{ $user->name }}">
            @else
            <img src="{{ asset('storage/imagenes/default/userDefaultIcon.jpeg') }}"
              class="img-fluid rounded-circle"
              alt="Avatar default de {{ $user->name }}">
            @endif

          </div>
        </div>

        <div class="card-body position-relative pt-0 mt-5">
          @if($user->plan_id == 3 || $user->plan_id == 4)
          <span class="badge rounded-pill bg-warning text-dark border px-3 py-1 mt-3">
            Usuario Premium
          </span>
          @endif

          @if($isUserProfile)
          <h1 class="fs-3 mb-1 mt-3">
            {{ $user->name }}
          </h1>
          @endif

          @if($isProducerProfile)
          <h1 class="fs-3 mb-1 mt-3">
            {{ $user->productor->name_group ?? 'Grupo sin nombre' }}
          </h1>
          @endif
          @if($user->labels->count())
          <div class="d-flex justify-content-center flex-wrap gap-2 mb-3">

            @foreach($user->labels as $label)
            <span class="badge rounded-pill bg-light text-dark border px-3 py-1">
              {{ $label->name }}
            </span>
            @endforeach

          </div>
          @endif

          <p class="text-muted mb-2">{{ $user->email }}</p>

          <p class="small text-secondary mt-2 mb-0">
            <i class="bi bi-calendar-check"></i> Miembro desde {{ $user->created_at->format('d/m/Y') }}
          </p>

          <p class="small text-muted mt-3">
            <i class="bi bi-quote"></i>
            {{ $user->description ?? 'Mirando a las estrellas' }}
          </p>

          @if($user->plan_id == 2)
          <div>
            <a href="{{ route('producerPremium') }}" class="btn btn-sm w-100 mt-5">Volverse Premium</a>
          </div>
          @endif
        </div>

        <div class="card-footer bg-white border-0 d-flex justify-content-center gap-2 pb-4">
          @if(auth()->check() && auth()->user()->rol === "admin")
          <a href="{{ route('admin.profile.edit', $user) }}" class="btn btn-outline-primary btn-sm rounded-pill px-3" data-bs-toggle="tooltip" title="Editar perfil">
            <i class="bi bi-pencil-square"></i> Editar
          </a>
          @else
          <a href="{{ route('profile.edit')}}" class="btn btn-outline-primary btn-sm rounded-pill px-3" data-bs-toggle="tooltip" title="Editar perfil">
            Editar
          </a>
          @endif

          <button type="button" class="btn btn-secondary btn-sm rounded-pill px-3" data-bs-toggle="modal" data-bs-target="#modalEliminarUsuario{{ $user->id }}" title="Eliminar cuenta">
            Eliminar
          </button>

          <!-- Modal -->
          <div class="modal fade" id="modalEliminarUsuario{{ $user->id }}" role="dialog"
            aria-modal="true" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
              <div class="modal-content border-0 shadow">
                <div class="modal-header border-0">
                  <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body text-center pb-5 px-5">

                  @if(auth()->user()->rol === 'admin')
                  <div>
                    <h3 class="fw-bold">¿Estás seguro?</h3>
                    <p class="text-muted pb-4">Esta acción eliminará su cuenta permanentemente y no se puede deshacer.</p>

                    <form method="POST" action="{{ route('admin.user.destroy', $user) }}">
                      @csrf
                      @method('DELETE')
                      <x-danger-button>{{ __('Eliminar usuario') }}</x-danger-button>
                    </form>
                  </div>

                  @else
                  <div>
                    @include('profile.partials.delete-user-form')
                    <button type="button" class="btn btn-light btn-lg rounded-pill px-5 w-100" data-bs-dismiss="modal">Cancelar</button>

                  </div>
                  @endif

                </div>
              </div>
            </div>
          </div>
        </div>

      </div>
    </div>

    <div class="col-lg-8">
      <div class="card border-0 shadow-sm rounded-4">
        <div class="card-header card-perfil-header border-0 p-4 my-2 rounded-top-4">
          <ul class="nav nav-tabs card-header-tabs ms-3" id="profileTabs" role="tablist">

            @if($isUserProfile)
            <li class="nav-item">
              <button
                class="nav-link active fw-bold text-dark"
                id="entradas-tab"
                data-bs-toggle="tab"
                data-bs-target="#tickets"
                type="button"
                role="tab">
                Mis entradas
              </button>
            </li>

            <li class="nav-item">
              <button
                class="nav-link fw-bold text-dark"
                id="compras-tab"
                data-bs-toggle="tab"
                data-bs-target="#historial"
                type="button"
                role="tab">
                Historial de tickets
              </button>
            </li>

            <li class="nav-item">
              <button
                class="nav-link fw-bold text-dark"
                id="fav-tab"
                data-bs-toggle="tab"
                data-bs-target="#fav"
                type="button"
                role="tab">
                Favoritos
              </button>
            </li>
            @endif

            @if($isProducerProfile)
            <li class="nav-item">
              <button
                class="nav-link active fw-bold text-dark"
                id="info-tab"
                data-bs-toggle="tab"
                data-bs-target="#info"
                type="button"
                role="tab">
                Información del grupo
              </button>
            </li>

            <li class="nav-item">
              <button
                class="nav-link fw-bold text-dark"
                id="obras-actuales-tab"
                data-bs-toggle="tab"
                data-bs-target="#obras-actuales"
                type="button"
                role="tab">
                Obras activas
              </button>
            </li>

            <li class="nav-item">
              <button
                class="nav-link fw-bold text-dark"
                id="obras-pasadas-tab"
                data-bs-toggle="tab"
                data-bs-target="#obras-pasadas"
                type="button"
                role="tab">
                Obras pasadas
              </button>
            </li>

            <li class="nav-item">
              <button
                class="nav-link fw-bold text-dark"
                id="publicaciones-tab"
                data-bs-toggle="tab"
                data-bs-target="#publicaciones"
                type="button"
                role="tab">
                Publicaciones
              </button>
            </li>
            @endif
          </ul>
        </div>

        <!-- Usuario común -->
        <div class="card-body p-4 rounded-4">
          <div class="tab-content" id="profileTabsContent">

            @if($isUserProfile)
            <div class="tab-pane fade show active" id="tickets" role="tabpanel">
              <h2 class="fs-4">Mis entradas</h2>
              <div class="perfilInfo row g-4 mt-1">
                @forelse ($entradasActivas as $ticket)
                @foreach ($ticket->ticketdetalles as $detalle)
                <div class="col-md-6">
                  <div class="card border-0 shadow-sm h-100 rounded-4 overflow-hidden">
                    @if($detalle->obra->imagen)
                    <img src="{{ asset('storage/imagenes/'.$detalle->obra->imagen) }}" alt="{{ $detalle->obra->nombre_obra }}" class="card-img-top rounded-1 me-3 border " style="height: 200px; object-fit: cover;">
                    @else
                    <img src="{{ asset('storage/imagenes/default/obraDefaultImg.jpg') }}" alt="{{ $detalle->obra->nombre_obra }}" class="card-img-top rounded-1 me-3 border " style="height: 200px; object-fit: cover;">
                    @endif
                    <div class="card-body">
                      <div class="d-flex justify-content-between">
                        <h3 class="fs-5 fw-bold mb-1 text-truncate">
                          {{ $detalle->obra->nombre_obra }}
                        </h3>
                        @if($detalle->performance->cancelado)
                        <span class="badge bg-danger-subtle text-danger border border-danger-subtle px-3 py-2 rounded-pill">
                          Cancelada
                        </span>
                        @else
                        <span class="badge bg-success-subtle text-success border border-success-subtle px-3 py-2 rounded-pill">
                          Activa
                        </span>
                        @endif
                      </div>
                      <div class="small text-muted ">
                        <div class="small text-muted">
                          @php
                          $fechaOriginal = \Carbon\Carbon::parse($detalle->fecha_hora_obra);
                          $fechaActual = \Carbon\Carbon::parse(
                          $detalle->performance->fechaObra . ' ' . $detalle->performance->horaObra
                          );
                          @endphp

                          @if($detalle->performance->cancelado)
                          <div>
                            <span class="text-danger text-decoration-line-through">
                              {{ $fechaOriginal->format('d/m/Y - H:i') }} hs
                            </span>
                          </div>

                          @elseif($fechaOriginal->equalTo($fechaActual))

                          {{ $fechaOriginal->format('d/m/Y - H:i') }} hs

                          @else
                          <div>
                            <span class="text-decoration-line-through text-muted">
                              {{ $fechaOriginal->format('d/m/Y - H:i') }} hs
                            </span>

                            <br>

                            <span class="fw-bold">
                              {{ $fechaActual->format('d/m/Y - H:i') }} hs
                            </span>
                          </div>

                          @endif
                        </div>
                      </div>
                      <div class="small text-muted">
                        Cantidad: {{ $detalle->cantidad }}
                      </div>

                      @if($detalle->performance && $detalle->es_virtual)
                      <button type="button" class="btn btn-secondary btn-sm mt-2" data-bs-toggle="modal" data-bs-target="#modalCodigo{{ $detalle->id }}">
                        Ver link
                      </button>
                      <!-- Modal -->
                      <div class="modal fade" id="modalCodigo{{ $detalle->id }}" role="dialog"
                        aria-modal="true" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-scrollable">
                          <div class="modal-content">
                            <div class="modal-header">
                              <h3 class="modal-title fs-4" id="modalCodigo{{ $detalle->id }}Label">Link de la función</h3>
                              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body espacio tarjeta">
                              <p class="text-muted">Este es el url de la función. Puedes hacer click en ella para ingresar.</p>
                              <p><strong class="text-danger">¡No lo compartas con cualquiera!</strong></p>
                              <ul class="mt-4">
                                <li><a href="{{ $detalle->performance->linkVirtual }}" target="_blank" class="text-decoration-underline">
                                    {{ $detalle->performance->linkVirtual }}
                                  </a></li>
                              </ul>
                            </div>
                            <div class="modal-footer">
                              <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                            </div>
                          </div>
                        </div>
                      </div>
                      @else
                      <button type="button" class="btn btn-secondary btn-sm mt-2" data-bs-toggle="modal" data-bs-target="#modalCodigo{{ $detalle->id }}">
                        Código de entrada
                      </button>

                      <!-- Modal -->
                      <div class="modal fade" id="modalCodigo{{ $detalle->id }}" role="dialog"
                        aria-modal="true" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-scrollable">
                          <div class="modal-content">
                            <div class="modal-header">
                              <h3 class="modal-title fs-4" id="modalCodigo{{ $detalle->id }}Label">Código de entrada</h3>
                              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body espacio tarjeta">
                              <p class="text-muted">El código o los códigos que aparecerán aquí son necesarios para ingresar a la función.</p>
                              <p><strong class="text-danger">¡No los compartas con cualquiera!</strong></p>
                              <ul class="mt-4">
                                @foreach($detalle->ticketEntries as $entry)
                                <li><strong>Código de entrada {{ $loop->iteration }}:</strong> {{ $entry->codigo }}</li>
                                @endforeach
                              </ul>
                            </div>
                            <div class="modal-footer">
                              <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                            </div>
                          </div>
                        </div>
                      </div>
                      @endif
                    </div>
                  </div>
                </div>
                @endforeach

                @empty
                <div class="col-12 d-flex justify-content-center align-items-center">
                  <div class="text-center">
                    <i class="bi bi-ticket-perforated display-1 text-muted opacity-25"></i>
                    <p class="mt-4 text-muted">
                      No tienes entradas activas actualmente.
                    </p>
                  </div>
                </div>
                @endforelse
              </div>
            </div>
            @endif

            @if($isUserProfile)
            <div class="tab-pane fade" id="historial" role="tabpanel">
              <h2 class="fs-4">Historial de tickets</h2>

              <div class="perfilInfo row g-4 mt-1">
                @forelse ($user->tickets as $ticket)
                <div class="col-md-6">
                  <div class="card mb-2 border border-light-subtle bg-light shadow-sm">
                    <div class="card-body d-flex align-items-center justify-content-between flex-wrap gap-3">
                      <div class="historialNumero d-flex align-items-center">
                        <div class="bg-white p-2 rounded-circle border me-3 text-primary">
                          <i class="bi bi-ticket-perforated fs-4 px-1"></i>
                        </div>
                        <div>
                          <h3 class="fs-6 mb-0 fw-bold">Compra #{{ str_pad($ticket->id, 6, '0', STR_PAD_LEFT) }}</h3> <small class="text-muted"> {{ $ticket->created_at->format('d/m/Y') }} • <span class="text-success fw-bold">${{ number_format($ticket->total, 2) }}</span> </small>
                        </div>
                      </div>
                      <button class="d-block btn btn-sm btn-secondary" data-bs-toggle="modal" data-bs-target="#modalDetalleCompra{{ $ticket->id }}"> Ver detalles </button>

                    </div>
                  </div>
                  <!-- Modal -->
                  <div class="modal fade" id="modalDetalleCompra{{ $ticket->id }}" tabindex="-1" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered modal-lg modal-dialog-scrollable">
                      <div class="modal-content rounded-4 border-0 shadow">

                        <div class="modal-header border-bottom-0 pb-0">
                          <div>
                            <h3 class="fs-4 modal-title fw-bold">Resumen de compra #{{ str_pad($ticket->id, 6, '0', STR_PAD_LEFT) }}</h3>
                            <p class="text-muted small mb-0">Realizado el {{ $ticket->created_at->format('d/m/Y H:i') }} hs</p>
                          </div>
                          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>

                        <div class="modal-body p-3 p-sm-4">
                          <ul class="list-group list-group-flush gap-3">
                            @foreach ($ticket->ticketdetalles as $detalle)
                            @php
                            $cancelado = $detalle->performance->cancelado ?? false;
                            @endphp

                            <li class="list-group-item border rounded-3 p-3 {{ $cancelado ? 'bg-cancelado' : 'bg-light' }}">
                              <div class="row g-3 align-items-center">
                                <div class="col-12 col-md-3 col-lg-2 text-center">
                                  @if($detalle->obra->imagen)
                                  <img src="{{ asset('storage/imagenes/'.$detalle->obra->imagen) }}" alt="{{ $detalle->obra->nombre_obra }}" class="ticket-img img-fluid rounded-3 object-fit-cover border">
                                  @else
                                  <img src="{{ asset('storage/imagenes/default/obraDefaultImg.jpg') }}" alt="{{ $detalle->obra->nombre_obra }}" class="ticket-img img-fluid rounded-3 object-fit-cover border">
                                  @endif
                                </div>

                                <div class="col-12 col-md-9 col-lg-8">
                                  <div class="d-flex align-items-center gap-2 mb-1 flex-wrap">
                                    <h4 class="fs-6 fw-bold mb-0 text-dark">{{ $detalle->nombre_obra }}</h4>
                                  </div>

                                  <div class="small text-secondary space-y-1">
                                    @if($cancelado)
                                    <span class="badge bg-danger">Función Cancelada</span>
                                    @endif
                                    <p class="mb-1"><strong>Productor:</strong> {{ $detalle->nombre_productor }}</p>
                                    <p class="mb-1"><strong>Función:</strong> {{ \Carbon\Carbon::parse($detalle->fecha_hora_obra)->format('d/m/Y - H:i') }} hs</p>
                                    <p class="mb-1"><strong>Cantidad:</strong> {{ $detalle->cantidad }} entrada(s)</p>
                                    <p class="mb-1">
                                      <strong>Modalidad:</strong>
                                      {{ $detalle->es_virtual ? 'Virtual' : 'Presencial' }}
                                    </p>

                                    @if($detalle->es_virtual && !empty($detalle->emails_virtuales))
                                    <div class="dropdown mt-2">
                                      <button class="btn btn-sm btn-outline-secondary dropdown-toggle py-0 px-2 fs-7" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                        Ver accesos/emails
                                      </button>
                                      <ul class="dropdown-menu shadow-sm">
                                        @foreach ($detalle->emails_virtuales as $email)
                                        <li class="dropdown-item small">{{ $email }}</li>
                                        @endforeach
                                      </ul>
                                    </div>
                                    @endif
                                  </div>
                                </div>

                                <div class="col-12 col-md-12 col-lg-2 text-lg-end text-start pt-2 pt-sm-0 priceBorder">
                                  <span class="text-muted d-block small">Subtotal</span>
                                  <span class="fs-5 fw-bold text-dark d-block">${{ number_format($detalle->subtotal, 2) }}</span>
                                  <small class="text-muted fs-7">(${{ number_format($detalle->precio_u, 2) }} c/u)</small>
                                </div>

                              </div>
                            </li>
                            @endforeach
                          </ul>

                          <div class="d-flex justify-content-between align-items-center mt-4 pt-3 border-top">
                            <h3 class="fs-3 fw-semibold">Total Pagado</h3>
                            <span class="fs-3 fw-bold text-success">${{ number_format($ticket->total, 2) }}</span>
                          </div>
                        </div>

                      </div>
                    </div>
                  </div>


                </div>
                @empty
                <div class="col-12 d-flex justify-content-center align-items-center">
                  <div class="text-center">
                    <i class="bi bi-bag-x display-1 text-muted opacity-25 d-block"></i>
                    <p class="mt-2 text-muted">Aún no has realizado ninguna compra.</p>
                    <a href="{{ route('home') }}" class="mt-3 btn btn-primary rounded-pill">Ir al catálogo</a>
                  </div>
                </div>
                @endforelse
              </div>
            </div>
            @endif

            <!-- Favoritos -->
            @if($isUserProfile)
            <div class="tab-pane fade" id="fav" role="tabpanel">
              <h2 class="fs-4">Mis favoritos</h2>

              <div class="perfilInfo row g-4 mt-1">
                @forelse ($favoritos as $obra)

                <div class="col-md-6">
                  <div class="card border-0 shadow-sm h-100 rounded-4 overflow-hidden">

                    @if($obra->imagen)
                    <img src="{{asset('storage/imagenes/' . $obra->imagen) }}" alt="{{$obra->nombre_obra}}"
                      class="object-fit-cover me-3 border card-img-top rounded-1">
                    @else
                    <img src="{{ asset('storage/imagenes/default/obraDefaultImg.jpg') }}" class="object-fit-cover me-3 border card-img-top rounded-1" alt="{{ $obra->nombre_obra }}">
                    @endif
                    <div class="card-body">
                      <h3 class="fs-5 fw-bold text-truncate">
                        {{ $obra->nombre_obra }}
                      </h3>
                      <p class="text-muted small">
                        {{ Str::limit($obra->descripcion, 120) }}
                      </p>
                      <div class="small text-muted">
                        @foreach($obra->performance as $funcion)
                        <small><span class="fw-bold"> | </span>{{ \Carbon\Carbon::parse($funcion->fechaObra)->format('d/m/Y') }} </small>
                        @endforeach
                      </div>
                      <a href="{{ route('obras.show', $obra) }}" class="btn btn-outline-primary btn-sm w-50 mt-3">Ver detalles</a>

                    </div>
                  </div>
                </div>


                @empty
                <div class="col-12 d-flex justify-content-center align-items-center">
                  <div class="text-center">
                    <i class="bi bi-heartbreak display-3 text-muted opacity-25"></i>
                    <p class="mt-2 text-muted">Aún no hay obras en favoritos.</p>
                    <a href="{{ route('home') }}" class="mt-3 btn btn-primary rounded-pill">Ir al catálogo</a>
                  </div>
                </div>
                @endforelse

              </div>

            </div>
            @endif

            <!-- Usuario productor -->
            @if($isProducerProfile)
            <div class="tab-pane fade show active" id="info" role="tabpanel">
              <h2 class="fs-4">Información del grupo</h2>
              <div class="perfilInfo row g-4 mt-1">
                <div class="col-md-12">
                  <div class="card border-0 shadow-sm h-100 rounded-4 overflow-hidden">
                    <div class="card-body">

                      <h3 class="fw-bold mb-3">
                        Representante de la cuenta: {{ $user->name }}
                      </h3>

                      <p class="fs-5 text-muted mb-4">
                        {{ $user->productor->description ?? 'Sin descripción.' }}
                      </p>

                      <div class="row g-3">

                        <div class="col-md-6">
                          <div class="tarjeta rounded-4 p-3">
                            <small class="text-muted d-block">
                              Género principal del grupo
                            </small>

                            <span class="fw-semibold">
                              {{ $user->productor->genre?->name ?? 'Sin género.'}}
                            </span>
                          </div>
                        </div>

                        <div class="col-md-6">
                          <div class="tarjeta rounded-4 p-3">
                            <small class="text-muted d-block">
                              Obras activas
                            </small>

                            <span class="fw-semibold">
                              {{ $obrasActivas->count() }}
                            </span>
                          </div>
                        </div>

                      </div>

                      @if($user->plan_id == 2)
                      <div>
                        <a href="{{ route('producerPremium') }}" class="btn btn-sm w-100 mt-5">Volverse Premium</a>
                      </div>
                      @endif
                    </div>

                  </div>

                </div>
              </div>
            </div>
            @endif

            @if($isProducerProfile)
            <div class="tab-pane fade" id="obras-actuales" role="tabpanel">

              <h2 class="fs-4">Obras activas</h2>
              <div class="perfilInfo row g-4 mt-1">
                @forelse($obrasActivas as $obra)
                @if(!$obra->cancelado)
                <div class="col-md-6">
                  <div class="card border-0 shadow-sm h-100 rounded-4 overflow-hidden">
                    @if($obra->imagen)
                    <img src="{{asset('storage/imagenes/' . $obra->imagen) }}" alt="{{$obra->nombre_obra}}"
                      class="object-fit-cover me-3 border card-img-top rounded-1">
                    @else
                    <img src="{{ asset('storage/imagenes/default/obraDefaultImg.jpg') }}" class="object-fit-cover me-3 border card-img-top rounded-1" alt="{{ $obra->nombre_obra }}">
                    @endif
                    <div class="card-body">
                      <h3 class="fs-5 mb-1 fw-bold text-truncate">
                        {{ $obra->nombre_obra }}
                      </h3>
                      <p class="text-muted mb-1 small">
                        {{ Str::limit($obra->sinopsis, 120) }}
                      </p>
                      <div class="small text-muted text-truncate">
                        @foreach($obra->performance as $funcion)
                        @if($funcion->cancelado)
                        <span class="fw-bold">|</span><small class="text-decoration-line-through fw-light">{{ \Carbon\Carbon::parse($funcion->fechaObra)->format('d/m/Y') }}</small>
                        @else
                        <span class="fw-bold">|</span><small> {{ \Carbon\Carbon::parse($funcion->fechaObra)->format('d/m/Y') }}</small>
                        @endif
                        @endforeach
                      </div>
                      <a href="{{ route('obras.show', $obra) }}" class="btn btn-outline-primary btn-sm w-50 mt-3">Ver detalles</a>

                    </div>
                  </div>
                </div>
                @endif

                @empty
                <div class="text-center py-5">
                  <i class="bi bi-heartbreak display-1 text-muted opacity-25"></i>
                  <p class="mt-3 text-muted">
                    No hay obras activas en este momento.
                  </p>
                </div>

                @endforelse
              </div>
            </div>
            @endif

            @if($isProducerProfile)
            <div class="tab-pane fade" id="obras-pasadas" role="tabpanel">
              <h2 class="fs-4">Obras pasadas</h2>
              <div class="perfilInfo row g-4 mt-1">
                @forelse($obrasPasadas as $obra)
                @if(!$obra->eliminado)
                <div class="col-md-6">
                  <div class="card border-0 shadow-sm h-100 rounded-4 overflow-hidden">
                    @if($obra->imagen)
                    <img src="{{asset('storage/imagenes/' . $obra->imagen) }}" alt="{{$obra->nombre_obra}}"
                      class="object-fit-cover me-3 border card-img-top rounded-1">
                    @else
                    <img src="{{ asset('storage/imagenes/default/obraDefaultImg.jpg') }}" class="object-fit-cover me-3 border card-img-top rounded-1" alt="{{ $obra->nombre_obra }}">
                    @endif
                    <div class="card-body">
                      <h3 class="fs-5 fw-bold text-truncate">
                        {{ $obra->nombre_obra }}
                      </h3>
                      <p class="text-muted small">
                        {{ Str::limit($obra->descripcion, 120) }}
                      </p>
                      <div class="small text-muted text-truncate">
                        @foreach($obra->performance as $funcion)
                        <small><span class="fw-bold">|</span> {{ \Carbon\Carbon::parse($funcion->fechaObra)->format('d/m/Y') }}</small>
                        @endforeach
                      </div>

                      <a href="{{ route('obras.show', $obra) }}" class="btn btn-outline-primary btn-sm w-50 mt-3">Ver detalles</a>

                    </div>
                  </div>
                </div>
                @endif
                @empty

                <div class="text-center py-5">
                  <i class="bi bi-collection display-1 text-muted opacity-25"></i>
                  <p class="mt-3 text-muted">
                    Está vacío...
                  </p>
                </div>

                @endforelse
              </div>
            </div>
            @endif


            @if($isProducerProfile)
            <div class="tab-pane fade" id="publicaciones" role="tabpanel">
              <h2 class="fs-4">Publicaciones activas</h2>
              <div class="perfilInfo row g-4 mt-1 ">
                @forelse($announcements as $announcement)
                <div class="list-group p-3 tarjeta">
                  <div class="list-group-item border-1 shadow-0 rounded-3">
                    <div class="d-flex">
                      <div class="flex-shrink-0">
                        @if(isset($announcement->productor->user->userIcon) && $announcement->productor->user->userIcon)
                        <img src="{{ asset('storage/imagenes/userIcon/' . $announcement->productor->user->userIcon) }}"
                          class="iconUserMini img-fluid rounded-circle" alt="Avatar de {{ $user->name }}">
                        @else
                        <img src="{{ asset('storage/imagenes/default/userDefaultIcon.jpeg') }}"
                          class="iconUserMini img-fluid rounded-circle" alt="Avatar default de {{ $user->name }}">
                        @endif
                      </div>

                      <div class="flex-grow-1 ms-3">
                        <div class="d-flex justify-content-between align-items-start flex-wrap">
                          <div>
                            <h2 class="fs-6 mb-0 fw-bold">{{ $announcement->productor->name_group }}</h2>
                            <small class="text-break">{{ $announcement->title }}</small>
                          </div>
                          @if($announcement->expires_at)
                          <small class="text-muted">
                            <i class="bi bi-calendar"></i>
                            hasta {{ $announcement->expires_at->format('d/m/Y') }}
                          </small>
                          @endif
                        </div>
                      </div>
                    </div>
                    <div class="my-3">
                      <p class="mb-0 mt-2 text-secondary text-break">{!! nl2br(e($announcement->content), false) !!}</p>
                    </div>

                    <div class="my-3">
                      <button type="button" class="btn btn-primary btn-sm rounded-pill mt-4 me-1" data-bs-toggle="modal" data-bs-target="#editarPublicacion{{ $announcement->id }}">
                        Editar
                      </button>

                      <!-- Modal -->
                      <div class="modal fade" id="editarPublicacion{{ $announcement->id }}" data-bs-backdrop="static" role="dialog" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                        <div class="modal-dialog">
                          <div class="modal-content">
                            <div class="modal-header">
                              <h2 class="modal-title fs-4" id="editarPublicacion{{ $announcement->id }}Label">Editar</h2>
                              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>

                            <form action="{{route('announcements.update',$announcement)}}" method="post">
                              @csrf
                              @method('PUT')
                              <div class="modal-body">
                                <div class="mb-3">
                                  <label for="title{{ $announcement->id }}" class="mb-2">Título</label>
                                  <input type="text" name="title" id="title{{ $announcement->id }}" class="form-control" value="{{ old('title',$announcement->title) }}">
                                  @error('title')
                                  <div class="alert text-danger px-0 py-1">{{$message}}</div>
                                  @enderror
                                </div>

                                <div class="mb-3">
                                  <label for="content{{ $announcement->id }}" class="mb-2">Contenido:</label>
                                  <textarea rows="7" cols="50" name="content" id="content{{ $announcement->id }}" class="form-control">{{ old('content',$announcement->content) }}</textarea>
                                  @error('content')
                                  <div class="alert text-danger px-0 py-1">{{$message}}</div>
                                  @enderror
                                </div>

                                <div class="mb-3">
                                  <label for="expires_at{{ $announcement->id }}" class="mb-2">Disponible hasta:</label>
                                  <input type="date" name="expires_at" id="expires_at{{ $announcement->id }}" class="form-control" min="{{ now()->format('Y-m-d') }}"
                                    value="{{ old('expires_at', optional($announcement->expires_at)->format('Y-m-d')) }}">
                                  <span class="mt-4"><small>Si no elijes una fecha límite, la publicación estará disponible durante <strong>30 días</strong> .</small></span>
                                </div>

                              </div>
                              <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                                <button type="submit" class="btn btn-primary">Guardar cambios</button>
                              </div>
                            </form>
                          </div>
                        </div>
                      </div>

                      <button type="button" class="btn btn-secondary btn-sm rounded-pill mt-4" data-bs-toggle="modal" data-bs-target="#eliminarPublicacion{{ $announcement->id }}" title="Eliminar cuenta">
                        Eliminar
                      </button>

                      <div class="modal fade" id="eliminarPublicacion{{ $announcement->id }}" role="dialog"
                        aria-modal="true" tabindex="-1" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered">
                          <div class="modal-content border-0 shadow">
                            <div class="modal-header border-0">
                              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body text-center pb-5 px-5">
                              <div class="mb-3 text-danger">
                                <i class="bi bi-exclamation-circle display-3"></i>
                              </div>

                              <div>
                                <h3 class="fs-3 fw-bold mb-2">¿Estás seguro?</h3>
                                <p class="text-muted mb-4">Esta acción eliminará la publicación y no se puede deshacer.</p>

                                <form method="POST" action="{{ route('announcements.destroy',$announcement) }}">
                                  @csrf
                                  @method('DELETE')
                                  <button type="button" class="btn btn-primary mb-1 me-1" data-bs-dismiss="modal">Cancelar</button>
                                  <button
                                    class="btn btn-secondary mb-1" type="submit">
                                    Eliminar
                                  </button>
                                </form>
                              </div>
                            </div>
                          </div>
                        </div>
                      </div>

                    </div>
                  </div>
                </div>
                @empty
                <div class="text-center py-5">
                  <i class="bi bi-chat-dots display-1 text-muted opacity-25"></i>
                  <p class="mt-3 text-muted">
                    No hay anuncios activos en este momento.
                  </p>
                </div>
                @endforelse
              </div>
            </div>
            @endif
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

@endsection
