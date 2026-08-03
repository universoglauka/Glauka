@extends('layouts.app')

@section('content')

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

<div class="espacio py-5">
  <x-slot name="header">
    <p class="font-semibold text-xl text-gray-800 leading-tight">
      {{ __('Perfil') }}
    </p>
  </x-slot>

  <div class="d-flex align-items-center mb-5 ml-2">
    <div class="d-flex justify-content-between align-items-center" style="height: 4rem;">
      <div class="d-flex align-items-center">
        <div class="d-none d-sm-flex">
          <a href="{{ url()->previous() }}" class="volverBtn text-decoration-none">
            <i class="bi bi-arrow-left-circle-fill fs-2"></i>
          </a>
        </div>
      </div>
      <h1 class="fs-1 ms-3">Editar perfil</h1>
    </div>
  </div>
  <div class="row justify-content-center d-block">
    <div class="editDiv d-block col-12 col-md-9 col-lg-6 m-auto">
      @include('profile.partials.update-profile-information-form')
    </div>

    @if($user->rol == "producer" && $user->productor)
    <div class="editDiv d-block col-12 col-md-9 col-lg-6 m-auto">
      @include('profile.partials.update-producer')
    </div>
    @endif

    <div class="editDiv d-block col-12 col-md-9 col-lg-6 m-auto">
      @include('profile.partials.update-password-form')
    </div>

    @if(auth()->user()->rol !== "admin")
    <div class="editDiv d-block col-12 col-md-9 col-lg-6 m-auto">
      @include('profile.partials.delete-user-form')
    </div>
    @endif

  </div>
</div>
@endsection