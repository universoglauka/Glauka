<x-guest-layout>
  <div class="tarjeta px-3 py-5 rounded-3 position-relative">
    <h1 class="encabezadoRegistro fs-5 text-center position-absolute top-0 start-50 translate-middle px-4 py-1 rounded-5">
      Contraseña
    </h1>
    <div class="mb-4 text-sm text-gray-600">
      {{ __('¿Olvidaste tu contraseña? No hay problema. Solo indícanos tu correo electrónico y te enviaremos un enlace para restablecerla y que puedas elegir una nueva.') }}
    </div>

    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <form method="POST" action="{{ route('password.email') }}">
      @csrf

      <!-- Email Address -->
      <div>
        <x-input-label for="email" :value="__('Email')" />
        <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required autofocus />
        <x-input-error :messages="$errors->get('email')" class="mt-2" />
      </div>

      <div class="flex items-center justify-end mt-4">
        <x-primary-button class="btn btn-warning">
          {{ __('Enviar') }}
        </x-primary-button>
      </div>
    </form>
  </div>
</x-guest-layout>