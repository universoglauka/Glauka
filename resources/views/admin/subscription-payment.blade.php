@extends('layouts.app')
@section('content')
<section>
  <div class="espacio">
    <div>
      <h1 class="fs-2 mb-2">Historial de pago de {{$sub->user->plan->nombre}}:</h1>
      <h2 class="fs-5"><strong>{{$sub->user->name}} - {{$sub->user->email}} - {{$sub->status}}</strong></h2>
    </div>

    <div class="mt-3">
      <h2>Inicio: {{$sub->starts_at}}</h2>
      <h2 class="pt-1">Expira: {{$sub->expires_at}}</h2>
    </div>

    <div class="mt-3">
      @foreach($payments as $payment)
      <div class="mt-1 mb-1">
        <p>Ticket: #{{ $payment->id}}</p>
        <p>
          {{ $payment->paid_at }} - ${{ $payment->amount }} - {{ $payment->status}}
        </p>
      </div>
      <hr>
      @endforeach
    </div>
    <div class="mt-4 paginador">
      {{ $payments->links() }}
    </div>
  </div>

</section>

@endsection