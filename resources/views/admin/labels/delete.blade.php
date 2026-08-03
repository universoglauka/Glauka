<button type="button" class="borrar btn btn-danger my-1" data-bs-toggle="modal"
  data-bs-target="#deleteLabelModal{{ $label->id }}">
  Eliminar
</button>

<div class="modal fade" id="deleteLabelModal{{ $label->id }}" data-bs-backdrop="static"
  data-bs-keyboard="false" tabindex="-1" role="dialog"
  aria-labelledby="deleteLabelModallabel{{ $label->id }}" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h3 class="modal-title fs-5" id="deleteLabelModallabel{{ $label->id }}">
          Eliminar etiqueta
        </h3>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <form action="{{ route('labels.destroy', $label) }}" method="POST">
        @csrf
        @method('DELETE')
        <div class="modal-body">
          <div class="mb-3">
            <label class="form-label fw-bold">Etiqueta:</label>
            <input type="text" class="form-control" value="{{ $label->name }}" disabled readonly>
            <small class="text-muted">
              Usuarios usando la etiqueta: {{ $label->users_count ?? 0 }}
            </small>
          </div>
          @if(($label->users_count ?? 0) > 0)
          <div class="alert alert-warning mt-2">
            Esta etiqueta tiene usuarios asociados. Al eliminarla, los usuarios podrían quedar sin este campo. <br> ¿Quieres eliminar de todos modos?.
          </div>
          @endif
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
          <button type="submit" class="borrar btn btn-danger">Eliminar</button>
        </div>
      </form>
    </div>
  </div>
</div>