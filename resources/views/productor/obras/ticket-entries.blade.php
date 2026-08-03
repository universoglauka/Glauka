@extends('layouts.app')
@section('title', 'Listado')
@section('content')
<div class="espacio container-fluid py-4">
  <div class="d-flex justify-content-between align-items-center me-3" style="height: 4rem;">
    <div class="d-flex align-items-center">
      <div class="d-none d-sm-flex">
        <a href="{{ route('obras.show', $performance->obra_id) }}" class="volverBtn text-decoration-none">
          <i class="bi bi-arrow-left-circle-fill fs-2"></i>
        </a>
      </div>
    </div>
  </div>
  <div class="card shadow-sm">
    <div class="card-body">
      <h1 class="fs-1 mb-2">
        {{ $performance->obra->nombre_obra }}
      </h1>

      <p class="text-muted mb-4">
        {{ \Carbon\Carbon::parse($performance->fechaObra)->format('d/m/Y') }}
        -
        {{ \Carbon\Carbon::parse($performance->horaObra)->format('H:i') }} hs
      </p>


      @if($entries->isNotEmpty() || request('search'))
      <form method="GET" class="mb-4">
        @csrf
        <div class="input-group">
          <input
            type="text"
            name="search"
            class="form-control"
            placeholder="Buscar por código o nombre"
            value="{{ request('search') }}">
          <button class="btn btn-primary ms-1">
            <i class="bi bi-search"></i> Buscar
          </button>
        </div>
      </form>
      <div class="table-responsive">
        <table class="table table-hover align-middle">
          <thead>
            <tr>
              <th>Código</th>
              @if($performance->linkVirtual)
              <th>Email asignado</th>
              @endif
              <th>Comprador</th>
              <th>Responsable</th>
              <th>Estado</th>
              <th>Acciones</th>
            </tr>
          </thead>
          <tbody>
            @foreach($entries as $entry)
            <tr>
              <td data-label="Código"><strong>{{ $entry->codigo }}</strong></td>
              @if($entry->ticketdetalles->performance?->linkVirtual)
              <td data-label="Email">
                @php
                $indice = (int) explode('-', $entry->codigo)[1] - 1;
                @endphp

                {{ $entry->ticketdetalles->emails_virtuales[$indice] ?? 'No asignado' }}
              </td>
              @endif
              <td data-label="Comprador">{{ $entry->ticketdetalles->ticket->user->name }}</td>
              <td data-label="Responsable">
                <button class="btn btn-sm btn-outline-secondary" data-bs-toggle="modal" data-bs-target="#contacto{{ $entry->id }}">
                  Ver datos
                </button>
              </td>
              <td data-label="Estado">
                @if($entry->checked_at)
                <span class="badge bg-success">Asistió</span>
                @else
                <span class="badge bg-warning text-dark">Pendiente</span>
                @endif
              </td>
              <td data-label="Acciones">
                @if(!$entry->checked_at)
                <form method="POST" action="{{ route('ticket-entries.checkin', $entry) }}" class="d-inline">
                  @csrf
                  <button class="btn btnGreen btn-sm">
                    Asistió
                  </button>
                </form>
                @else
                <form method="POST" action="{{ route('ticket-entries.undo', $entry) }}" class="d-inline">
                  @csrf
                  <button class="btn btnYellow btn-sm">
                    Pendiente
                  </button>
                </form>
                @endif
              </td>
            </tr>

            @endforeach
          </tbody>
        </table>

        @foreach($entries as $entry)
        <div class="modal fade" id="contacto{{ $entry->id }}" role="dialog"
          aria-modal="true" tabindex="-1">
          <div class="modal-dialog">
            <div class="modal-content">
              <div class="modal-header">
                <p class="fs-5 modal-title">Datos del responsable</p>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
              </div>
              <div class="modal-body">
                <div class="mb-2">
                  <strong>Nombre:</strong> {{ $entry->ticketdetalles->ticket->datos_usuario['nombre'] ?? 'N/A' }}
                </div>
                <div class="mb-2">
                  <strong>Nickname:</strong> {{ $entry->ticketdetalles->ticket->datos_usuario['nickname'] ?? 'N/A' }}
                </div>
                <div class="mb-2">
                  <strong>Email:</strong> {{ $entry->ticketdetalles->ticket->datos_usuario['email'] ?? 'N/A' }}
                </div>
              </div>
            </div>
          </div>
        </div>
        @endforeach

        @if(request('search') && $entries->isEmpty())
        <div class="text-center my-5">
          <i class="bi bi-ticket-perforated display-1 text-muted opacity-25"></i>
          <p class="mt-4 text-muted">
            No se encontraron resultados para "<strong>{{ request('search') }}</strong>"
          </p>
        </div>
        @endif
      </div>

      @else
      <div class="text-center my-5">
        <i class="bi bi-ticket-perforated display-1 text-muted opacity-25"></i>
        <p class="mt-4 text-muted">
          Aún no se han comprado entradas para esta función.
        </p>
      </div>
      @endif
      @if(method_exists($entries, 'links'))
      <div class="d-flex justify-content-center mt-4">
        {{ $entries->links() }}
      </div>
      @endif
    </div>
  </div>
</div>
@endsection