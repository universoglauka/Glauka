<section class="tarjeta px-3 py-5 rounded-3 position-relative">
  <div>
    <h2 class="encabezadoRegistro fs-5 text-center position-absolute top-0 start-50 translate-middle px-4 py-2 rounded-5">
      {{ __('Borrar cuenta') }}
    </h2>
    <div class="mb-3 text-danger">
      <i class="bi bi-exclamation-circle display-3 my-4 d-block text-center text-danger"></i>
    </div>
    <p class="mt-1 p-2 mb-3">
      {{ __('Una vez eliminada tu cuenta, todos sus recursos y datos se borrarán permanentemente. Antes de eliminarla, descarga cualquier dato o información que desees conservar.') }}
    </p>
  </div>

  <x-danger-button
    x-data=""
    x-on:click.prevent="$dispatch('open-modal', 'confirm-user-deletion')">{{ __('Borrar cuenta') }}</x-danger-button>

  <x-modal name="confirm-user-deletion" :show="$errors->userDeletion->isNotEmpty()" focusable>
    <form method="post" action="{{ route('profile.destroy') }}" class="p-7 pb-3 pt-3 px-5">
      @csrf
      @method('delete')

      <h2 class="text-lg font-medium text-gray-900 text-center">
        {{ __('¿Estás seguro que quieres borrar tu cuenta?') }}
      </h2>

      <p class="mt-1 text-sm text-gray-600">
        {{ __('Una vez eliminada tu cuenta, todos sus recursos y datos se borrarán permanentemente. Introduce tu contraseña para confirmar que deseas eliminar tu cuenta de forma permanente.') }}
      </p>

      <div class="mt-6">
        <x-input-label for="password" value="{{ __('Password') }}" class="sr-only" />

        <x-text-input
          id="password"
          name="password"
          type="password"
          class="mt-1 block w-3/4"
          placeholder="{{ __('Password') }}" />

        <x-input-error :messages="$errors->userDeletion->get('password')" class="mt-2" />
      </div>

      <div class="mt-6 flex justify-end">
        <x-secondary-button x-on:click="$dispatch('close')">
          {{ __('Cancel') }}
        </x-secondary-button>

        <button type="submit" class="btn btn-danger ms-3">
          {{ __('Borrar cuenta') }}
        </button>
      </div>
    </form>
  </x-modal>
</section>