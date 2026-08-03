@extends('layouts.app')
@section('content')

<div>
  <div class="d-flex align-items-center flex-column mt-3">
    <img src="{{asset('storage/imagenes/userIcon/GlaukaIcon.png')}}" alt="logotipo de la marca" class="h-20">
    <h1 class="fs-2">¿En qué puede ayudarte Glauka?</h1>

    <div class="alert alert-warning text-center py-2 mt-3 rounded-4">
      <p class="alert-heading">¿Necesitas comunicarte con nosotros? Escribenos a nuestro gmail "<strong>universoglauka@gmail.com</strong>"</p>
    </div>
  </div>

  <!-- Usuarios normales-->
  <div id="preguntasUsuario" class="mt-4 container">
    <h2 class="fs-3 mb-4">Preguntas de usuarios</h2>

    <div class="row row-col-2 mb-3 g-3 d-flex justify-content-evenly position-relative">
      <x-question
        title="¿Cómo puedo comprar entradas?"
        message="¡Es muy simple! desde la pestaña 'inicio' o 'catálogo' selecciona la obra de tu preferencia y ahí podrás elegir entre las fechas disponibles y la cantidad deseada.
                Luego ve a tu carrito, presiona 'continuar' podras acceder a las opciones de pago." />

      <x-question
        title="¿Cómo recibo mis entradas?"
        message="Cuando se procesa tu pago, recibirás un correo electrónico donde podrás acceder a tus entradas. También podras encontrarlas en la sección 'Mis entradas' en tu perfil que se encuentrada en la esquina derecha superior del sitio del sitio donde aparece tu nombre." />

      <x-question
        title="¿Puedo cancelar mi compra de entradas?"
        message="Glauka no es productor ni organizador. Vendemos las entradas de productores de cada evento, por lo que quedan sujetas a sus condiciones." />

      <x-question
        title="¿Qué pasa si pierdo o roban mis entradas?"
        message="Una vez compradas, las entradas son tu responsabilidad. Guardalas bien ya que no serán reemplazadas en caso de pérdida o robo. Si alguien más utiliza tus entradas, no podrás acceder al evento." />

      <x-question
        title="¿Qué debo presentar al momento de Control de Acceso?"
        message="Para ingresar al evento, debes presentar tu entrada impresa o mostrarlo desde el sitio web donde muestra la validación de compra." />

      <x-question
        title="¿Cuales son las formas de pago disponible?"
        message="Por el momento solo contamos con MercadoPago." />
    </div>

  </div>

  <!-- Usuarios productores -->
  <div id="preguntasProductores" class="container my-5">
    <h2 class="fs-3 mb-4">Preguntas de productores</h2>

    <div class="row row-col-2  g-3 d-flex justify-content-evenly position-relative">
      <x-question
        title="¿Qué es una obra privada?"
        message="Este tipo de obras solo pueden ser vistas por quienes tengan el enlace compartido. Es una buena opción si quieres controlar quién puede acceder y comprar entradas para las funciones." />

      <x-question
        title="¿Qué es una función virtual?"
        message="Al crear una función puedes indicar que se realizará de forma online, utilizando plataformas como Google Meet, Zoom u otra similar." />

      <x-question
        title="¿Cómo organizo una función virtual?"
        message="Programa la reunión en la plataforma que prefieras, como Google Meet o Zoom, y pega el enlace en el campo correspondiente al crear la función. El día del evento podrás consultar el listado de asistentes, junto con los correos electrónicos registrados en cada entrada, para facilitar el control de acceso." />

      <x-question
        title="¿Puedo combinar funciones virtuales y presenciales?"
        message="¡Puedes ofrecer ambas modalidades dentro de la misma obra! Los asistentes podrán elegir la función presencial o virtual que prefieran al momento de comprar su entrada." />

      <x-question
        title="¿Puedo eliminar una obra después de publicarla?"
        message="Puedes eliminarla siempre que no existan entradas vendidas. Si ya hay compras registradas y necesitas eliminar la obra o cancelarla, comunícate con nosotros para ayudarte." />

      <x-question
        title="¿Puedo cancelar una función después de publicarla?"
        message="No es posible, pero si necesitas cancelar alguna de las funciones por algún inconveniente, no dudes en contactarnos." />


      <x-question
        title="¿Puedo editar una obra después de publicarla?"
        message="¡Sí! Puedes modificar la mayoría de los datos en cualquier momento. Sin embargo, por motivos de seguridad no es posible cambiar la fecha ni el horario de una función ya publicada. Si necesitas hacerlo, ponte en contacto con nosotros." />

      <x-question
        title="¿Cómo se controla el ingreso de los asistentes?"
        message="Cada entrada cuenta con un código único de validación. Desde el listado de funciones podrás acceder a la lista de presentismo, donde encontrarás los códigos de cada asistente y así verificar rápidamente si la entrada ya fue utilizada. En las funciones virtuales también se muestran los correos electrónicos asociados a cada entrada." />

      <x-question
        title="¿Para qué sirve la sección de Grupos de ensayo?"
        message="Esta sección permite organizar grupos para castings, ensayos o cualquier otra actividad relacionada con la producción teatral, facilitando la convocatoria y la comunicación con los participantes." />

      <x-question
        title="¿Qué sucede con el dinero recaudado?"
        message="Por seguridad, el dinero de las entradas vendidas por función permanece retenido hasta que finaliza la misma. Una vez realizada la presentación, nos comunicaremos con el productor responsable para coordinar la transferencia del 100% de lo recaudado." />
    </div>

  </div>

</div>

@endsection