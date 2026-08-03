@extends('layouts.app')

@section('content')
<section class="espacio">
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
  <div id="carouselExampleAutoplaying" class="carousel slide" data-bs-ride="carousel">
    <div class="carousel-inner rounded-top-4">

      @foreach($bannerObras as $obra)
      <a href="{{ route('obras.show', $obra) }}">

        <div class="carousel-item  {{ $loop->first ? 'active' : '' }}">
        
          <div class="carousel-caption bottom-0 start-0 text-start rounded-2">
            <h2 class="fs-3 fw-bold">{{ $obra->nombre_obra }}</h2>
            <p class="fs-5 fw-semibold">Por: {{ $obra->productor->name_group }} </p>
          </div>
          <img src="{{ asset('storage/imagenes/' . $obra->imagen) }}" class="d-block w-100" style="height:300px; object-fit:cover;" alt="{{ $obra->nombre_obra }}">
        </div>
      </a>
      @endforeach
    </div>

    <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleAutoplaying" data-bs-slide="prev">
      <span class="carousel-control-prev-icon" aria-hidden="true"></span>
      <span class="visually-hidden">Previous</span>
    </button>
    <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleAutoplaying" data-bs-slide="next">
      <span class="carousel-control-next-icon" aria-hidden="true"></span>
      <span class="visually-hidden">Next</span>
    </button>
  </div>

  <div class="mt-5">
    <h1 class="d-none">Home</h1>
    <section class="mb-5">
      <h2 class="fs-1 border-bottom pb-2 mb-3 tipografia-young">Novedades</h2>
      <div class="row row-cols-1 row-cols-md-3 row-cols-lg-5 g-4">
        @forelse($novedades as $obra)
        @include('profile.partials.card-obra', ['obra' => $obra])
        @empty
        <div class="col-12 d-flex justify-content-center align-items-center w-100">
          <div class="text-center w-100 my-5">
            <i class="bi bi-heartbreak display-3 text-muted opacity-25"></i>
            <p class="mt-4 text-muted">
              No se encontraron obras para esta sección.
            </p>
          </div>
        </div>
        @endforelse
      </div>
    </section>

    <section class="mb-5">
      <h2 class="fs-2 border-bottom pb-2 mb-3 tipografia-young">Infantil</h2>
      <div class="row row-cols-1 row-cols-md-3 row-cols-lg-5 g-4">
        @forelse($infantiles as $obra)
        @include('profile.partials.card-obra', ['obra' => $obra])
        @empty
        <div class="col-12 d-flex justify-content-center align-items-center w-100">
          <div class="text-center w-100 my-5">
            <i class="bi bi-heartbreak display-3 text-muted opacity-25"></i>
            <p class="mt-4 text-muted">
              No se encontraron obras para esta sección.
            </p>
          </div>
        </div>
        @endforelse
      </div>
    </section>

    <section class="mb-5">
      <h2 class="fs-2 border-bottom pb-2 mb-3 tipografia-young">Para todo público</h2>
      <div class="row row-cols-1 row-cols-md-3 row-cols-lg-5 g-4">
        @forelse($todoPublico as $obra)
        @include('profile.partials.card-obra', ['obra' => $obra])
        @empty
        <div class="col-12 d-flex justify-content-center align-items-center w-100">
          <div class="text-center w-100 my-5">
            <i class="bi bi-heartbreak display-3 text-muted opacity-25"></i>
            <p class="mt-4 text-muted">
              No se encontraron obras para esta sección.
            </p>
          </div>
        </div>
        @endforelse
      </div>
    </section>

    <section class="mb-5">
      <h2 class="fs-2 border-bottom pb-2 mb-3 tipografia-young">Adultos</h2>
      <div class="row row-cols-1 row-cols-md-3 row-cols-lg-5 g-4">
        @forelse($adultos as $obra)
        @include('profile.partials.card-obra', ['obra' => $obra])
        @empty
        <div class="col-12 d-flex justify-content-center align-items-center w-100">
          <div class="text-center w-100 my-5">
            <i class="bi bi-heartbreak display-3 text-muted opacity-25"></i>
            <p class="mt-4 text-muted">
              No se encontraron obras para esta sección.
            </p>
          </div>
        </div>
        @endforelse
      </div>
    </section>
  </div>
</section>
@endsection