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
          id="obras-tab"
          data-bs-toggle="tab"
          data-bs-target="#obras"
          type="button"
          role="tab">
          Obras
        </button>
      </li>
      <li class="btn btn-primary mb-1">
        <button
          class="nav-link"
          id="genres-tab"
          data-bs-toggle="tab"
          data-bs-target="#genres"
          type="button"
          role="tab">
          Géneros
        </button>
      </li>
    </ul>


    <div class="pt-3 rounded-4">
      <div class="tab-content" id="profileTabsContent">
        <div class="tab-pane fade show active" id="obras" role="tabpanel">

          <h1 class="fs-1 mb-2">Todas las obras</h1>
          <a href="{{route('obras.create')}}" class="btn btn-primary">Subir una obra</a>

          <div class="row">
            <div class="col-12 m-auto">
              <div class="d-flex justify-content-center">
                <div class="mt-4 table-responsive w-100">
                  <table class="table table-bordered align-middle">
                    <thead>
                      <tr>
                        <th>Nombre</th>
                        <th>Productor</th>
                        <th>Clasificación</th>
                        <th>Precio</th>
                        <th>Recaudado</th>
                        <th>Stock</th>
                        <th>Acciones</th>
                      </tr>
                    </thead>

                    <tbody>
                      @foreach ($obras as $obra)
                      <tr>
                        <td>
                          <h2 class="fs-6">{{ $obra->nombre_obra }}</h2>
                        </td>
                        <td>{{ $obra->productor->name_group }}</td>
                        <td>{{ $obra->clasificacion }}</td>
                        <td>${{ $obra->precio }}</td>
                        <td>{{ $obra->ticketdetalles->sum('subtotal') }}</td>
                        <td>{{ $obra->performance->sum('stock') }}</td>
                        <td>
                          <a href="{{ route('obras.show', $obra) }}" class="btn btn-primary my-1">Ver</a>
                          <a href="{{ route('obras.edit', $obra) }}" class="btn btn-primary my-1">Editar</a>

                          @if($obra->cancelado)
                          <button class="btn borrar btn-outline-danger" disabled>
                            Cancelada
                          </button>
                          @else
                          @include('admin.partials.admin-cancel-play')
                          @endif

                          @if($obra->eliminado)
                          <button class="btn borrar btn-outline-danger" disabled>
                            Eliminada
                          </button>
                          @else
                          @include('admin.partials.admin-delete-play')
                          @endif
                        </td>
                      </tr>
                      @endforeach
                    </tbody>
                  </table>
                </div>
              </div>
              <div class="mt-4 paginador">
                {{ $obras->links() }}
              </div>

            </div>
          </div>
        </div>

        <div class="tab-pane fade" id="genres" role="tabpanel">

          <h2 class="fs-1 mb-2">Géneros teatrales</h2>
          @include('admin.genres.create')
          <div class="row">
            @include('admin.genres.index')
          </div>
        </div>
      </div>
    </div>
  </div>
</section>
@endsection