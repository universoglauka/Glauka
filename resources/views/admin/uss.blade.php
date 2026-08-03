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
    <ul id="profileTabs" role="tablist">
      <li class="btn btn-primary mb-1">
        <button
          class="nav-link active"
          id="users-tab"
          data-bs-toggle="tab"
          data-bs-target="#users"
          type="button"
          role="tab">
          Usuarios
        </button>
      </li>
      <li class="btn btn-primary mb-1">
        <button
          class="nav-link"
          id="labels-tab"
          data-bs-toggle="tab"
          data-bs-target="#labels"
          type="button"
          role="tab">
          Etiquetas
        </button>
      </li>
    </ul>

    <div class="pt-3 rounded-4">
      <div class="tab-content" id="profileTabsContent">
        <div class="tab-pane fade show active" id="users" role="tabpanel">

          <h1 class="fs-1 mb-2">Todos los usuarios normales</h1>
          <a href="{{route('admin.crear-usuario')}}" class="btn">Crear un usuario común</a>

          <div class="row">
            <div class="col-12 m-auto">
              <div class="d-flex justify-content-center">
                <div class="mt-4 table-responsive w-100">
                  <table class="table table-bordered align-middle">
                    <thead>
                      <tr>
                        <th>Nombre</th>
                        <th>Email</th>
                        <th>Tickets</th>
                        <th>Plan</th>
                        <th>Acciones</th>
                      </tr>
                    </thead>

                    <tbody>
                      @foreach ($users as $usuario)
                      <tr>
                        <td>{{$usuario->name}}</td>
                        <td>{{$usuario->email}}</td>
                        <td>{{$usuario->tickets->count()}}</td>
                        <td>{{$usuario->plan->nombre}}</td>
                        <td>
                          <a href="{{ route('admin.profile.user', $usuario) }}" class="btn btn-primary mt-3">Ver</a>
                          <a href="{{ route('admin.profile.edit', $usuario) }}" class="btn btn-primary mt-3">Editar</a>
                          <button type="button" class="borrar btn btn-danger rounded-pill mt-3" data-bs-toggle="modal" data-bs-target="#eliminarUsuario{{ $usuario->id }}">
                            Eliminar
                          </button>
                        </td>
                      </tr>
                      @endforeach
                    </tbody>
                  </table>

                  @foreach ($users as $usuario)
                  <div class="modal fade" id="eliminarUsuario{{ $usuario->id }}" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="eliminarUsuarioLabel{{ $usuario->id }}" aria-hidden="true" role="dialog">
                    <div class="modal-dialog modal-dialog-centered">
                      <div class="modal-content">
                        <div class="modal-header">
                          <div class="modal-title">
                            <h2 class="mb-1 fs-3" id="eliminarUsuarioLabel{{ $usuario->id }}"><strong>{{ $usuario->name}}</strong></h2>
                            <p class="fs-5">¿Estás seguro de querer eliminar este usuario?</p>
                          </div>
                        </div>
                        <div class="modal-body">
                          <form method="POST" action="{{ route('admin.user.destroy', $usuario) }}">
                            @csrf
                            @method('DELETE')
                            <button class="borrar btn btn-danger  m-auto" type="submit">Eliminar</button>
                            <button type="button" class="btn btn-primary" data-bs-dismiss="modal">Cerrar</button>
                          </form>
                          <p class="advertencia-eliminar">Esta acción no se puede deshacer.</p>
                        </div>
                      </div>
                    </div>
                  </div>
                  @endforeach
                </div>
              </div>
            </div>
          </div>
        </div>

        <div class="tab-pane fade" id="labels" role="tabpanel">
          <h2 class="fs-1 mb-2">Etiquetas para usuarios</h2>
          @include('admin.labels.create')
          <div class="row">
            @include('admin.labels.index')
          </div>
        </div>

        <div class="mt-4 paginador">
          {{ $users->links() }}
        </div>
      </div>
    </div>
  </div>
</section>
@endsection