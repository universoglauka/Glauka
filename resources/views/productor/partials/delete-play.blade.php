<button type="button" class="borrar btn btn-danger rounded-pill" data-bs-toggle="modal" data-bs-target="#modalEliminar{{ $obra->id }}">
  Eliminar
</button>

<div class="modal fade" id="modalEliminar{{ $obra->id }}" data-bs-backdrop="static" data-bs-keyboard="false" role="dialog"
  aria-modal="true" tabindex="-1" aria-labelledby="modalEliminarLabel{{ $obra->id }}" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <form action="{{ route('obras.destroy', $obra) }}" method="POST">
        @csrf
        @method('DELETE')

        <div class="modal-header header-morado">
          <h3 class="modal-title fs-4" id="modalEliminarLabel{{ $obra->id }}">
            <strong>Eliminar obra</strong>
          </h3>
          <button data-bs-theme="dark" type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>

        <div class="modal-body">
          <i class="bi bi-exclamation-circle display-3 my-4 d-block text-center text-danger"></i>
          <p class="mb-2 fs-5">¿Estás seguro de querer eliminar "{{ $obra->nombre_obra }}"?</p>
          <p class="text-danger">Esta acción no se puede deshacer.</p>
        </div>
        <div class="modal-footer">
          <div class="d-flex gap-2">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
            <button class="btn borrar btn-danger" type="submit">Eliminar</button>
          </div>
        </div>
      </form>
    </div>
  </div>
</div>