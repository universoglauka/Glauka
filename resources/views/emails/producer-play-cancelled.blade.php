<!DOCTYPE html>
<html lang="es">

<head>
  <meta charset="UTF-8">
</head>

<body>
  <h1>Hola {{ $obra->productor->name_group ?? $obra->productor->user->name }}</h1>

  @if ($motivo === 'decision_admin')
  <h2>Te informamos que tu obra <strong>"{{ $obra->nombre_obra }}"</strong> fue cancelada por <strong>decisión del equipo de administración</strong>.</h2>
  @else
  <h2>Confirmamos que hemos procesado la solicitud para cancelar tu obra <strong>"{{ $obra->nombre_obra }}"</strong>.</h2>
  @endif

  <p>Si la obra contaba con entradas vendidas, el sistema ya las ha marcado como canceladas y los espectadores serán notificados para recibir el reembolso de sus tickets.</p>

  <p>Saludos,<br>Glauka.</p>
</body>

</html>