<div class="pt-4 d-flex justify-content-center align-items-center">

  <div class="card position-relative tarjeta-oscura border rounded-4" style="width: 35rem;">
    <div class="card-body">
      <img src="{{ asset('storage/imagenes/userIcon/GlaukaIcon.png') }}" alt="Glauka icon" class="position-absolute perfil-avatar top-0 start-50 translate-middle">
      <div class="mt-5">
        <h2 class="text-center fs-4">{{$plan->nombre}}</h2>
        <p class="text-center fs-2"> <strong> ${{ number_format( $plan->precio, 2) }} </strong></p>
        <p class="">Con la mejora de tu plan puedes incluir beneficios como</p>
        <ul class="fs-5">
          @if(auth()->user()->rol === "producer")
          <li class="mt-2"><i class="bi bi-check-circle me-2"></i>Sube hasta 6 fechas de funciones</li>
          <li class="mt-2"><i class="bi bi-check-circle me-2"></i>Más transcurso de tiempo para que se realicen las obras</li>
          <li class="mt-2"><i class="bi bi-check-circle me-2"></i>Mayor publicidad en el sitio pra más visibilidad</li>
          @else
          <li class="mt-2"><i class="bi bi-check-circle me-2"></i>Descuentos especiales</li>
          <li class="mt-2"><i class="bi bi-check-circle me-2"></i>Entradas gratuitas a obras aleatorias</li>
          <li class="mt-2"><i class="bi bi-check-circle me-2"></i>Regalos en fisico a las funsiones que asistas</li>
          @endif
        </ul>
      </div>
    </div>

  </div>
</div>