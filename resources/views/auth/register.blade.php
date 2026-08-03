<x-guest-layout>
  <div class="tarjeta px-3 py-4 rounded-3 position-relative">
    <h1 class="encabezadoRegistro fs-5 text-center position-absolute top-0 start-50 translate-middle px-4 py-1 rounded-5">
      Registro
    </h1>
    @if(auth()->check() && auth()->user()->rol === "admin")
    <form method="POST" action="{{ route('admin.store-usuario') }}" enctype="multipart/form-data">
      @else
      <form method="POST" action="{{ route('register') }}" enctype="multipart/form-data">
        @endif
        @csrf

        @if(!(auth()->check()))
        <a href="{{ route('productor-register') }}" class="text-sm text-gray-600 hover:text-gray-900 underline">
          Regístrate aquí como productor
        </a>
        @endif
        <!-- Name -->
        <div class="mt-3">
          <x-input-label for="name" :value="__('Nombre')" />
          <x-text-input id="name" class="block mt-1 w-full" type="text" name="name" :value="old('name')" required autocomplete="name" />
          <x-input-error :messages="$errors->get('name')" class="mt-2" />
        </div>

        <!-- Nickname -->
        <div class="mt-4">
          <x-input-label for="nicknameUser" :value="__('Nombre de usuario')" />
          <x-text-input id="nicknameUser" class="block mt-1 w-full" type="text" name="nicknameUser" :value="old('nicknameUser')" required />
          <x-input-error :messages="$errors->get('nicknameUser')" class="mt-2" />
        </div>

        <!-- Email Address -->
        <div class="mt-4">
          <x-input-label for="email" :value="__('Email')" />
          <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required autocomplete="username" />
          <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>


        <!-- User icon -->
        <div class="mt-4">
          <x-input-label for="userIcon" :value="__('Foto de perfil')" />
          <x-text-input id="userIcon" class="block mt-1 w-full form-control-auth" type="file" name="userIcon" accept="image/*" />
          <x-input-error :messages="$errors->get('userIcon')" class="mt-2" />
        </div>

        <!-- Password -->
        <div class="mt-4">
          <x-input-label for="password" :value="__('Contraseña')" />

          <x-text-input id="password" class="block mt-1 w-full"
            type="password"
            name="password"
            required autocomplete="new-password" />

          <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <!-- Confirm Password -->
        <div class="mt-4">
          <x-input-label for="password_confirmation" :value="__('Confirmar contraseña')" />

          <x-text-input id="password_confirmation" class="block mt-1 w-full"
            type="password"
            name="password_confirmation" required autocomplete="new-password" />

          <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
        </div>

        <div class="flex items-center justify-between mt-4">
          <a class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500" href="{{ route('login') }}">
            {{ __('¿Ya tienes una cuenta?') }}
          </a>

          <x-primary-button class="ms-4 btn btn-warning">
            {{ __('Registrarse') }}
          </x-primary-button>
        </div>
      </form>
  </div>
</x-guest-layout>