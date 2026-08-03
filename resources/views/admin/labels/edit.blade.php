<button type="button" class="btn btn-primary my-1" data-bs-toggle="modal"
  data-bs-target="#editLabelModal{{ $label->id }}">
  Editar
</button>

<div class="modal fade" id="editLabelModal{{ $label->id }}" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
  role="dialog" aria-labelledby="editLabelModallabel{{ $label->id }}" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h3 class="modal-title fs-5" id="editLabelModallabel{{ $label->id }}">Editar etiqueta</h3>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <form action="{{ route('labels.update', $label) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="modal-body">
          <div class="mb-3">
            <label for="edit_name{{ $label->id }}" class="form-label">Nombre de la etiqueta</label>
            <input type="text" class="form-control" id="edit_name{{ $label->id }}" name="name"
              value="{{ old('name', $label->name) }}" required>
            @error('name')
            <div class="text-danger small mt-2">{{ $message }}</div>
            @enderror
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
          <button type="submit" class="btn btn-primary">Actualizar</button>
        </div>
      </form>
    </div>
  </div>
</div>