@extends('layouts.app')
@section('title', 'Pago')
@section('content')
<section class="espacio">
  <h1 class="fs-1 border-bottom pb-2 mb-3">Encuentra una nueva aventura</h1>

  <button class="btn btn-primary mb-3" type="button" data-bs-toggle="collapse" data-bs-target="#filtro" aria-expanded="false" aria-controls="filtro">
    <i class="bi bi-sliders2 fs-5"></i>
  </button>
  <div class="collapse mb-3" id="filtro">
    <div class="card">
      <div class="card-body border-0 rounded-4 px-3 py-4">
        <form action="{{ route('catalog') }}" method="GET" class="row g-2 align-items-center">
          @csrf
          <div class="row">
            <div class="col-12 col-md-4">
              <label class="fs-5 fw-bold text-secondary mb-2 d-block">
                Géneros
              </label>

              @foreach($genres as $genre)
              <div class="form-check mb-2">
                <input
                  class="form-check-input me-1"
                  type="checkbox"
                  name="genres[]"
                  value="{{ $genre->id }}"
                  id="genre_{{ $genre->id }}"
                  {{ in_array($genre->id, request('genres', [])) ? 'checked' : '' }}>

                <label
                  class="form-check-label"
                  for="genre_{{ $genre->id }}">
                  {{ $genre->name }}
                </label>
              </div>
              @endforeach
            </div>

            <div class="col-12 col-md-4">
              <label class="fs-5 fw-bold text-secondary mb-2 d-block">
                Adaptaciones
              </label>

              @foreach($adaptations as $adaptation)
              <div class="form-check mb-2">
                <input
                  class="form-check-input me-1"
                  type="checkbox"
                  name="adaptations[]"
                  value="{{ $adaptation->id }}"
                  id="adaptation_{{ $adaptation->id }}"
                  {{ in_array($adaptation->id, request('adaptations', [])) ? 'checked' : '' }}>

                <label
                  class="form-check-label"
                  for="adaptation_{{ $adaptation->id }}">
                  {{ $adaptation->name }}
                </label>
              </div>
              @endforeach
            </div>

            <div class="col-12 col-md-4">
              <label class="fs-5 fw-bold text-secondary mb-2 d-block">
                Clasificación
              </label>
              <select name="clasificacion" class="form-select">
                <option value="">Todas las clasificaciones</option>

                @foreach($clasificaciones as $clasificacion)
                <option
                  value="{{ $clasificacion }}"
                  {{ request('clasificacion') == $clasificacion ? 'selected' : '' }}>
                  {{ $clasificacion }}
                </option>
                @endforeach
              </select>
            </div>

            <div class="col-12 col-md-auto d-flex gap-2 mt-3">
              <button type="submit" class="btn btn-primary rounded-pill px-4">
                Filtrar
              </button>

              @if(request('genres') || request('adaptations') || request('clasificacion'))
              <a href="{{ route('catalog') }}" class="borrar btn btn-outline-danger rounded-pill" title="Limpiar filtros">
                Borrar filtros
              </a>
              @endif
            </div>
          </div>


        </form>
      </div>
    </div>
  </div>

  <div class="row">
    <h2 class="d-none">Cartelera</h2>
    @forelse($obras as $obra)
    @include('profile.partials.card-obra', ['obra' => $obra])
    @empty
    <div class="col-12">
      <div class="alert alert-warning text-center py-5 rounded-4">
        <i class="bi bi-search display-1 mb-3 d-block opacity-50"></i>
        <h4>No encontramos obras con esos filtros.</h4>
        <a href="{{ route('catalog') }}" class="btn btn-outline-dark mt-3 rounded-pill">
          Ver todo el catálogo
        </a>
      </div>
    </div>
    @endforelse
  </div>


  {{ $obras->links() }}
</section>
@endsection