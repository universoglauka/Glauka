<button type="button" class="btn btn-primary my-1" data-bs-toggle="modal"
  data-bs-target="#editGenreModal{{ $genre->id }}">
  Editar
</button>

<div class="modal fade" id="editGenreModal{{ $genre->id }}" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
  role="dialog" aria-labelledby="editGenreModalLabel{{ $genre->id }}" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h3 class="modal-title fs-5" id="editGenreModalLabel{{ $genre->id }}">Editar género</h3>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <form action="{{ route('genres.update', $genre) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="modal-body">
          <div class="mb-3">
            <label for="edit_name{{ $genre->id }}" class="form-label">Nombre del género</label>
            <input type="text" class="form-control" id="edit_name{{ $genre->id }}" name="name"
              value="{{ old('name', $genre->name) }}" required>
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