<section class="tarjeta px-3 py-5 rounded-3 position-relative">

  <div>
    <h2 class="encabezadoRegistro fs-5 text-center position-absolute top-0 start-50 translate-middle px-4 py-2 rounded-5">
      {{ __('Información de perfil') }}
    </h2>

    <p class="mt-1 p-2">
      {{ __("Actualiza la información de tu perfil y correo.") }}
    </p>
  </div>


  <form id="send-verification" method="post" action="{{ route('verification.send') }}">
    @csrf
  </form>

  <form method="post" action="{{ isset($user) && auth()->user()->rol === 'admin' 
                                ? route('admin.profile.update', $user)
                                : route('profile.update') }}"
    enctype="multipart/form-data" class="mt-6 space-y-6">

    @csrf
    @method('patch')

    <div>
      <x-input-label for="name" :value="__('Nombre')" />
      <x-text-input id="name" name="name" type="text" class="mt-1 block w-full" :value="old('name', $user->name)" required autofocus autocomplete="name" />
      <x-input-error class="mt-2" :messages="$errors->get('name')" />
    </div>

    @if($user->rol === 'user')
    <div class="mt-4">
      <x-input-label for="nicknameUser" :value="__('Nombre de usuario')" />
      <x-text-input id="nicknameUser" name="nicknameUser" type="text" class="mt-1 block w-full" :value="old('nicknameUser', $user->nicknameUser)" />
      <x-input-error class="mt-2" :messages="$errors->get('nicknameUser')" />
    </div>
    @endif

    <div class="mt-4">
      <x-input-label for="userIcon" :value="__('Foto de perfil')" />
      <input id="userIcon" name="userIcon" type="file" class="mt-1 form-control">
      <x-input-error :messages="$errors->get('userIcon')" class="mt-2" />
    </div>


    <div class="mt-4">
      <x-input-label for="descriptionProfile" :value="__('Descripción')" />
      @if($user->rol === 'producer')
      <p class="text-sm text-muted">
        {{ __('Puedes añadir las redes sociales o información de contacto de la cuenta aquí.') }}
      </p>
      @endif
      <textarea id="descriptionProfile" name="description" class="form-control mt-1" rows="5">{{ old('description', $user->description) }}</textarea>
      <x-input-error class="mt-2" :messages="$errors->get('description')" />
    </div>


    @if($user->rol === 'user')
    <div class="mt-4">
      <x-input-label :value="__('Etiquetas')" />

      <p class="text-sm text-muted mb-2">
        Puedes seleccionar hasta 3 etiquetas.
      </p>

      @foreach($labels as $label)
      <div class="form-check">
        <input class="form-check-input" type="checkbox" name="labels[]" value="{{ $label->id }}" id="label_{{ $label->id }}"
          {{ in_array( $label->id, old( 'labels', $user->labels->pluck('id')->toArray() )) ? 'checked' : '' }}>
        <label class="form-check-label" for="label_{{ $label->id }}">
          {{ $label->name }}
        </label>
      </div>
      @endforeach

      <x-input-error class="mt-2" :messages="$errors->get('labels')" />
    </div>
    @endif

    <div class="mt-4">
      <x-input-label for="email" :value="__('Email')" />
      <x-text-input id="email" name="email" type="email" class="mt-1 block w-full" :value="old('email', $user->email)" required autocomplete="username" />
      <x-input-error class="mt-2" :messages="$errors->get('email')" />

      @if ($user instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && ! $user->hasVerifiedEmail())
      <div>
        <p class="text-sm mt-2 text-gray-800">
          {{ __('Tu dirección de correo electrónico no está verificada.') }}

          <button form="send-verification" class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
            {{ __('Haz clic aquí para reenviar el correo electrónico de verificación.') }}
          </button>
        </p>

        @if (session('status') === 'verification-link-sent')
        <p class="mt-2 font-medium text-sm text-green-600">
          {{ __('Se ha enviado un nuevo enlace de verificación a su dirección de correo electrónico.') }}
        </p>
        @endif
      </div>
      @endif
    </div>



    <div class="flex items-center gap-4">
      <x-primary-button>{{ __('Guardar') }}</x-primary-button>

      @if (session('status') === 'profile-updated')
      <p
        x-data="{ show: true }"
        x-show="show"
        x-transition
        x-init="setTimeout(() => show = false, 2000)"
        class="text-sm text-gray-600">{{ __('Guardado.') }}</p>
      @endif
    </div>
  </form>
</section>