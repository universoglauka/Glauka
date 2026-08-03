<x-guest-layout>

  <div class="tarjeta px-3 py-5 rounded-3 position-relative">
    <h1 class="encabezadoRegistro fs-5 text-center position-absolute top-0 start-50 translate-middle px-4 py-1 rounded-5">
      Registro de Productor
    </h1>
    @if(auth()->check() && auth()->user()->rol === "admin")
    <form method="POST" action="{{ route('admin.store-productor') }}" enctype="multipart/form-data">
      @else
      <form method="POST" action="{{ route('productor-register') }}" enctype="multipart/form-data">
        @endif
        @csrf

        <!-- Nombre -->
        <div>
          <x-input-label for="name" value="Nombre y apellido del representante" />
          <x-text-input id="name" name="name" type="text" class="mt-1 block w-full" :value="old('name')" required />
          <x-input-error :messages="$errors->get('name')" />
        </div>

        <!-- Nombre del grupo -->
        <div class="mt-4">
          <x-input-label for="name_group" value="Nombre del grupo (opcional)" />
          <x-text-input id="name_group" name="name_group" type="text" class="mt-1 block w-full" :value="old('name_group')" />
          <x-input-error :messages="$errors->get('name_group')" />
        </div>

        <!-- Icon del usuario -->
        <div class="mt-4">
          <x-input-label for="userIcon" :value="__('Foto de perfil')" />
          <x-text-input id="userIcon" class="block mt-1 w-full  form-control-auth" type="file" name="userIcon" accept="image/*" />
          <x-input-error :messages="$errors->get('userIcon')" class="mt-2" />
        </div>

        <!-- Email -->
        <div class="mt-4">
          <x-input-label for="email" value="Email" />
          <x-text-input id="email" name="email" type="email" class="mt-1 block w-full" :value="old('email')" required />
          <x-input-error :messages="$errors->get('email')" />
        </div>

        <!-- Descripción -->
        <div class="mt-4">
          <x-input-label for="description" value="Por favor, escribe en el cuadro de abajo un poco sobre usted/es" />
          <textarea id="description" name="description" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm"> {{old('description')}}</textarea>
          <x-input-error :messages="$errors->get('description')" />
        </div>

        <!-- Categoría -->
        <div class="mt-4">
          <x-input-label for="genre_id" value="Categoría" />
          <select id="genre_id" name="genre_id" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
            <option value="">Seleccionar...</option>

            @foreach($genres as $genre)
            <option value="{{ $genre->id }}">
              {{ $genre->name }}
            </option>
            @endforeach
          </select>
          <x-input-error :messages="$errors->get('genre_id')" />
        </div>

        <!-- Contraseña -->
        <div class="mt-4">
          <x-input-label for="password" value="Contraseña" />
          <x-text-input id="password" name="password" type="password" class="mt-1 block w-full" required />
          <x-input-error :messages="$errors->get('password')" />
        </div>

        <!-- Confirmar contraseña -->
        <div class="mt-4">
          <x-input-label for="password_confirmation" value="Confirmar contraseña" />
          <x-text-input id="password_confirmation" name="password_confirmation" type="password" class="mt-1 block w-full" required />
        </div>

        <!-- Botón de registro -->
        <div class="flex items-center justify-between mt-4">
          <a href="{{ route('register') }}" class="text-sm text-gray-600 hover:text-gray-900 underline">
            Regístrate aquí como usuario común
          </a>

          <x-primary-button class="ml-4 btn btn-warning">
            Registrarse
          </x-primary-button>
        </div>
      </form>
  </div>
</x-guest-layout>