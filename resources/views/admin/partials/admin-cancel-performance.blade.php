<button
  type="button"
  class="btn cancelar btn-danger btn-sm"
  data-bs-toggle="modal"
  data-bs-target="#modalCancelarFuncion{{ $funcion->id }}">
  Cancelar función
</button>

<!-- Modal -->
<div class="modal fade" id="modalCancelarFuncion{{ $funcion->id }}" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-modal="true" aria-labelledby="modalCancelarFuncionLabel{{ $funcion->id }}" aria-hidden="true" role="dialog">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <form action="{{ route('performance.cancel', $funcion) }}" method="POST">
        @csrf
        @method('PATCH')

        <div class="modal-header header-morado">
          <h3 class="modal-title fs-4" id="modalCancelarFuncionLabel{{ $funcion->id }}}">
            <strong>Cancelar función</strong>
          </h3>
          <button type="button" class="btn-close" data-bs-theme="dark" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>


        <div class="modal-body text-start">
          <p class="mb-2 fs-5">¿Quieres cancelar la función del <strong>{{ \Carbon\Carbon::parse($funcion->fechaObra)->format('d/m/Y') }}</strong>?</p>
          <p>Selecciona el motivo.</p>
          <div class="my-5">
            <div class="form-check mb-3">
              <input class="form-check-input" type="radio" name="motivo" id="motivoProductor{{ $funcion->id }}" value="pedido_productor" required checked>
              <label class="form-check-label fw-bold" for="motivoProductor{{ $funcion->id }}">
                Solicitud del productor
              </label>
            </div>

            <div class="form-check mb-3">
              <input class="form-check-input" type="radio" name="motivo" id="motivoAdmin{{ $funcion->id }}" value="decision_admin" required>
              <label class="form-check-label fw-bold" for="motivoAdmin{{ $funcion->id }}">
                Decisión administrativa
              </label>
            </div>
          </div>
        </div>

        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
          <button class="btn borrar btn-danger" type="submit">Confirmar</button>
        </div>

      </form>
    </div>
  </div>
</div>