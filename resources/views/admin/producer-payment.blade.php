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

    <div class="rounded-4">
      <div class="tab-content" id="profileTabsContent">
        <div class="tab-pane fade show active" id="users" role="tabpanel">

          <h1 class="fs-1 mb-2">Lista de pago a los productores</h1>
          <span>Aquí puedes organizar los pagos que se deben a los productores por sus obras luego de que se realizan</span>

          <div class="row">
            <div class="col-12 m-auto">
              <div class="d-flex justify-content-center">
                <div class="mt-4 table-responsive w-100">
                  <table class="table table-bordered align-middle">
                    <thead>
                      <tr>
                        <th>Fecha</th>
                        <th>Función</th>
                        <th>Responsable</th>
                        <th>Estado</th>
                        <th>Monto</th>
                        <th>Pago</th>
                        <th></th>
                      </tr>
                    </thead>

                    <tbody>
                      @foreach ($performances as $performance)
                      <tr>
                        <td>{{$performance->fechaObra}}</td>
                        <td>{{$performance->obra->nombre_obra}}</td>
                        <td>{{$performance->obra->productor->user->name}}
                          <i class="bi bi-eye-fill ojo-datos" data-bs-toggle="modal" data-bs-target="#datos{{ $performance->obra->productor->user_id }}"></i>
                          <!-- <button class="btn rounded-pill mt-3 ms-3" data-bs-toggle="modal" data-bs-target="#datos{{ $performance->obra->productor->user_id }}"> Ver </button> -->
                        </td>
                        @if($performance->cancelado)
                        <td class="bg-danger-subtle  border border-danger-subtle">
                          Cancelada
                        </td>
                        @else

                        <td class="bg-success-subtle  border border-success-subtle">
                          Activa
                        </td>
                        @endif

                        <td>${{$performance->ticketdetalles->sum('subtotal')}}</td>
                        <td>
                          <form method="POST" action="{{ route('admin.producer-payment.changeStatus', $performance) }}">
                            @csrf
                            @method('PATCH')

                            @if($performance->estado_pago == 'pendiente')
                            <button class="btn btn-primary btnYellow" type="submit">
                              Pendiente
                            </button>
                            @else
                            <button class="btn btn-primary btnGreen" type="submit">
                              Realizado
                            </button>
                            @endif
                          </form>
                        </td>
                        <td>
                          @if($performance->fechaObra < now()->toDateString()
                            && $performance->estado_pago == 'realizado')

                            <form method="POST" action="{{ route('admin.producer-payment.hide', $performance) }}">
                              @csrf
                              @method('PATCH')

                              <button type="submit" class="btn borrar btn-danger">
                                X
                              </button>
                            </form>
                            @else
                            <button type="button" class="btn btn-danger" disabled>
                              X
                            </button>
                            @endif
                        </td>
                      </tr>

                      @endforeach
                    </tbody>
                  </table>
                  <div class="modal fade" id="datos{{ $performance->obra->productor->user_id }}" tabindex="-1" aria-labelledby="datos{{  $performance->obra->productor->user_id }}" aria-hidden="true" role="dialog">
                    <div class="modal-dialog modal-dialog-centered">
                      <div class="modal-content">
                        <div class="modal-header">
                          <h2 class="modal-title fs-5" id="datos">Datos de pago de {{$performance->obra->productor->user->name}}</h2>
                          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                          <p class="fs-5">Alias: <strong>{{$performance->obra->productor->alias}}</strong></p>
                          <p class="fs-5">Titular: <strong>{{$performance->obra->productor->account_holder}}</strong></p>
                        </div>
                        <div class="modal-footer">
                          <button type="button" class="btn" data-bs-dismiss="modal">Cerrar</button>
                        </div>
                      </div>
                    </div>
                  </div>

                </div>
              </div>
            </div>
          </div>

        </div>
      </div>
    </div>
  </div>
</section>
@endsection