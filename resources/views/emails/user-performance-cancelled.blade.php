<!DOCTYPE html>
<html lang="es">

<head>
  <meta charset="UTF-8">
</head>

<body>

  <h1>Hola, {{ $usuario->name }}.</h1>

  <h2>Lamentamos informarte que la función del {{ \Carbon\Carbon::parse($performance->fechaObra)->format('d/m/Y') }} a las {{ \Carbon\Carbon::parse($performance->horaObra)->format('H:i') }} hs de la obra <strong>"{{ $performance->obra->nombre_obra }}"</strong> fue cancelada.</h2>

  <p>Como adquiriste entradas para esta función, comenzaremos el proceso de reembolso correspondiente.</p>

  <p>De ser necesario, nos comunicaremos contigo para brindarte información adicional sobre el reintegro.</p>

  <p>Agradecemos tu comprensión y esperamos volver a verte en futuras funciones.</p>

  <p>Saludos,<br>Glauka.</p>

</body>

</html>