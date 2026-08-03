<button type="button" class="borrar btn btn-danger my-1" data-bs-toggle="modal"
  data-bs-target="#deleteGenreModal{{ $genre->id }}">
  Eliminar
</button>

<div class="modal fade" id="deleteGenreModal{{ $genre->id }}" data-bs-backdrop="static"
  data-bs-keyboard="false" tabindex="-1" role="dialog"
  aria-labelledby="deleteGenreModalLabel{{ $genre->id }}" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h3 class="modal-title fs-5" id="deleteGenreModalLabel{{ $genre->id }}">
          Eliminar género
        </h3>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <form action="{{ route('genres.destroy', $genre) }}" method="POST">
        @csrf
        @method('DELETE')
        <div class="modal-body">
          <div class="mb-3">
            <label class="form-label fw-bold">Género:</label>
            <input type="text" class="form-control" value="{{ $genre->name }}" disabled readonly>
            <small class="text-muted">
              Obras asociadas: {{ $genre->obras_count ?? 0 }}
            </small>
          </div>
          @if(($genre->obras_count ?? 0) > 0)
          <div class="alert alert-warning mt-2">
            Este género tiene obras asociadas. Al eliminarlo, las obras podrían quedar sin este campo. <br> ¿Quieres eliminar de todos modos?.
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