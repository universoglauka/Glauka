<button type="button" class="borrar btn btn-danger rounded-pill my-1" data-bs-toggle="modal" data-bs-target="#modalCancelar{{ $obra->id }}">
  Cancelar
</button>
<div class="modal fade" id="modalCancelar{{ $obra->id }}" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-modal="true" aria-labelledby="modalCancelLabel{{ $obra->id }}" aria-hidden="true" role="dialog">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <form action="{{ route('obras.cancel', $obra) }}" method="POST">
        @csrf
        @method('PATCH')

        <div class="modal-header header-morado">
          <h3 class="modal-title fs-4" id="modalCancelLabel{{ $obra->id }}">
            <strong>Cancelar obra</strong>
          </h3>
          <button type="button" class="btn-close" data-bs-theme="dark" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>


        <div class="modal-body text-start">
          <p class="mb-2 fs-5">¿Estás seguro de cancelar "{{ $obra->nombre_obra }}" de <strong>{{ $obra->productor->name_group ?? $obra->productor->user->name }}</strong>?</p>
          <p>Selecciona el motivo:</p>

          <div class="my-5">
            <div class="form-check mb-3">
              <input class="form-check-input" type="radio" name="motivo" id="motivoCancelProductor{{ $obra->id }}" value="pedido_productor" required checked>
              <label class="form-check-label fw-bold" for="motivoCancelProductor{{ $obra->id }}">
                Solicitud del productor
              </label>
            </div>

            <div class="form-check mb-3">
              <input class="form-check-input" type="radio" name="motivo" id="motivoCancelAdmin{{ $obra->id }}" value="decision_admin" required>
              <label class="form-check-label fw-bold" for="motivoCancelAdmin{{ $obra->id }}">
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