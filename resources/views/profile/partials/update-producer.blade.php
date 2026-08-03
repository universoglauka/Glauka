<section class="tarjeta px-3 py-5 rounded-3 position-relative">
  <div>
    <h2 class="encabezadoRegistro fs-5 text-center position-absolute top-0 start-50 translate-middle px-4 py-2 rounded-5">
      {{ __('Actualizar datos de productor') }}
    </h2>

    <p class="mt-1 p-2">
      {{ __('Asegúrate de que tu cuenta utilice una contraseña larga y aleatoria para mantener la seguridad.') }}
    </p>
  </div>

  <form method="post" action="{{ isset($user) && auth()->user()->rol === 'admin' 
                                ? route('admin.profile.producer.update', $user)
                                : route('profile.producer.update') }}" class="mt-6 space-y-6">
    @csrf
    @method('patch')

    <div>
      <x-input-label for="name_group" :value="__('Nombre de grupo actual')" />
      <x-text-input id="name_group" name="name_group" type="text" class="mt-1 block w-full" :value="old('name_group', $user->productor->name_group)" />
      <x-input-error :messages="$errors->get('name_group')" class="mt-2" />
    </div>

    <div>
      <x-input-label for="alias" :value="__('Alias para recibir los pagos')" />
      <x-text-input id="alias" name="alias" type="text" class="mt-1 block w-full" :value="old('alias', $user->productor->alias)" />
      <x-input-error :messages="$errors->get('alias')" class="mt-2" />
    </div>

    <div>
      <x-input-label for="account_holder" :value="__('Titular de la cuenta para los pagos')" />
      <x-text-input id="account_holder" name="account_holder" type="text" class="mt-1 block w-full" :value="old('account_holder', $user->productor->account_holder)" />
      <x-input-error :messages="$errors->get('account_holder')" class="mt-2" />
    </div>

    <div>
      <x-input-label for="genre_id" value="Categoría" />
      <select id="genre_id" name="genre_id" class="form-select">
        <option value="">Seleccionar...</option>
        @foreach($genres as $genre)
        <option
          value="{{ $genre->id }}"
          {{ old('genre_id', $user->productor->genre_id ?? '') == $genre->id ? 'selected' : '' }}>
          {{ $genre->name }}
        </option>
        @endforeach
      </select>
      <x-input-error :messages="$errors->get('genre_id')" />
    </div>

    <div>
      <x-input-label for="description" :value="__('Descripción del grupo')" />
      <textarea id="description" name="description" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm"> {{old('description', $user->productor->description)}}</textarea>
      <x-input-error :messages="$errors->get('description')" class="mt-2" />
    </div>

    <div class="flex items-center gap-4">
      <x-primary-button>{{ __('Guardar') }}</x-primary-button>

      @if (session('status') === '-updated')
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