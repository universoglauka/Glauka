@extends('layouts.app')
@section('content')
<section>
  <div class="container">
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
    @endif
  </div>
  <div class="espacio">
    <h1 class="fs-1 mb-2">Mis obras</h1>
    <a href="{{route('obras.create')}}" class="btn">Subir una obra</a>
  </div>

  <div class="espacio publicaciones">

    @if( $obras->isNotEmpty() )
    <h2 class="d-none">Cátalogo de obras</h2>
    <div class="row d-flex justify-content-start">
      @foreach ($obras as $obra)
      <div class="col-12 col-md-6 col-lg-4 mt-4">
        <div class="card m-auto">
          <div class="position-relative">
            @if($obra->imagen)
            <img src="{{asset('storage/imagenes/' . $obra->imagen) }}" class="card-img-top img-fluid rounded-1" alt="{{ $obra->nombre_obra }}">
            @else
            <img src="{{ asset('storage/imagenes/default/obraDefaultImg.jpg') }}" class="card-img-top img-fluid rounded-1" alt="{{ $obra->nombre_obra }}">
            @endif

            @php
            $primeraFuncion = $obra->primeraFuncionDisponible();
            @endphp
            @if($primeraFuncion)
            <p class="position-absolute top-0 start-0 fecha rounded-1 small">
              {{ \Carbon\Carbon::parse($primeraFuncion->fechaObra)->format('d/m/Y') }}
              {{ \Carbon\Carbon::parse($primeraFuncion->horaObra)->format('H:i') }}
            </p>
            @else
            <p class="position-absolute top-0 start-0 bg-danger-subtle fecha rounded-1 small">
              Obra cancelada</p>
            @endif
          </div>
          <div class="card-body">
            <h3 class="card-title fs-4 h-50 fw-bold text-truncate">{{ $obra->nombre_obra }}</h3>
            <p class="mb-1">
              <strong>Adaptaciones:</strong>
              @if($obra->adaptations->isNotEmpty())

              @foreach($obra->adaptations as $adaptacion)
              <span class="badge rounded-pill
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
                {{ $adaptacion->name }}
              </span>
              @endforeach
              @else
              <span class="badge rounded-pill text-bg-secondary">
                No especificado
              </span>
              @endif
            </p>
            <p class="card-text">${{$obra->precio}}</p>


            <div class="d-sm-flex">
              <div>
                <a href="{{ route('obras.show', $obra) }}" class="btn btn-primary mt-3">Ver</a>
                <a href="{{ route('obras.edit', $obra) }}" class="btn btn-secondary mt-3 me-1">Editar</a>
              </div>
              <div class="mt-3">
                @if(auth()->user()->rol === 'admin')

                @include('admin.partials.admin-delete-play')

                @elseif($obra->puedeEliminarseDefinitivamente())

                @include('productor.partials.delete-play')

                @else
                <button type="button" class="borrar btn btn-outline-danger rounded-pill" disabled title="No se puede eliminar porque aún hay stock disponible">
                  Eliminar
                </button>
                @endif
              </div>
            </div>


          </div>
        </div>
      </div>
      @endforeach
    </div>

    @else
    <div class="d-flex justify-content-center align-items-center">
      <div class="text-center">
        <i class="bi bi-ticket-perforated display-1 text-claro  opacity-25"></i>
        <p class="mt-4 text-claro">
          No tienes obras actualmente.
        </p>
      </div>
    </div>
    
    @endif
  </div>

</section>
@endsection