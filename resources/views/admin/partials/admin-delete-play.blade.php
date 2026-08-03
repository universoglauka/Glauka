<button type="button" class="borrar btn btn-danger rounded-pill" data-bs-toggle="modal" data-bs-target="#modalEliminar{{ $obra->id }}">
  Eliminar
</button>
<div class="modal fade" id="modalEliminar{{ $obra->id }}" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-modal="true" aria-labelledby="modalLabel{{ $obra->id }}" aria-hidden="true" role="dialog">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <form action="{{ route('obras.destroy', $obra) }}" method="POST">
        @csrf
        @method('DELETE')

        <div class="modal-header header-morado">
          <h3 class="modal-title fs-4" id="modalLabel{{ $obra->id }}">
            <strong>Eliminar obra</strong>
          </h3>
          <button type="button" class="btn-close" data-bs-theme="dark" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>


        <div class="modal-body text-start">
          <i class="bi bi-exclamation-circle display-3 my-4 d-block text-center text-danger"></i>
          <p class="mb-2 fs-5">¿Estás seguro de eliminar "{{ $obra->nombre_obra }}" del productor <strong>{{ $obra->productor->name_group ?? $obra->productor->user->name }}</strong>?</p>
          <p>Selecciona el motivo:</p>

          <div class="my-5">
            <div class="form-check mb-3">
              <input class="form-check-input" type="radio" name="motivo" id="motivoDeletePlayProductor{{ $obra->id }}" value="pedido_productor" required checked>
              <label class="form-check-label fw-bold" for="motivoDeletePlayProductor{{ $obra->id }}">
                Solicitud del productor
              </label>
            </div>

            <div class="form-check mb-3">
              <input class="form-check-input" type="radio" name="motivo" id="motivoDeletePlayAdmin{{ $obra->id }}" value="decision_admin" required>
              <label class="form-check-label fw-bold" for="motivoDeletePlayAdmin{{ $obra->id }}">
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