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

          <h1 class="fs-1 mb-2">Todos los usuarios premium</h1>

          <div class="row">
            <div class="col-12 m-auto">
              <div class="d-flex justify-content-center">
                <div class="mt-4 table-responsive w-100">
                  <table class="table table-bordered align-middle">
                    <thead>
                      <tr>
                        <th>Usuario</th>
                        <th>Email</th>
                        <th>Comienza</th>
                        <th>Expira</th>
                        <th>Estado</th>
                        <th>Acciones</th>
                      </tr>
                    </thead>

                    <tbody>
                      @foreach ($subcriptions as $sub)
                      <tr>
                        <td>{{$sub->user->rol}}</td>
                        <td>{{$sub->user->email}}</td>
                        <td>{{$sub->starts_at}}</td>
                        <td>{{$sub->expires_at}}</td>
                        <td>{{$sub->status}}</td>
                        <td>
                          <button class="btn rounded-pill mt-3 ms-3" data-bs-toggle="modal" data-bs-target="#paymentHistory{{ $sub->id }}"> Ver historial de pago </button>
                        </td>
                      </tr>
                      @endforeach
                    </tbody>
                  </table>

                  @foreach ($subcriptions as $sub)
                  <div class="modal fade" id="paymentHistory{{ $sub->id }}" tabindex="-1" aria-labelledby="paymentHistory{{ $sub->id }}" aria-hidden="true" role="dialog">
                    <div class="modal-dialog modal-dialog-centered">
                      <div class="modal-content">
                        <div class="modal-header">
                          <h2 class="modal-title fs-5" id="paymentHistory">Detalle de Pago de {{$sub->user->name}}</h2>
                          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                          @foreach($sub->payments as $payment)
                          <div class="mt-2 mb-2">
                            <p>Ticket: #{{ $payment->id}}</p>
                            <p>
                              {{ $payment->paid_at }} - ${{ $payment->amount }}
                            </p>
                            <p> {{ $payment->status }} </p>
                          </div>
                          <hr>
                          @endforeach
                        </div>
                        <div class="modal-footer">
                          <a href="{{ route('admin.subscription-payment', $sub) }}" class="btn btn-outline-primary btn-sm w-50 m-auto">Ver todo</a>
                          <button type="button" class="btn" data-bs-dismiss="modal">Cerrar</button>
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
      </div>
    </div>
  </div>
</section>
@endsection