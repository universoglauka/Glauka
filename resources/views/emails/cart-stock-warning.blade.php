<!DOCTYPE html>
<html>

<head>
  <meta charset="utf-8">
</head>

<body>

  <h1>¡Atención!</h1>

  <p>
    Las entradas que agregaste a tu carrito para la obra
    <strong>{{ $cartItem->obra->nombre_obra }}</strong>
    están por agotarse.
  </p>

  <p>
    Actualmente quedan
    <strong>{{ $performance->stock }}</strong>
    entradas disponibles.
  </p>

  <p>
    Tú tienes reservadas virtualmente
    <strong>{{ $cartItem->cantidad }}</strong>
    entradas en tu carrito.
  </p>

  <p>
    Si deseas asistir a la función del
    <strong>{{ \Carbon\Carbon::parse($performance->fechaObra)->format('d/m/Y') }}</strong>
    a las
    <strong>{{ \Carbon\Carbon::parse($performance->horaObra)->format('H:i') }}hs</strong>,
    te recomendamos finalizar la compra pronto.
  </p>

  <p>
    ¡Gracias por utilizar Glauka!
  </p>

</body>

</html>