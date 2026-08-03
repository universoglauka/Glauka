@extends('layouts.app')
@section('content')
<section>
  <div class="container">
    @if (session('success'))
    <script>
      document.addEventListener('DOMContentLoaded', function() {
        Swal.fire({
          title: "Éxito",
          text: "{{session('success')}}",
          icon: "success",
          draggable: true
        });
      })
    </script>
    @endif
  </div>
  <div class="espacio">
    <h1 class="fs-1 mb-2">Todos los usuarios productores</h1>
    <a href="{{route('admin.crear-productor')}}" class="btn">Crear un usuario productor</a>

    <div class="d-flex justify-content-center">

      <div class="mt-4 table-responsive">

        <table class="table table-bordered align-middle">
          <thead>
            <tr>
              <th>Nombre de usuario</th>
              <th>Email</th>
              <th>Nombre de grupo</th>
              <th>Plan</th>
              <th>Cantidad de obras</th>
              <th>Acciones</th>
            </tr>
          </thead>

          <tbody>
            @foreach ($users as $usuario)
            <tr>
              <td>{{$usuario->user->name}}</td>
              <td>{{$usuario->user->email}}</td>
              <td>{{$usuario->name_group}}</td>
              <td>{{$usuario->user->plan->nombre}}</td>
              <td>{{$usuario->obras->count()}}</td>
              <td>
                <a href="{{ route('admin.profile.user', $usuario->user) }}" class="btn btn-primary mt-3">Ver</a>
                <a href="{{ route('admin.profile.edit', $usuario->user) }}" class="btn btn-primary mt-3">Editar</a>
                <button type="button" class="borrar btn btn-danger rounded-pill mt-3" data-bs-toggle="modal" data-bs-target="#eliminarProductor{{ $usuario->user->id }}">
                  Eliminar
                </button>
              </td>
            </tr>


            @endforeach
          </tbody>
        </table>

        @foreach ($users as $usuario)
        <div class="modal fade" id="eliminarProductor{{ $usuario->user->id }}" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="eliminarProductorLabel{{ $usuario->user->id }}" aria-hidden="true" role="dialog">
          <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
              <div class="modal-header">
                <div class="modal-title" id="eliminarProductorLabel{{ $usuario->user->id }}">
                  <h2 class="mb-1 fs-3"><strong>{{ $usuario->user->name}}</strong> </h2>
                  <p class="fs-5">¿Estás seguro de querer eliminar este usuario productor?</p>
                </div>
              </div>
              <div class="modal-body">
                <form method="POST" action="{{ route('admin.user.destroy', $usuario->user) }}">
                  @csrf
                  @method('DELETE')
                  <button class="borrar btn btn-danger m-auto" type="submit">Eliminar</button>
                  <button type="button" class="btn btn-primary" data-bs-dismiss="modal">Cerrar</button>
                </form>
                <p class="advertencia-eliminar pt-2">Esta acción no se puede deshacer.</p>
              </div>
            </div>
          </div>
        </div>

        @endforeach

      </div>
    </div>
  </div>

</section>
@endsection