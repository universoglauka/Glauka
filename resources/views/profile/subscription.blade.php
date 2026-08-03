@extends('layouts.app')
@section('title', 'Subscripción')
@section('content')
<section>

  <div>
    <div class="d-none d-sm-flex ms-3">
      <a href="{{ url()->previous() }}" class="volverBtn text-decoration-none">
        <i class="bi bi-arrow-left-circle-fill fs-2"></i>
      </a>
    </div>
    <div class="text-center pb-3">
      <h1 class="fs-1 border-bottom pb-2 pt-2 mb-3">Gluka Premium</h1>
      <h2 class="fs-2 ">Mejora tu plan y experiencia</h2>
      <span class="info">Ayuda a que la app siga brillando</span>
    </div>

    @if(auth()->user()->rol === "producer")

    <div>
      <div class="border-0 shadow-sm rounded-4 row  p-3">

        <div class="row d-flex justify-content-evenly">
          <div class="card tarjeta border rounded-4 col-md-4 zoom mt-4">
            <div class="p-3 card-body">
              <div class="text-center">
                <h2 class="card-title fs-5">Plan basico</h2>
                <p class="mb-3 fs-4">Gratuito</p>

              </div>
              <div class="d-flex flex-column">

                <ul class="align-self-center">
                  <li class="mt-2"><i class="bi bi-check-circle me-2"></i> Subir 3 fechas de funciones</li>
                  <li class="mt-2"><i class="bi bi-check-circle me-2"></i> Solo 7 días en los que puedes subir las funciones</li>
                  <li class="mt-2"><i class="bi bi-check-circle me-2"></i>Publicidad estandar</li>
                </ul>

              </div>


            </div>
            <a href="{{ route('profile') }}" class="btn mb-3">Continuar con plan base</a>
          </div>

          <div class="card tarjeta-oscura border rounded-4 col-md-4 zoom mt-4">
            <div class="p-3 card-body">
              <div class="text-center">
                <h2 class="card-title fs-5">Plan Premium</h2>
                @foreach($planes as $plan)
                @if($plan->id == 4)
                <p class="mb-3 fs-4">${{number_format( $plan->precio, 2)}}</p>
                @endif
                @endforeach
              </div>
              <ul class="">
                <li class="mt-2"><i class="bi bi-check-circle me-2"></i>Sube hasta 6 fechas de funciones</li>
                <li class="mt-2"><i class="bi bi-check-circle me-2"></i>Más transcurso de tiempo para que se realicen las obras</li>
                <li class="mt-2"><i class="bi bi-check-circle me-2"></i>Mayor publicidad en el sitio</li>
              </ul>
            </div>
            <a href="{{ route('checkout.premium') }}" class="btn mb-3">Conseguir premium</a>

          </div>
        </div>


      </div>
    </div>

    @else
    <div class="">
      <div class="border-0 shadow-sm rounded-4 row  p-3">

        <div class="row d-flex justify-content-evenly">
          <div class="card tarjeta border rounded-4 col-md-4 zoom mt-4">
            <div class="p-3 card-body">
              <div class="text-center">
                <h2 class="card-title fs-5">Plan basico</h2>
                <p class="mb-3 fs-4">Gratuito</p>

              </div>
              <div class="d-flex flex-column">

                <ul class="align-self-center">
                  <li class="mt-2"><i class="bi bi-check-circle me-2"></i> Sigue comprando entradas con normalidad como un usuario regular</li>
                </ul>

              </div>


            </div>
            <a href="{{ route('profile') }}" class="btn mb-3">Continuar con plan base</a>
          </div>

          <div class="card tarjeta-oscura border rounded-4 col-md-4 zoom mt-4">
            <div class="p-3 card-body">
              <div class="text-center">
                <h2 class="card-title fs-5">Plan Premium</h2>
                @foreach($planes as $plan)
                @if($plan->id == 3)
                <p class="mb-3 fs-4">${{number_format( $plan->precio, 2)}}</p>
                @endif
                @endforeach
              </div>
              <span>Puedes tener beneficios aleatorios en el mes como</span>
              <ul class="">
                <li class="mt-2"><i class="bi bi-check-circle me-2"></i>Descuentos especiales</li>
                <li class="mt-2"><i class="bi bi-check-circle me-2"></i>Entradas gratuitas a obras aleatorias</li>
                <li class="mt-2"><i class="bi bi-check-circle me-2"></i>Regalos en fisico a las funsiones que asistas</li>
              </ul>
            </div>
            <a href="{{ route('checkout.premium') }}" class="btn mb-3">Conseguir premium</a>

          </div>
        </div>


      </div>
    </div>
    @endif
  </div>
</section>

@endsection