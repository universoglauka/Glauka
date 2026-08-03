<!DOCTYPE html>
<html lang="es">

<head>
  <meta charset="UTF-8">
</head>

<body>
  <h1>Hola {{ $performance->obra->productor->name_group ?? $performance->obra->productor->user->name }}</h1>

  @if ($motivo === 'decision_admin')
  <h2>Te informamos que la función del {{ \Carbon\Carbon::parse($performance->fechaObra)->format('d/m/Y') }} a las {{ \Carbon\Carbon::parse($performance->horaObra)->format('H:i') }} hs de tu obra <strong>"{{ $performance->obra->nombre_obra }}"</strong> fue cancelada por <strong>decisión del equipo de administración</strong>.</h2>
  @else
  <h2>Confirmamos que hemos procesado la solicitud para cancelar la función del {{ \Carbon\Carbon::parse($performance->fechaObra)->format('d/m/Y') }} a las {{ \Carbon\Carbon::parse($performance->horaObra)->format('H:i') }} hs de tu obra <strong>"{{ $performance->obra->nombre_obra }}"</strong>.</h2>
  @endif

  <p>Si la función contaba con entradas vendidas, el sistema ya las ha marcado como canceladas y los espectadores serán notificados para recibir el reembolso de sus tickets.</p>

  <p>Saludos,<br>Glauka.</p>
</body>

</html>