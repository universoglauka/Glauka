<div class="col-12 col-md-6 col-lg-4 mb-4">
  <div class="card h-100 shadow-sm">
    <div class="position-relative">
      @if($obra->imagen)
      <img src="{{ asset('storage/imagenes/' . $obra->imagen) }}" class="card-img-top rounded-1" alt="{{ $obra->nombre_obra }}">
      @else
      <img src="{{ asset('storage/imagenes/default/obraDefaultImg.jpg') }}" class="card-img-top rounded-1" alt="{{ $obra->nombre_obra }}">
      @endif

      @php
      $primeraFuncion = $obra->primeraFuncionDisponible();
      @endphp
      @if($primeraFuncion)
      <p class="position-absolute top-0 start-0 fecha rounded-1 small">
        {{ \Carbon\Carbon::parse($primeraFuncion->fechaObra)->format('d/m/Y') }}
        {{ \Carbon\Carbon::parse($primeraFuncion->horaObra)->format('H:i') }}
      </p>
      @endif
    </div>
    <div class="card-body d-flex flex-column">
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
      <p class="mt-auto mb-2">${{$obra->precio}}</p>
      <a href="{{ route('obras.show', $obra) }}" class="btn btn-outline-primary btn-sm w-50 m-auto">Ver detalles</a>
    </div>
  </div>
</div>